<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Post</title>
  <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
  <?php if (isset($_GET['erro'])): ?>
    <div class="erro"><?= htmlspecialchars($_GET['erro']) ?></div>
  <?php endif; ?>

  <form action="/posts" method="POST" enctype="multipart/form-data" id="mainForm">
    <h1>Novo Post</h1>

    <div class="form-group">
      <label for="name">Título (opcional):</label>
      <textarea id="name" name="name" rows="1" placeholder="Título do post"></textarea>
    </div>

    <div class="form-group">
      <label for="descricao">Descrição:</label>
      <textarea id="descricao" name="descricao" rows="5" required placeholder="Descreva o local ou problema"></textarea>
      <div class="limit-info">
        <small>Limite: 1000 caracteres</small>
        <small id="char-counter">0/1000</small>
      </div>
    </div>

    <div class="form-group upload-group">
      <label>Anexar Imagens (opcional):</label>
      <input type="file" id="imagem" name="imagem[]" accept="image/png, image/jpeg, image/gif" multiple>
      <small>Máximo 4 imagens, até 5 MB cada</small>
      <div id="file-list" class="file-list"></div>
    </div>

    <button type="submit" class="submit-button" id="submitButton">Enviar</button>
  </form>

  <script src="/static/js/efeitoContador.js"></script>
  <script src="/static/js/fotos.js"></script>
</body>
</html>
