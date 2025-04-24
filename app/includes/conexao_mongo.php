<?php
require_once 'env.php';
require 'vendor/autoload.php';

loadEnv(__DIR__ . '/../.env');

use MongoDB\Client;

function getPostsCollection() {
    $client = new Client($_ENV['MONGO_URI']);
    
    // Selecionar o banco de dados
    $db = $client->selectDatabase($_ENV['MONGO_DB']);
    // Retornar a coleção 'posts'
    return $db->selectCollection('reports');
}

function getUsuariosCollection() {
    $client = new Client($_ENV['MONGO_URI']);
    
    // Selecionar o banco de dados
    $db = $client->selectDatabase($_ENV['MONGO_DB']);
    
    // Retornar a coleção 'usuarios'
    return $db->selectCollection('users');
}
