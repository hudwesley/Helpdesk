<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php'); // importa o arquivo de conexão com o banco de dados
require_once('/xampp/htdocs/Helpdesk/Controller/Database/validacoes.php'); // importa o arquivo de validações 
session_start(); // Inicia a sessão


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome-servidor'];
    $sobrenome = $_POST['sobrenome-servidor'];
    $email = $_POST['email-servidor'];
    $cpf = $_POST['cpf-servidor'];
    $sexo = $_POST['sexo-servidor'];
    $secretaria = $_POST['secretaria-servidor'];
    $setor = $_POST['setor-servidor'];
    $senha = base64_encode($_POST['senha-servidor']);

    if (verificaCPF($cpf, $conn)) {
        $_SESSION["cpf-cadastrado"] = true;
        header("location: /Helpdesk/View/Servidor/Formularios/form-cadastro-servidor.php");
        exit;
    }

    
    if (verificaEmail($email, $conn)) {
        $_SESSION["email-cadastrado"] = true;
        header("location: /Helpdesk/View/Servidor/Formularios/form-cadastro-servidor.php");
        exit;
    }

    $sql = "INSERT INTO Servidor (nome, sobrenome, sexo, cpf, email, senha, Secretaria_idSecretaria, Setor_idSetor)
        VALUES ('$nome','$sobrenome','$sexo','$cpf','$email','$senha', $secretaria , $setor )";

    try {
        $conn->query($sql);
        $_SESSION['sucesso-criacao-conta'] = true;
        header("location: /Helpdesk/View/Servidor/Formularios/form-cadastro-servidor.php");
    } catch (Exception $ex) {
        $_SESSION["erro-generico"] = true;
        header("location: /Helpdesk/View/Servidor/Formularios/form-cadastro-servidor.php");
    }
} else {
?>
    <script>
        alert("Erro no envio do formulário");
    </script>
<?php
}
?>