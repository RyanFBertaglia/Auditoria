<?php
namespace App\Middlewares;

class AuthMiddleware
{
    /**
     * Verifica se o usuário está logado e se a sessão está ativa.
     * Redireciona para o login em caso negativo.
     */
    public static function handle(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Não defina a constante aqui, ela já está definida em session.php

        if (empty($_SESSION['logado'])) {
            header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/Auditoria/login');
            exit;
        }

        if (isset($_SESSION['session_start_time']) &&
            (time() - $_SESSION['session_start_time'] > SESSION_TIMEOUT)) {
            session_unset();
            session_destroy();
            header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/Auditoria/login');
            exit;
        }

        $_SESSION['session_start_time'] = time(); // Renova sessão
    }
}
