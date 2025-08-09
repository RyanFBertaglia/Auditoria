<?php
namespace backend\Models;

interface Authenticator {
    public function authenticate($email, $senha);
    public function saveSession($email);
    public function create(array $data);
    public function findByEmail($email);
}

?>