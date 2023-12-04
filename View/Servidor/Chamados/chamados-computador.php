<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php'); // importa o arquivo de conexão com o banco de dados
require_once('/xampp/htdocs/Helpdesk/Controller/Database/validacoes.php'); // importa o arquivo de validações 
session_start();

// verifica se foi setado algum valor para a session
$sessaoServidor = isset($_SESSION['idServidor']) ? true : false;


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus chamados - Computador</title>
</head>

<body>
    <?php if (!verificaSessaoServidor($sessaoServidor)) {
        $_SESSION["acessoNegado"] = true;
        header("location: /Helpdesk/View/Servidor/tela-login-servidor.php");
    } else {
    ?>
        <div class="container">
            
        </div>
    <?php
    }

    ?>
</body>

</html>