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
    $nome = $_POST['nome'];

    $users = new Users($pdo);
    $repo = new UserController($users);

    $repo->register([
        'email' => $email,
        'senha' => $senha,
        'nome' => $nome
    ]);

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

    <button type="button" class="btn-voltar" onclick="history.back()">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
        <line x1="19" y1="12" x2="5" y2="12"></line>
        <polyline points="12 19 5 12 12 5"></polyline>
    </svg>
    Voltar
    </button>
    
    <form action="/register" method="POST">
        <h1>Cadastre-se</h1>
        <input type="email" name="email" required placeholder="E-mail" />
        <input type="text" name="nome" required placeholder="Nome" />
        <input type="password" name="senha" required placeholder="Senha" />
        <button type="submit">Cadastrar</button>
        <a href="/register">Já possui uma conta? Login</a>

    </form>
</body>
</html>
