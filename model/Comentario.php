<?php
namespace backend\Models;

class Comentario {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function buscarComentariosPorPost($idPost) {
        $query = "SELECT c.*, p.titulo AS titulo_post
                  FROM comentarios c
                  LEFT JOIN postagens p ON c.idPost = p.idPost
                  WHERE c.idPost = ?
                  ORDER BY c.data_comentario DESC";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idPost]);
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
    public function criarComentario($idPost, $email, $comentario) {
        $query = "INSERT INTO comentarios (idPost, email, comentario) VALUES (?, ?, ?)";
        
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$idPost, $email, $comentario]);
    }
    
    public function contarComentarios($idPost) {
        $query = "SELECT COUNT(*) as total FROM comentarios WHERE idPost = ?";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idPost]);
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function deletarComentario() {
        
    }
    
}