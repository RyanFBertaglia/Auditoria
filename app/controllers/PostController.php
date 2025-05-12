<?php
namespace App\Controllers;

use App\Models\Post;

class PostController
{
    private Post $postModel;

    public function __construct(Post $postModel)
    {
        // Inicia sessão para garantir que o usuário esteja autenticado
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }   
        $this->postModel = $postModel;
    }

    /**
     * Exibe a lista de posts no dashboard
     */
    public function index(): void
    {
        $posts = $this->postModel->getAll();
        require __DIR__ . '/../views/posts/index.php';
    }

    /**
     * Exibe o formulário de criação de post
     */
    public function create(): void
    {
        require __DIR__ . '/../views/posts/create.php';
    }

    /**
     * Processa e salva um novo post
     */
    public function store()
    {
        // Redireciona para login se não estiver autenticado
        if (empty($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }

        $email      = $_SESSION['email'];
        $nome       = $_POST['name'] ?? '';
        $descricao  = $_POST['descricao'] ?? '';

        // Validação de tamanho
        if (mb_strlen($descricao) > 1000) {
            $_GET['erro'] = 'Descrição excede 1000 caracteres';
            return $this->create();
        }

        $data     = date('Y-m-d H:i:s');
        $imagens  = [];

        // Processa uploads de imagem
        foreach ($_FILES['imagem']['tmp_name'] as $key => $tmpName) {
            if (empty($tmpName) || $_FILES['imagem']['error'][$key] !== UPLOAD_ERR_OK) {
                continue;
            }

            $mime = mime_content_type($tmpName);
            $size = $_FILES['imagem']['size'][$key];
            $permitidos = ['image/jpeg', 'image/png', 'image/gif'];

            if (!in_array($mime, $permitidos) || $size > 5 * 1024 * 1024) {
                continue;
            }

            $dados = base64_encode(file_get_contents($tmpName));
            $imagens[] = [
                'nome'  => $_FILES['imagem']['name'][$key],
                'tipo'  => $mime,
                'dados' => $dados,
                'tamanho' => $size
            ];
        }

        // Insere no MongoDB
        $this->postModel->create([
            'email'     => $email,
            'nome'      => $nome,
            'descricao' => $descricao,
            'imagens'   => $imagens,
            'data'      => $data
        ]);

        // Volta ao dashboard
        header('Location: /');
        exit;
    }
}
