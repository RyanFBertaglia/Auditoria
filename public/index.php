<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/PostController.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Post.php';
require_once __DIR__ . '/../includes/conexao_mongo.php';
require_once __DIR__ . '/../app/middlewares/AuthMiddleware.php';

// carrega e dispatch das rotas
require __DIR__ . '/../app/routes.php';
?>