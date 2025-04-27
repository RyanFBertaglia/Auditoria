<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
       // require_once '../app/includes/env.php';
        require_once '../app/includes/conexao_mongo.php';
        $teste = getMongoClient();
        echo $teste;

    ?>
</body>
</html>