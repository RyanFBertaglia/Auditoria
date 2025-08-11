<?php
require_once 'config.php';
require_once 'includes/auth.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($requestUri, '/');
if ($uri === '') {
    $uri = '/';
}

if ($uri === '/') {
    $uri = '/';
}

switch ($uri) {
    case '/':
    case '/home':
        require './view/home.php';
        break;

    case '/login':
        require __DIR__ . '/view/auth/login.php';
        break;

    case '/login-admin':
        require __DIR__ . '/view/admin/login.php';
        break;

    case '/register':
        if (isLoggedIn()) {
            redirect('home');
        }
        require __DIR__ . '/view/auth/register.php';
        break; 

    case '/erro':
        require __DIR__ . '/view/static/elements/erro-cadastro.php';
        break;

    case '/reclamar':
        protectPage();
        require './view/posts/reclamar.php';
        break;

    case '/sucesso':
        require './view/static/elements/sucesso.php';
        break;

    case '/posts':
        require './view/posts/index.php';
        break;

    case '/admin/usuarios':
        protectPage();
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
        $_GET['page'] = $page;
        require './view/posts/index.php';
        break;
    

    case '/comentarios':
        protectPage();
        require './view/posts/comentarios.php';
        break;
    
    case '/comentar':
        protectPage();
        require './view/posts/comentar.php';
        break;

    case '/admin/posts':
        protectAdmin();
        require './view/admin/index.php';
        break;
    
    case '/admin/responder':
        protectAdmin();
        require './view/admin/resposta.php';
        break;
    
    case '/logout':
        logout();
        redirect('/home');
        break;

    case '/minha-conta':
        protectPage();
        require './view/auth/minha-conta.php';
        break;

    case '/post':
        protectPage();
        require './view/posts/post.php';
        break;        

        default:
        http_response_code(404);
        echo "<!DOCTYPE html>
        <html>
        <head><title>404 - Página não encontrada</title></head>
        <body>
            <h1>404 - Página não encontrada</h1>
            <p><a href='" . base_url() . "'>Voltar ao início</a></p>
        </body>
        </html>";
        break;
}
?>