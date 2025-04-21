<?php
require_once '../includes/conexao_usuario.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    die("Preencha todos os campos.");
}

$usuarios = getUsuarioCollection();
$usuario = $usuarios->findOne(['email' => $email]);

if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    die("Email ou senha inválidos.");
}

echo "Login bem-sucedido! Agora você pode enviar denúncias.";
