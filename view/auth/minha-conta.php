<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = require __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../model/Users.php';
require_once __DIR__ . '/../../controller/UserController.php';
require_once __DIR__ . '/../../model/Posts.php';
require_once __DIR__ . '/../../controller/PostController.php';

use backend\Models\Posts;
use backend\Controller\PostController;
use backend\Models\Users;
use backend\Controller\UserController;

$userModel = new Users($pdo);
$postModel = new Posts($pdo);
$users = new UserController($userModel);
$posts = new PostController($postModel);

$email = $_SESSION['email'];
$user = $users->getUser($email);

if (!$user) {
    echo "Usuário não encontrado.";
    exit;
}

$userPosts = $posts->getUserPosts($email);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Minha Conta</title>
    <link rel="stylesheet" href="./view/static/style/minha-conta.css">
</head>
<body>
<?php include './view/static/elements/nav.php'; ?>

<div class="hero">
    <h1>Olá, <?= htmlspecialchars(explode(" ", $user['nome'])[0]) ?>!</h1>
    <p>Aqui você pode gerenciar sua conta e visualizar seus posts.</p>
</div>

<div class="container">
    <div class="user-info card">
        <h2>Informações do Usuário</h2>
        <div class="info-item">
            <span class="label">Nome:</span>
            <span class="value"><?= htmlspecialchars($user['nome']) ?></span>
        </div>
        <div class="info-item">
            <span class="label">Email:</span>
            <span class="value"><?= htmlspecialchars($user['email']) ?></span>
        </div>
        <div class="info-item">
            <span class="label">Cadastrado em:</span>
            <span class="value"><?= date('d/m/Y H:i', strtotime($user['criado_em'])) ?></span>
        </div>
    </div>

    <?php if (!isset($_SESSION['admin'])): ?>

    <div class="posts card">
        <h2>Meus Posts</h2>

        <?php if (count($userPosts) === 0): ?>
            <p>Você ainda não fez nenhum post.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userPosts as $post): ?>
                        <tr>
                            <td><?= htmlspecialchars($post['titulo']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($post['data_postagem'])) ?></td>
                            <td>
                                <span class="status <?php echo $post['resolvido'] == 1 ? 'resolved' : 'pending'; ?>">
                                    <?php echo $post['resolvido'] == 1 ? '✅ Resolvido' : '⏳ Pendente'; ?>
                                </span>
                            </td>
                            <td>
                                <a href="/post?id=<?= $post['idPost'] ?>">Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
</body>
</html>