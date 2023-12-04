<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php');
session_start(); // Inicia a sessão



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $cpf = $conn->real_escape_string($_POST["cpf-login"]);
    $password = base64_encode($_POST["senha-login"]);

    $sql = "SELECT * FROM Servidor WHERE Cpf = '$cpf' AND Senha = '$password'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $dados = $resultado->fetch_assoc();
        $_SESSION["idServidor"] = $dados["idServidor"];
        $_SESSION["secretaria"] = $dados["Secretaria_idSecretaria"];
        $_SESSION["setor"] = $dados["Setor_idSetor"];
        $_SESSION["nome"] = $dados["Nome"];
        $_SESSION["sobrenome"] = $dados["Sobrenome"];
        $_SESSION["sexo"] = $dados["Sexo"];
        $_SESSION["cpf"] = $dados["Cpf"];
        $_SESSION["email"] = $dados["Email"];

        sleep(1);
        header("location: /Helpdesk/View/Servidor/homepage-servidor.php");
    } else {
        sleep(1);
        $_SESSION["erro"] = 1;
        header("location: /Helpdesk/View/Servidor/tela-login-servidor.php");
    }
}else{
    ?>
    <script>
        alert("Erro no envio do formulário");
        
    </script>
    <?php
}
