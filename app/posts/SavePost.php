<?php
session_start();
require_once 'includes/env.php';
loadEnv(__DIR__ . '/.env');

require 'vendor/autoload.php';

$email = $_SESSION['email'] ?? null;

if (!$email) {
    die("Usuário não autenticado.");
}

$descricao = $_POST['descricao'] ?? '';
$data = date('Y-m-d H:i:s');

// Processar imagem
$imagemBase64 = null;
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $imagemTmp = $_FILES['imagem']['tmp_name'];
    $imagemConteudo = file_get_contents($imagemTmp);
    $imagemBase64 = base64_encode($imagemConteudo);
}

// Conexão com MongoDB
try {
    $client = new MongoDB\Client($_ENV['MONGO_API_KEY']);
    $mongoDB = $client->selectDatabase($_ENV['MONGO_DB']);
    $colecao = $mongoDB->selectCollection($_ENV['MONGO_COLLECTION']);

    $colecao->insertOne([
        'email' => $email,
        'descricao' => $descricao,
        'imagem' => $imagemBase64,
        'data' => $data
    ]);

    echo "Post salvo com sucesso!";
} catch (Exception $e) {
    die("Erro ao salvar post: " . $e->getMessage());
}
?>
