<?php
namespace backend\Controller;
require_once __DIR__ . '/../model/Comentario.php';

use backend\Models\Comentario;

class ComentarioController {
    private $comentarioModel;
    
    public function __construct($pdo) {
        $this->comentarioModel = new Comentario($pdo);
    }
        
    public function adicionarComentario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idPost = (int)$_POST['idPost'];
            $email = trim($_POST['email']);
            $comentario = trim($_POST['comentario']);
            
            $erros = [];
            
            if (empty($email)) {
                $erros[] = "Email é obrigatório";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erros[] = "Email inválido";
            }
            
            if (empty($comentario)) {
                $erros[] = "Comentário é obrigatório";
            } elseif (strlen($comentario) < 5) {
                $erros[] = "Comentário deve ter pelo menos 5 caracteres";
            }
            
            if (empty($erros)) {
                if ($this->comentarioModel->criarComentario($idPost, $email, $comentario)) {
                    header("Location: /comentar?id=$idPost&sucesso=Comentário adicionado com sucesso!");
                } else {
                    header("Location: /comentar?id=$idPost&erro=Erro ao adicionar comentário");
                }
            } else {
                $_SESSION['erro'] = implode(', ', $erros);
                header("Location: /erro");
            }
            exit();
        }
    }
    
    public function deletarComentario() {
        if (isset($_GET['deletar']) && !empty($_GET['deletar'])) {
            $idComentario = (int)$_GET['deletar'];
            $idPost = (int)$_GET['id'];
            
            if ($this->comentarioModel->deletarComentario($idComentario)) {
                header("Location: /comentarios?post_id=$idPost");
            } else {
                $_SESSION['erro'] = "Erro ao deletar comentário";
            }
            exit();
        }
    }
}