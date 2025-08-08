<?php
namespace backend\Models;

use \PDO;
require_once __DIR__ . '/../model/Authenticator.php';
use backend\Models\Authenticator;
use Exception;

class Admin implements Authenticator {

    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findAdmin() {
        $admin = "prefeitura@gmail.com";
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $admin);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function authenticate($email, $senha) {
        $user = $this->findAdmin();
        if ($user && password_verify($senha, $user['senha'])) {
            return $user;
        }
        return null;
    }

    function saveSession($email) {
        $_SESSION['logado'] = true;
        $_SESSION['admin'] = true;
        $_SESSION['email'] = $email;
        header("Location: /admin/posts");
    }

    function create($data) {
        return;
    }

    function responderUser(array $resposta) {
        $statement = $this->pdo->prepare("INSERT INTO resposta (id, resolucao, imagens) values (:id, :resolucao, :imagens)");
        $statement->bindParam(':id', $resposta['id']);
        $statement->bindParam(':resolucao', $resposta['resolucao']);
        $statement->bindParam(':imagens', $resposta['imagens']);
        $statement->execute();
        return $statement->rowCount() > 0;
    }

    function salvarFoto(array $arquivos) {
        $uploadDir = './uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $imagens = [];

            if (!empty($arquivos['imagens']) && is_array($arquivos['imagens']['tmp_name'])) {
                $total = count($arquivos['imagens']['tmp_name']);
                $total = min($total, 5);

                for ($i = 0; $i < $total; $i++) {
                    if ($arquivos['imagens']['error'][$i] === UPLOAD_ERR_OK) {
                        $tmp = $arquivos['imagens']['tmp_name'][$i];
                        $name = basename($arquivos['imagens']['name'][$i]);
                        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                        $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                        if (!in_array($ext, $permitidos)) {
                            throw new Exception("Tipo de imagem não permitido: $ext");
                        }

                        $novoNome = uniqid('img_') . "." . $ext;
                        $destino = $uploadDir . $novoNome;

                        if (move_uploaded_file($tmp, $destino)) {
                            $imagens[] = './uploads/' . $novoNome;
                        } else {
                            throw new Exception("Falha ao mover o arquivo $name.");
                        }
                    }
                }
            }
    }

}