use dados;
CREATE TABLE resposta (
    id INT PRIMARY KEY,
    resolucao TEXT NOT NULL,
    imagens JSON DEFAULT NULL,
    data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)