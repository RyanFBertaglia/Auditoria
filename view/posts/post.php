<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = require __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../model/Posts.php';
require_once __DIR__ . '/../../controller/PostController.php';
require_once __DIR__ . '/../../model/Comentario.php';

use backend\Models\Posts;
use backend\Controller\PostController;
use backend\Models\Comentario;




if (!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
    $_SESSION['erro'] = "Post inválido.";
    header("Location: /minha-conta");
    exit;
}
$postId = $_GET['post_id'];


$postsModel = new Posts($pdo);
$controller = new PostController($postsModel);
$comentarioModel = new Comentario($pdo);

try {
    $post = $controller->findById((int)$postId);

    if (!$post) {
        $_SESSION['erro'] = "Post não encontrado.";
        header("Location: /erro");
        exit;
    }

    $totalComentarios = $comentarioModel->contarComentarios($postId);

    $imagens = [];
    if (!empty($post['imagens'])) {
        $imagensDecoded = json_decode($post['imagens'], true);
        if (is_array($imagensDecoded)) {
            foreach ($imagensDecoded as $caminho) {
                if (!empty(trim($caminho))) {
                    $caminho = ltrim($caminho, './');
                    $caminho = "../" . $caminho;
                    $imagens[] = trim($caminho);
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Post</title>
    <style>
        .voltar {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }


    </style>
    <link rel="stylesheet" href="/view/static/style/posts.css">
</head>
<body>
<?php include './view/static/elements/nav.php'; ?>

<div class="container">
    <br><br>
    <h1><?= htmlspecialchars($post['titulo'] ?? 'Post sem título') ?></h1>
    <div class="post">
        <div class="post-header">
            Publicado por: <?= htmlspecialchars($post['email'] ?? 'Usuário não informado') ?>
        </div>

        <div class="post-content">
            <?= nl2br(htmlspecialchars($post['descricao'] ?? '')) ?>
        </div>

        <?php if (!empty($imagens)): ?>
            <?php if (count($imagens) === 1): ?>
                <div class="single-image">
                    <img src="<?= htmlspecialchars($imagens[0]) ?>" alt="Imagem do post">
                </div>
            <?php else: ?>
                <div class="gallery-container" id="gallery-post">
                    <?php foreach ($imagens as $index => $caminho): ?>
                        <div class="mySlides<?= $index === 0 ? ' active' : '' ?>">
                            <div class="numbertext"><?= ($index + 1) ?> / <?= count($imagens) ?></div>
                            <img src="<?= htmlspecialchars($caminho) ?>" alt="Imagem <?= ($index + 1) ?>">
                        </div>
                    <?php endforeach; ?>
                    <a class="prev" onclick="plusSlides('gallery-post', -1)">&#10094;</a>
                    <a class="next" onclick="plusSlides('gallery-post', 1)">&#10095;</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="no-image">Nenhuma imagem disponível</div>
        <?php endif; ?>

        <div class="buttons">
            <button class="btn" onclick="window.location.href='/comentarios?post_id=<?= $postId ?>'">
                Ver comentários<?php if($totalComentarios > 0): ?> (<?= $totalComentarios ?>)<?php endif; ?>
            </button>
        </div>

        <?php if (!empty($post['data_postagem'])): ?>
            <div class="post-date">
                Postado em: <?= date('d/m/Y H:i:s', strtotime($post['data_postagem'])) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($post['resolvido']) && $post['resolvido'] == 1): ?>
            <div class="post-status">
                ✅ Este post foi marcado como resolvido
            </div>
            <?php
            $resposta = $post = $controller->getAdminResponse($postId);

$imagensResposta = [];
if (!empty($resposta['imagens'])) {
    $imagensDecoded = json_decode($resposta['imagens'], true);
    if (is_array($imagensDecoded)) {
        foreach ($imagensDecoded as $caminho) {
            if (!empty(trim($caminho))) {
                $caminho = ltrim($caminho, './');
                $caminho = "../" . $caminho;
                $imagensResposta[] = trim($caminho);
            }
        }
    }
}
?>

<?php if ($resposta): ?>
    <div class="resolucao">
        <h2>Resolução do Administrador</h2>
        <div class="post-content">
            <?= nl2br(htmlspecialchars($resposta['resolucao'] ?? '')) ?>
        </div>

        <?php if (!empty($imagensResposta)): ?>
            <?php if (count($imagensResposta) === 1): ?>
                <div class="single-image">
                    <img src="<?= htmlspecialchars($imagensResposta[0]) ?>" alt="Imagem da resolução">
                </div>
            <?php else: ?>
                <div class="gallery-container" id="gallery-resolucao">
                    <?php foreach ($imagensResposta as $index => $caminho): ?>
                        <div class="mySlides<?= $index === 0 ? ' active' : '' ?>">
                            <div class="numbertext"><?= ($index + 1) ?> / <?= count($imagensResposta) ?></div>
                            <img src="<?= htmlspecialchars($caminho) ?>" alt="Imagem <?= ($index + 1) ?>">
                        </div>
                    <?php endforeach; ?>
                    <a class="prev" onclick="plusSlides('gallery-resolucao', -1)">&#10094;</a>
                    <a class="next" onclick="plusSlides('gallery-resolucao', 1)">&#10095;</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="no-image">Nenhuma imagem disponível</div>
        <?php endif; ?>

        <?php if (!empty($resposta['data_postagem'])): ?>
            <div class="post-date">
                Resolvido em: <?= date('d/m/Y H:i:s', strtotime($resposta['data_postagem'])) ?>
            </div>
        <?php endif; ?>
        
    </div>
<?php endif; ?>
        <?php endif; ?>
        <div>
            <a href="#" onclick="history.back(); return false;" class="btn btn-cancelar voltar">Voltar</a>
        </div>

    </div>
</div>



<script src="/view/static/js/galeria.js"></script>
</body>
</html>
<?php
} catch (Exception $e) {
    $_SESSION['erro'] = "Erro: " . $e->getMessage();
    error_log("Erro ao exibir post: " . $e->getMessage());
    header("Location: /minha-conta");
    exit;
}
?>
