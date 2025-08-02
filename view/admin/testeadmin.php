<?php
$pdo = require __DIR__ . '/../../includes/db.php';

$nome = "Administração";
$email = "prefeitura@gmail.com";
$senhaHash = password_hash("admin", PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->execute([$nome, $email, $senhaHash]);

echo "Admin criado com sucesso!";
