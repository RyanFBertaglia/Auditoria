<?php
require_once '../../../env.php';
require '../../vendor/autoload.php';

function getMongoClient() {
    static $client = null;
    
    if ($client === null) {
        $client = new MongoDB\Client(
            $_ENV['MONGO_URI'],
            [
                'retryWrites' => true,
                'w' => 'majority',
                'appName' => 'Auditoria'
            ]
        );
    }
    
    return $client;
}

function getUsuariosCollection() {
    return getMongoClient()->selectDatabase($_ENV['MONGO_DB'])->selectCollection('users');
}

function getPostsCollection() {
    return getMongoClient()->selectDatabase($_ENV['MONGO_DB'])->selectCollection('reports');
}