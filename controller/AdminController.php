<?php
namespace backend\Controller;

require_once __DIR__ . '/../model/Admin.php';
use backend\Models\Admin;
use Exception;

class AdminController {
    private $admin;

    public function __construct(Admin $admin) {
        $this->admin = $admin;
    }

    public function responder(array $resposta, array $fotos) {
        
        try {
            $enderecoFotos = $this->admin->salvarFoto($fotos);
            $resposta["imagens"] = !empty($enderecoFotos) ? json_encode($enderecoFotos, JSON_UNESCAPED_SLASHES) : null;
        } catch (Exception $e) {
            $_SESSION['erro'] = "Erro ao salvar fotos: " . $e->getMessage();
            header('Location: /admin/posts');
            exit;
        }
        
        $this->admin->responderUser($resposta);
        $_SESSION['sucesso'] = "Resposta enviada com sucesso!";
        header('Location: /admin/posts');
    }
}

?>