<?php
require_once '../includes/conexao_mongo.php';
session_start();

// Verifica se é uma submissão POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit();
}

$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    header('Location: login.html?erro=Preencha todos os campos');
    exit();
}

try {
    $usuarios = getUsuariosCollection();
    $usuario = $usuarios->findOne(['email' => $email]);

    if (!$usuario || !password_verify($senha, $usuario['senha'])) {
        header('Location: login.html?erro=Email ou senha inválidos');
        exit();
    }

    // Armazena dados na sessão
    $_SESSION['usuario_id'] = (string)$usuario['_id'];
    $_SESSION['email'] = $email;
    $_SESSION['logado'] = true;

    // Redireciona para área protegida
    header('Location: index.php');
    exit();

} catch (Exception $e) {
    error_log('Erro no login: ' . $e->getMessage());
    header('Location: login.html?erro=Erro no sistema. Tente novamente.');
    exit();
}