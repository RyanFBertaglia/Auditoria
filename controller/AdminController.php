<?php
namespace backend\Controller;

require_once __DIR__ . '/../model/Admin.php';
use backend\Models\Admin;
use Exception;

class AdminController {
    private $admin;

    public function __construct(Admin $admin) {
        $this->$admin;
    }

    public function responder(array $resposta, array $fotos) {
        $this->admin->responderUser($resposta);
        try {
            $this->admin->salvarFoto($fotos);
        } catch (Exception $e) {
            $_SESSION['erro'] = "Erro ao salvar fotos: " . $e->getMessage();
            header('Location: /admin/posts');
            exit;
        }
        $_SESSION['sucesso'] = "Resposta enviada com sucesso!";
        header('Location: /admin/posts');
    }
}

?>