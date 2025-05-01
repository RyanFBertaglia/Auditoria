<?php
require_once './app/includes/conexao_mongo.php';
header('Content-Type: text/html; charset=UTF-8');

try {
    $colecaoPosts = getPostsCollection();
    $opcoes = ['limit' => 50, 'sort' => ['data' => -1]];
    $posts = $colecaoPosts->find([], $opcoes);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Cadastrados</title>
    <link rel="stylesheet" href="static/css/dash.css">
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

            <?php 
            if (!empty($post['imagens'])) {
                // BSONArray -> array se necessário
                $imagens = ($post['imagens'] instanceof MongoDB\Model\BSONArray)
                    ? $post['imagens']->getArrayCopy()
                    : $post['imagens'];
                
                if (!empty($imagens)) {
                    $galleryId = 'gallery-' . (isset($post['_id']) ? (string)$post['_id'] : uniqid());
                    $totalImagens = count($imagens);
            ?>
                    <div class="gallery-container" id="<?= $galleryId ?>">
                        <?php foreach ($imagens as $index => $imagemObj): 
                            $imagem = ($imagemObj instanceof MongoDB\Model\BSONDocument)
                                ? $imagemObj->getArrayCopy()
                                : $imagemObj;
                            
                            if (!empty($imagem['dados']) && is_string($imagem['dados'])): 
                                $dadosLimpos = preg_replace('/[^a-zA-Z0-9\+\/=]/', '', $imagem['dados']);
                                $mime = $imagem['tipo'] ?? 'image/jpeg';
                        ?>
                            <div class="mySlides">
                                <div class="numbertext"><?= ($index + 1) ?> / <?= $totalImagens ?></div>
                                <img src="data:<?= $mime ?>;base64,<?= $dadosLimpos ?>" 
                                     alt="Imagem <?= ($index + 1) ?> do post">
                            </div>
                        <?php endif; endforeach; ?>

                        <a class="prev" onclick="plusSlides('<?= $galleryId ?>', -1)">&#10094;</a>
                        <a class="next" onclick="plusSlides('<?= $galleryId ?>', 1)">&#10095;</a>

                        <div class="caption-container">
                            <p class="caption"></p>
                        </div>

                        <!-- Miniaturas -->
                        <div class="row">
                            <?php foreach ($imagens as $index => $imagemObj): 
                                $imagem = ($imagemObj instanceof MongoDB\Model\BSONDocument)
                                    ? $imagemObj->getArrayCopy()
                                    : $imagemObj;
                                
                                if (!empty($imagem['dados']) && is_string($imagem['dados'])): 
                                    $dadosLimpos = preg_replace('/[^a-zA-Z0-9\+\/=]/', '', $imagem['dados']);
                                    $mime = $imagem['tipo'] ?? 'image/jpeg';
                            ?>
                                <div class="column">
                                    <img class="demo cursor" 
                                         src="data:<?= $mime ?>;base64,<?= $dadosLimpos ?>" 
                                         onclick="currentSlide('<?= $galleryId ?>', <?= ($index + 1) ?>)">
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
            <?php 
                }
            }
            ?>

            <?php if (isset($post['data'])):
                if ($post['data'] instanceof MongoDB\BSON\UTCDateTime) {
                    $dt = $post['data']->toDateTime();
                    $dataFormatada = $dt->format('d/m/Y H:i:s');
                } else {
                    $dataFormatada = date('d/m/Y H:i:s', strtotime($post['data']));
                }
            ?>
                <div class="post-date">
                    Postado em: <?= htmlspecialchars($dataFormatada) ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<script src="./static/js/galeria.js"></script>
</body>
</html>
<?php
} catch (Exception $e) {
    echo "<div style='color:red; padding:20px;'>Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>