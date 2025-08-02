<?php
namespace backend\Controller;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../model/Authenticator.php';
use backend\Models\Authenticator as ModelAuthenticator;

class UserController {
    private $users;

    public function __construct(ModelAuthenticator $users) {
        $this->users = $users;
    }

    function login($email, $senha) {
        if($this->users->authenticate($email, $senha)) {
            $this->users->saveSession($email);
        } else {
            $_SESSION['erro'] = "Email ou senha incorretos.";
            header("Location: /erro");
            exit;
        }
    }

    function register(array $data) {  
        if($this->users->create($data)) {
            $this->users->saveSession($data['email']);
        } else {
            $_SESSION['erro'] = "Email ou senha incorretos.";
            header("Location: /erro");
            exit;
        }
    }

}