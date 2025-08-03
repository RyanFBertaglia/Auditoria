<?php
namespace backend\Models;

use \PDO;

class Resposta {

    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findById($idPost) {
        $stmt = $this->pdo->prepare("SELECT * FROM resposta WHERE id = :idPost LIMIT 1");
        $stmt->bindParam(':idPost', $idPost);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create(array $data) {
        $stmt = $this->pdo->prepare("INSERT INTO resposta (id, resolucao, imagens) 
                                     VALUES (id:, :resolucao, :imagens)");
    
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':resolucao', $data['resolucao']);
        
        $imagensJson = json_encode($data['imagens'] ?? []);
        $stmt->bindParam(':imagens', $imagensJson);
    
        return $stmt->execute();
    }

}