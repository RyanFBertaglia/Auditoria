<?php

session_start();
require '../includes/conexao_mongo.php';
require '../../vendor/autoload.php';

$email = $_SESSION['email'] ?? null;

if (!$email) {
    die("Usuário não autenticado.");
}

$nome = $_POST['name'];
$descricao = $_POST['descricao'] ?? '';
$data = date('Y-m-d H:i:s');

// Processar imagem
$imagensProcessadas = [];

if (!empty($_FILES['imagem']['tmp_name'][0])) {
    foreach ($_FILES['imagem']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['imagem']['error'][$key] !== UPLOAD_ERR_OK) {
            continue;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $tmp_name);
        finfo_close($finfo);

        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mime, $tiposPermitidos)) {
            continue;
        }
        if ($_FILES['imagem']['size'][$key] > 5 * 1024 * 1024) {
            continue;
        }

        // Converter para base64
        $imagemData = file_get_contents($tmp_name);
        $base64 = base64_encode($imagemData);

        $imagensProcessadas[] = [
            'nome' => $_FILES['imagem']['name'][$key],
            'tipo' => $mime,
            'dados' => $base64,
            'tamanho' => $_FILES['imagem']['size'][$key]
        ];
    }
}

// Conexão com MongoDB
try {
    $colecao = getPostsCollection();
    $resultado = $colecao->insertOne([
        'email' => $email,
        'nome' => $nome,
        'descricao' => $descricao,
        'imagens' => $imagensProcessadas,
        'data' => $data
    ]);

    echo "Post salvo com sucesso!";
} catch (Exception $e) {
    die("Erro ao salvar post: " . $e->getMessage());
}
?>
