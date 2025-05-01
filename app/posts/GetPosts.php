<?php
require_once '../includes/conexao_mongo.php';
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
    <style>
        * {
            box-sizing: border-box;
        }
        
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
        
        /* Estilos da galeria */
        .gallery-container {
            position: relative;
            margin: 20px 0;
        }
        
        .mySlides {
            display: none;
            text-align: center;
        }
        
        .mySlides img {
            max-height: 500px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            border-radius: 4px;
        }
        
        .cursor {
            cursor: pointer;
        }
        
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            border-radius: 0 3px 3px 0;
            user-select: none;
            -webkit-user-select: none;
            background-color: rgba(0, 90, 141, 0.7);
        }
        
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }
        
        .prev:hover, .next:hover {
            background-color: #005A8D;
        }
        
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
            background-color: rgba(0, 90, 141, 0.7);
            border-radius: 0 0 3px 0;
        }
        
        .caption-container {
            text-align: center;
            background-color: #222;
            padding: 10px 16px;
            color: white;
            margin-top: 5px;
            border-radius: 0 0 4px 4px;
        }
        
        .row {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding: 10px 0;
            gap: 5px;
        }
        
        .column {
            flex: 0 0 16.66%;
            max-width: 16.66%;
        }
        
        .demo {
            opacity: 0.6;
            height: 50px;
            object-fit: cover;
            width: 100%;
            border-radius: 3px;
        }
        
        .active, .demo:hover {
            opacity: 1;
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

            <?php 
            if (!empty($post['imagens'])) {
                // Converte BSONArray para array se necessário
                $imagens = ($post['imagens'] instanceof MongoDB\Model\BSONArray)
                    ? $post['imagens']->getArrayCopy()
                    : $post['imagens'];
                
                if (!empty($imagens)) {
                    $galleryId = 'gallery-' . (isset($post['_id']) ? (string)$post['_id'] : uniqid());
                    $totalImagens = count($imagens);
            ?>
                    <div class="gallery-container" id="<?= $galleryId ?>">
                        <!-- Slides principais -->
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

                        <!-- Botões de navegação -->
                        <a class="prev" onclick="plusSlides('<?= $galleryId ?>', -1)">&#10094;</a>
                        <a class="next" onclick="plusSlides('<?= $galleryId ?>', 1)">&#10095;</a>

                        <!-- Legenda -->
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
                                         onclick="currentSlide('<?= $galleryId ?>', <?= ($index + 1) ?>)"
                                         alt="Imagem <?= ($index + 1) ?> do post">
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

<script>
// Inicializa todas as galerias
document.addEventListener('DOMContentLoaded', function() {
    const galleries = document.querySelectorAll('.gallery-container');
    galleries.forEach(gallery => {
        const id = gallery.id;
        window[`slideIndex_${id}`] = 1;
        showSlides(id, 1);
    });
});

// Next/previous controls
function plusSlides(galleryId, n) {
    showSlides(galleryId, window[`slideIndex_${galleryId}`] += n);
}

// Thumbnail image controls
function currentSlide(galleryId, n) {
    showSlides(galleryId, window[`slideIndex_${galleryId}`] = n);
}

function showSlides(galleryId, n) {
    const gallery = document.getElementById(galleryId);
    let i;
    const slides = gallery.getElementsByClassName("mySlides");
    const dots = gallery.getElementsByClassName("demo");
    const captionText = gallery.querySelector(".caption");
    
    // Verifica os limites
    if (n > slides.length) { window[`slideIndex_${galleryId}`] = 1 }
    if (n < 1) { window[`slideIndex_${galleryId}`] = slides.length }
    
    // Esconde todos os slides
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    
    // Remove a classe 'active' de todas as miniaturas
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    
    // Mostra o slide atual e ativa a miniatura correspondente
    slides[window[`slideIndex_${galleryId}`]-1].style.display = "block";
    if (dots.length > 0) {
        dots[window[`slideIndex_${galleryId}`]-1].className += " active";
        captionText.innerHTML = dots[window[`slideIndex_${galleryId}`]-1].alt;
    }
}
</script>
</body>
</html>
<?php
} catch (Exception $e) {
    echo "<div style='color:red; padding:20px;'>Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>