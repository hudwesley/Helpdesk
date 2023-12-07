<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php'); // importa o arquivo de conexão com o banco de dados
require_once('/xampp/htdocs/Helpdesk/Controller/Database/validacoes.php'); // importa o arquivo de validações 
session_start(); // Inicia a sessão


// verifica se os dados estão vindo via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // atribui nas variaveis os valores dos inputs 
    $nome = $_POST['nome-servidor'];
    $sobrenome = $_POST['sobrenome-servidor'];
    $email = $_POST['email-servidor'];
    $cpf = $_POST['cpf-servidor'];
    $sexo = $_POST['sexo-servidor'];
    $secretaria = $_POST['secretaria-servidor'];
    $setor = $_POST['setor-servidor'];
    $senha = base64_encode($_POST['senha-servidor']);

    // verifica se o CPF já existe no sistema
    if (verificaCPF($cpf, $conn)) {
        $_SESSION["cpf-cadastrado"] = true;
        header("location: /Helpdesk/View/Servidor/Formularios/form-cadastro-servidor.php");
        exit;
    }

    // verifica se o e-mail já existe no sistema
    if (verificaEmail($email, $conn)) {
        $_SESSION["email-cadastrado"] = true;
        header("location: /Helpdesk/View/Servidor/Formularios/form-cadastro-servidor.php");
        exit;
    }

    try {
        // prepara o comando SQL
        $stmt = $conn->prepare("INSERT INTO Servidor (nome, sobrenome, sexo, cpf, email, senha, Secretaria_idSecretaria, Setor_idSetor) VALUES (?,?,?,?,?,?,?,?)");

        // procura os valores
        $stmt->bind_param("ssssssii", $nome, $sobrenome, $sexo, $cpf, $email, $senha, $secretaria, $setor);

        // executa o comando
        $stmt->execute();
        
        // inicia a SESSION para ativar o modal de sucesso
        $_SESSION['sucesso-criacao-conta'] = true;

        // redicreciona para a tela de cadastro do servidor
        header("location: /Helpdesk/View/Servidor/Formularios/form-cadastro-servidor.php");

    } catch (Exception $ex) {

        // inicia a SESSION para ativar o modal de erro
        $_SESSION["erro-generico"] = true;

        // redicreciona para a tela de cadastro do servidor
        header("location: /Helpdesk/View/Servidor/Formularios/form-cadastro-servidor.php");
    }

    // caso não seja via POST, vai ter erro na criação de conta
} else {
?>
    <script>
        alert("Erro no envio do formulário");
    </script>
<?php
}
?>