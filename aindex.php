<?php
require_once '../app/includes/conexao_mongo.php';

$posts = getPostsCollection()->find([], ['sort' => ['data' => -1]]); // ordena do mais recente para o mais antigo

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Denúncias Ambientais</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 24px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #2c3e50;
        }
        .post {
            background: #fff;
            border: 1px solid #ddd;
            padding: 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            max-width: 700px;
        }
        .post img {
            max-width: 100%;
            border-radius: 6px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Denúncias Ambientais</h1>
    <p>Veja aqui todas as denúncias feitas pelos cidadãos.</p>

    <?php foreach ($posts as $post): ?>
        <div class="post">
            <strong>Data:</strong> <?= htmlspecialchars($post['data'] ?? 'Sem data') ?><br>
            <strong>Descrição:</strong><br>
            <p><?= nl2br(htmlspecialchars($post['descricao'] ?? '')) ?></p>
            <?php if (!empty($post['imagem'])): ?>
                <img src="data:image/jpeg;base64,<?= $post['imagem'] ?>" alt="Imagem da denúncia">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
