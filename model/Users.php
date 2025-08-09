<?php
namespace backend\Models;

use \PDO;
require_once __DIR__ . '/../model/Authenticator.php';
use backend\Models\Authenticator;

class Users implements Authenticator {

    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create(array $data) {
        if ($this->findByEmail($data['email'])) {
            $_SESSION['erro'] = "Email já cadastrado.";
            header("Location: /erro");
        }

        $hash = password_hash($data['senha'], PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (email, senha, nome) VALUES (:email, :senha, :nome)");
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':senha', $hash);
        $stmt->bindParam(':nome', $data['nome']);
        return $stmt->execute();
    }

    public function authenticate($email, $senha) {
        $user = $this->findByEmail($email);
        if ($user && password_verify($senha, $user['senha'])) {
            return $user;
        }
        return null;
    }

    function saveSession($email) {
            $user = $this->findByEmail($email);
            $_SESSION['logado'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header("Location: /home");
    }

}