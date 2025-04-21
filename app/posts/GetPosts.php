<?php
require_once 'includes/env.php';
loadEnv(__DIR__ . '/.env');

require 'vendor/autoload.php'; // Garante que o MongoDB\Client esteja disponível

$apiKey = $_ENV['MONGO_API_KEY'];
$uri = $apiKey; // O URI de conexão completo do MongoDB Atlas

try {
    $client = new MongoDB\Client($uri);
    $mongoDB = $client->selectDatabase($_ENV['MONGO_DB']);
    $colecaoPosts = $mongoDB->selectCollection($_ENV['MONGO_COLLECTION']);

    $posts = $colecaoPosts->find();

    foreach ($posts as $post) {
        echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px'>";
        echo "<strong>Email:</strong> " . htmlspecialchars($post['email']) . "<br>";
        echo "<strong>Descrição:</strong> " . nl2br(htmlspecialchars($post['descricao'])) . "<br>";

        if (!empty($post['imagem'])) {
            echo "<strong>Imagem:</strong><br>";
            echo "<img src='data:image/jpeg;base64," . $post['imagem'] . "' style='max-width:300px'><br>";
        }

        echo "<strong>Data:</strong> " . htmlspecialchars($post['data']) . "<br>";
        echo "</div>";
    }

} catch (Exception $e) {
    die("Erro na conexão ou consulta ao MongoDB: " . $e->getMessage());
}
?>
