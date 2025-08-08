<?php
use backend\Models\Admin;
use backend\Controller\AdminController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idPost = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = require __DIR__ . '/../../includes/db.php';
    require_once __DIR__ . '/../../model/Admin.php';
    require_once __DIR__ . '/../../controller/AdminController.php';

    try {

        $titulo = $_POST['titulo'] ?? '';
        $resolucao = $_POST['resolucao'] ?? '';

        if (empty($resolucao)) {
            throw new Exception("A resolução é obrigatória.");
        }

        $resolucao = htmlspecialchars($resolucao, ENT_QUOTES, 'UTF-8');

        $adminModel = new Admin($pdo);
        $adminController = new AdminController($adminModel);

        echo $_POST;

        $adminController->responder([
            'id' => $idPost,
            'resolucao' => $resolucao
        ], $_FILES);

    } catch (Exception $e) {
        $_SESSION['erro'] = $e->getMessage();
        header("Location: /erro");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Definir Resolucão</title>
  <link rel="stylesheet" href="/view/static/style/reclama.css">
</head>
<body>
<?php include './view/static/elements/nav.php'; ?>
    <br><br>

  <div class="container">
    <h1>Definir Resolucão</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="message error">
            <strong>Erros encontrados:</strong>
            <ul class="error-list">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif (isset($success) && $success): ?>
        <div class="message success">
            Reclamação comentada com sucesso!
        </div>
    <?php endif; ?>
    
    <form method="POST" action="/admin/responder" enctype="multipart/form-data" id="mainForm">

        <label for="id" name="id">
            <h4>Post de número: <?php echo htmlspecialchars($idPost)?></h4>
            
        </label>
        <div class="form-group">
            <label for="resolucao">Resolução:</label>
            <textarea id="resolucao" name="resolucao" rows="5" required maxlength="1000" placeholder="Descreva a solução para o problema"><?php 
                echo isset($resolucao) ? htmlspecialchars($resolucao) : ''; 
            ?></textarea>
            <div class="limit-info">
                <small>Limite: 1000 caracteres</small>
                <small id="char-counter">0/1000</small>
            </div>
        </div>
        
        <div class="form-group upload-group">
            <label>Anexar Imagens (opcional, máximo 4):</label>
            
            <div class="upload-area" id="uploadArea">
                <div class="upload-icon">📁</div>
                <p class="upload-text">Arraste e solte suas imagens aqui ou clique para selecionar</p>
                <button type="button" class="btn" id="selectFilesBtn">Selecionar Imagens</button>
                <input type="file" id="imagens" name="imagens[]" accept="image/png,image/jpeg,image/jpg,image/gif,image/webp" multiple class="file-input">
            </div>
            
            <div class="counter">
                <span id="selectedCount">0</span> de 4 imagens selecionadas
            </div>
            
            <div class="preview-container" id="previewContainer"></div>
        </div>
        
        <button type="submit" class="submit-button" id="submitBtn">Enviar Post</button>
        <button class="submit-button" style="background-color:#e62e2e;" onclick="history.back()">Voltar</button>
    </form>
  </div>
  
  <script src="/view/static/js/verificaReclamacao.js"></script>
</body>
</html>