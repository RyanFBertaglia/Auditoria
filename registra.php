<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapeamento Colaborativo</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="static/css/loading.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mapeamento Colaborativo</h1>
        </div>

        <div class="welcome-message">
            <p>Ajude a construir um mundo mais acessível! Registre locais e avalie suas condições de acessibilidade. Sua contribuição ajuda pessoas com diferentes necessidades a navegar com mais segurança e autonomia. Compartilhe informações sobre rampas, banheiros adaptados, pisos táteis e outras características importantes.</p>
        </div>

        <form action="./app/posts/SavePost.php" method="POST" enctype="multipart/form-data" id="mainForm">
            <div class="form-group">
                <label for="name">Título:</label>
                <textarea id="name" name="name" rows="1" placeholder="Digite seu nome (opcional)"></textarea>
            </div>

            <div class="form-group">
                <label for="comment">Descreva o problema:</label>
                <textarea id="comment" name="comment" rows="5" required></textarea>
                <div class="limit-info">
                    <small>Limite: 1000 caracteres</small>
                    <small id="char-counter">0/1000</small>
                </div>
            </div>

            <div class="form-group upload-group">
                <label>Anexar Imagens (opcional):</label>
                <div class="button-container">
                    <div class="upload-button-wrapper">
                        <input type="file" id="file" name="file" accept="image/*" multiple style="display:none;">
                        <label for="file" class="file-upload-label">Adicionar Imagens</label>
                    </div>
                    <button type="submit" class="submit-button" id="submitButton">Enviar</button>
                </div>
                <small id="file-limit">Máximo 4 imagens, 5 MB cada (PNG, JPG, JPEG, GIF)</small>
                <div id="file-list" class="file-list"></div>
            </div>
        </form>

        <div id="loadingOverlay" class="loading-overlay">
            <div class="loading-spinner"></div>
        </div>

        <div id="successPopup" class="success-popup">
            <p>Mensagem enviada com sucesso!</p>
        </div>
    </div>

</body>
</html>