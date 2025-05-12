<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    /**
     * Registra uma rota.
     *
     * @param string   $method HTTP method: 'GET', 'POST', etc.
     * @param string   $uri    Caminho da URL (por exemplo, '/login')
     * @param callable $action Função ou método que será chamado
     */
    public function add(string $method, string $uri, callable $action): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'uri'    => $uri,
            'action' => $action
        ];
    }

    /**
     * Dispara o roteador, comparando a URL e método atuais com as rotas registradas.
     */
    public function dispatch(): void
    {
    // Caminho base do projeto (ex: '/Auditoria')
    $basePath = '/Auditoria';

    // Obtem a URI atual sem query strings
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Remove o prefixo '/Auditoria' da URI para comparação
    if (strpos($requestUri, $basePath) === 0) {
        $requestUri = substr($requestUri, strlen($basePath));
    }

    // Padrão: URI vazia vira '/'
    if ($requestUri === '') {
        $requestUri = '/';
    }

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    foreach ($this->routes as $route) {
        if ($route['uri'] === $requestUri && $route['method'] === $requestMethod) {
            call_user_func($route['action']);
            return; // <- Importante: para evitar que o código continue até o 404
        }
    }

    // Evita erro caso headers já tenham sido enviados
    if (!headers_sent()) {
        header("HTTP/1.0 404 Not Found");
    }
    echo "404 - Página não encontrada";
    }

}
