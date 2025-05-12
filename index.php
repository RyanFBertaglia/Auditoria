<?php
ob_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/core/Router.php';

// Inclua o session.php aqui
require_once __DIR__ . '/includes/session.php'; // ajuste esse caminho se necessário

use App\Core\Router;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$router = new Router();
require_once __DIR__ . '/app/routes.php';

$router->dispatch();

ob_end_flush();
