<?php
namespace backend\Models;

use \PDO;
require_once __DIR__ . '/../model/Authenticator.php';
use backend\Models\Authenticator;

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
}