<?php
require_once '../includes/conexao_usuario.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    die("Preencha todos os campos.");
}

$usuarios = getUsuarioCollection();

$existe = $usuarios->findOne(['email' => $email]);

if ($existe) {
    die("Email já cadastrado.");
}

$hash = password_hash($senha, PASSWORD_BCRYPT);

$usuarios->insertOne([
    'email' => $email,
    'senha' => $hash
]);

$_SESSION['email'] = $email;
echo "Cadastro realizado com sucesso! <a href='login.html'>Ir para login</a>";
