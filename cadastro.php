<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./static/css/cadastro.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Poppins&family=Quicksand&display=swap" rel="stylesheet">

    <title>Cadastro</title>
</head>
<body>
    <div class="background">
        <form id="userForm" class="blurred-form" action="app/auth/Cadastro.php" method="POST">
            <h2>Cadastro</h2>
            <label for="name">Username:</label>
            <input type="text" id="name" name="name">
        
            <label for="email">Email:</label>
            <input type="text" id="email" name="email">
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="senha">
            
            <button type="submit" class="buttonEsf">Cadastrar</button>
            <a href='./login.php' class="buttonEsf" id="linkLogin">Já tem uma conta? Login</a>

        </form>
    </div>    
</body>
</html>