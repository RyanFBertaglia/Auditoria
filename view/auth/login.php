<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = require __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../model/Users.php';
require_once __DIR__ . '/../../controller/UserController.php';

use backend\Models\Users;
use backend\Controller\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $users = new Users($pdo);
    $repo = new UserController($users);

    $repo->login($email, $senha);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="./view/static/style/auth.css">
</head>
<body>
    <?php if (!empty($erro)): ?>
        <p style="color:red"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form action="/login" method="POST">
        <h1>Login</h1>
        <input type="email" name="email" required placeholder="E-mail" />
        <input type="password" name="senha" required placeholder="Senha" />
        <button type="submit">Entrar</button>
        <a href="/register">Não tem conta ainda? Cadastre-se</a>
    </form>
</body>
</html>
