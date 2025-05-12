<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('SESSION_TIMEOUT', 1800);

/**
 * Confere se o usuário está logado e se a sessão não expirou.
 * Caso não esteja logado ou a sessão tenha expirado, redireciona para o login.
 */
function confere_timeout()
{
    if (empty($_SESSION['logado'])) {
        header("Location: ./login.php");
        exit;
    }

    if (
        isset($_SESSION['session_start_time']) &&
        (time() - $_SESSION['session_start_time'] > SESSION_TIMEOUT)
    ) {
        session_unset();
        session_destroy();
        header("Location: ./login.php");
        exit;
    }

    // Renova timestamp da sessão
    $_SESSION['session_start_time'] = time();
}
