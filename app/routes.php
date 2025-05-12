<?php
use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\PostController;
use App\Models\User;
use App\Models\Post;
use App\Middlewares\AuthMiddleware;

require_once __DIR__ . '../../includes/conexao_mongo.php';

// Instancia o roteador
$router = new Router();


// Instancia models e controllers
$usuariosCol = getUsuariosCollection();
$userModel   = new User($usuariosCol);
$auth        = new AuthController($userModel);

$postsCol = getPostsCollection();
$postModel = new Post($postsCol);
$postCtrl  = new PostController($postModel);

// Rotas de autenticação
$router->add('GET',  '/login',    [ $auth, 'showLogin' ]);
$router->add('POST', '/login',    [ $auth, 'login'     ]);
$router->add('GET',  '/register', [ $auth, 'showRegister' ]);
$router->add('POST', '/register', [ $auth, 'register'  ]);

// Rotas protegidas por sessão (middleware)
$router->add('GET',  '/posts/create', function() use ($postCtrl) {
    AuthMiddleware::handle();
    $postCtrl->create();
});

$router->add('POST', '/posts', function() use ($postCtrl) {
    AuthMiddleware::handle();
    $postCtrl->store();
});

$router->add('GET',  '/', function() use ($postCtrl) {
    AuthMiddleware::handle();
    $postCtrl->index();
});

// Dispara o roteador
$router->dispatch();
