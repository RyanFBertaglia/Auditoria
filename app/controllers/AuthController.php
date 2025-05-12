<?php
namespace App\Controllers;

use App\Models\User;

class AuthController
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        // Inicia sessão ao instanciar o controller
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = $userModel;
    }

    /**
     * Exibe o formulário de login
     */
    public function showLogin(): void
    {
        require __DIR__ . './../views/auth/login.php';
    }

    /**
     * Processa o login
     */
    public function login(): void
    {
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $senha = $_POST['senha'] ?? '';

        if (!$email || !$senha) {
            $this->renderError('Para fazer login você deve preencher todos os campos', '/login');
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($senha, $user['senha'])) {
            $this->renderError('Email ou senha incorretos', '/login');
        }

        // Dados válidos: configura sessão
        $_SESSION['usuario_id']         = (string)$user['_id'];
        $_SESSION['email']              = $email;
        $_SESSION['logado']             = true;
        $_SESSION['session_start_time'] = time();

        // Redireciona ao dashboard/principal
        $urlBase = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header("Location: $urlBase/");
        //header('Location: /');
        exit;
    }

    /**
     * Exibe o formulário de cadastro
     */
    public function showRegister(): void
    {
        require __DIR__ . '/../views/auth/register.php';
    }

    /**
     * Processa o cadastro de novo usuário
     */
    public function register(): void
    {
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $senha = $_POST['senha'] ?? '';

        if (!$email || !$senha) {
            $this->renderError('Para cadastrar você deve preencher todos os campos', '/register');
        }

        if ($this->userModel->findByEmail($email)) {
            $this->renderError('Email já cadastrado', '/register');
        }

        // Cria hash seguro e salva
        $hash = password_hash($senha, PASSWORD_BCRYPT);
        $this->userModel->create([
            'email' => $email,
            'senha' => $hash
        ]);

        header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/Auditoria/login');
        exit;
    }

    /**
     * Renderiza a view de erro genérica
     */
    private function renderError(string $message, string $redirect): void
    {
        // A view error.php utiliza as variáveis $message e $redirect
        require __DIR__ . '/../views/auth/error.php';
        exit;
    }
}
