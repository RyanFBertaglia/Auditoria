<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./static/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="background">
        <form id="userForm" class="blurred-form">

            <h2>Login</h2>
            
            <?php if (isset($_GET['erro'])): ?>
                <div class="erro"><?= htmlspecialchars($_GET['erro']) ?></div>
            <?php endif; ?>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email">
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="senha">
            
            <button type="submit" class="buttonEsf">Login</button>
            <a href='./cadastro.php' class="buttonEsf" id="linkLogin">Não tem uma conta? Cadastre-se</a>

        </form>
    </div>    
</body>
</html>