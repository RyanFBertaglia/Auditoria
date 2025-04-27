<?php
require_once '../includes/conexao_mongo.php';
session_start();

// Verifica se é uma submissão POST
//if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
 //   header('Location: login.html');
//exit();
//}

$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    echo "
<div style='
    display:grid;
    justify-content: center;
    font-family: \"system-ui\", \"Cambria\", \"sans-serif\";
'>
    <h1>Para fazer login voce deve preencher todos os campos</h1>
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

try {
    $usuarios = getUsuariosCollection();
    $usuario = $usuarios->findOne(['email' => $email]);

    if (!$usuario || !password_verify($senha, $usuario['senha'])) {
        echo "
        <div style='
            display:grid;
            justify-content: center;
            font-family: \"system-ui\", \"Cambria\", \"sans-serif\";
        '>
            <h1>Email ou senha errados</h1>
        </div>
        <div style='
            display: grid;
            justify-content: center;
            align-items: center;
            margin: 0;
        '>
            <button onclick=\"window.location.href='login.php'\" style=\"
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
                Preencha os campos corretamente
            </button>
        </div>
        ";
        exit();
    }

    // Armazena dados na sessão
    $_SESSION['usuario_id'] = (string)$usuario['_id'];
    $_SESSION['email'] = $email;
    $_SESSION['logado'] = true;

    // Redireciona para área protegida
    header('Location: ../../index.html');
    exit();

} catch (Exception $e) {
    error_log('Erro no login: ' . $e->getMessage());
    header('Location: login.html?erro=Erro no sistema. Tente novamente.');
    exit();
}