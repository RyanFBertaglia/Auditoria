<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/static/css/cadastro.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
    <title>Cadastro</title>
</head>
<body>
    <div class="background">
        <form id="userForm" class="blurred-form" action="/register" method="POST">
            <h2>Cadastro</h2>

            <?php if (isset($_GET['erro'])): ?>
                <div class="erro"><?= htmlspecialchars($_GET['erro']) ?></div>
            <?php endif; ?>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit" class="buttonEsf">Cadastrar</button>
            <a href="login" class="buttonEsf" id="linkLogin">Já tem uma conta? Login</a>
        </form>
    </div>    
</body>
</html>
