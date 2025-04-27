<?php
require_once '../includes/conexao_mongo.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    echo "
<div style='
    display:grid;
    justify-content: center;
    font-family: \"system-ui\", \"Cambria\", \"sans-serif\";
'>
    <h1>Para fazer o cadastro voce deve preencher todos os campos</h1>
</div>
<div style='
    display: grid;
    justify-content: center;
    align-items: center;
    margin: 0;
'>
    <button onclick=\"window.location.href='../../login.php'\" style=\"
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-size: 16px;
        cursor: pointer;
        transition: all 0.9s ease;
    \">
        Preencher os campos corretamente
    </button>
</div>
";
    exit();
}

$usuarios = getUsuariosCollection();

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
header("Location: ../../login.php");

