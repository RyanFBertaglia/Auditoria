<?php
require_once '../includes/conexao_mongo.php'; // Arquivo com suas funções de conexão
header('Content-Type: text/html; charset=UTF-8');

try {
    // Obtém a coleção e busca os posts mais recentes
    $colecaoPosts = getPostsCollection();
    $opcoes = [
        'limit' => 50,
        'sort'  => ['data' => -1]
    ];
    $posts = $colecaoPosts->find([], $opcoes);
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Posts Cadastrados</title>
        <style>
            .post { 
                border: 1px solid #ddd; 
                margin: 15px 0; 
                padding: 15px; 
                border-radius: 5px;
                background-color: #f9f9f9;
            }
            .post-header { 
                font-weight: bold; 
                margin-bottom: 10px;
                color: #005A8D;
            }
            .post-content {
                margin: 10px 0;
                line-height: 1.6;
            }
            .post-images {
                margin-top: 15px;
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
            .post-image {
                max-width: 300px;
                max-height: 300px;
                border: 1px solid #eee;
                border-radius: 4px;
            }
            .post-date { 
                color: #666; 
                font-size: 0.9em;
                margin-top: 10px;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }
            h1 {
                color: #005A8D;
                border-bottom: 2px solid #A3D5E6;
                padding-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Posts Cadastrados</h1>

            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <div class="post-header">
                        Publicado por: <?= htmlspecialchars($post['email'] ?? 'N/A') ?>
                    </div>

                    <?php if (!empty($post['nome'])): ?>
                        <h2><?= htmlspecialchars($post['nome']) ?></h2>
                    <?php endif; ?>

                    <div class="post-content">
                        <?= nl2br(htmlspecialchars($post['descricao'] ?? '')) ?>
                    </div>

                    <?php if (!empty($post['imagens'])):
                        // Exibe imagem única salva em 'imagem'
                        $bin  = base64_decode($post['imagens']);
                        $mime = (new finfo(FILEINFO_MIME_TYPE))->buffer($bin);
                    ?>
                        <div class="post-images">
                            <img
                                src="data:<?= $mime ?>;base64,<?= $post['imagens'] ?>"
                                alt="Imagem do post"
                                class="post-image"
                            />
                        </div>
                    <?php endif; ?>

                    <?php if (isset($post['data'])):
                        // Formatação da data (BSON ou string)
                        if ($post['data'] instanceof MongoDB\BSON\UTCDateTime) {
                            $dt = $post['data']->toDateTime();
                        } else {
                            $dt = new DateTime($post['data']);
                        }
                        $dataFormatada = $dt->format('d/m/Y H:i:s');
                    ?>
                        <div class="post-date">
                            Postado em: <?= htmlspecialchars($dataFormatada) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </div>
    </body>
    </html>
    <?php
} catch (Exception $e) {
    echo "<div style='color:red; padding:20px;'>Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>
