<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php');


// função para verificar se o servidor fez login -> retorna um boolean 
function verificaSessaoServidor($sessionUsuario)
{
    return $sessionUsuario ? true : false;
}

// função para verificar se o administrador fez login -> retorna um boolean 
function verificaSessaoAdministrador($sessionAdmin)
{
    return $sessionAdmin ? true : false;
}

// verificar se um e-mail já está cadastrado no sistema 
// verificar se um e-mail já está cadastrado no sistema 
function verificaEmail($email, $conn)
{
    $sql = "SELECT Email FROM Servidor WHERE Email = '$email'";
    try {
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    } catch (Exception $ex) {
        return false; // Retorna false em caso de erro
    }
}

// verificar se um CPF já está cadastrado no sistema 
function verificaCPF($cpf, $conn)
{
    $sql = "SELECT Cpf FROM Servidor WHERE Cpf = '$cpf'";
    try {
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    } catch (Exception $ex) {
        return false; // Retorna false em caso de erro
    }
}


// gerar o numero da OS
function gerarNumeroOS($conn, $categoriaChamado)
{
    $id = "id" . $categoriaChamado;
    $query = "SELECT MAX('$id') AS maxId FROM $categoriaChamado";
    $consulta = $conn->query($query);
    $dados = $consulta->fetch_assoc();

    $maxId = $dados["maxId"] + 1;

    $prefixo = "";

    switch ($categoriaChamado) {
        case "Computador":
            $prefixo = "PMCL - CN";
            break;
        case "Internet":
            $prefixo = "PMCL - IR";
            break;
        case "Impressora":
            $prefixo = "PMCL - IMP";
            break;
        case "Ponto":
            $prefixo = "PMCL - PE";
            break;
        default:
            $_SESSION['erro'] = "true";
            return;
    }

    return $prefixo . " - " . str_pad($maxId, 4, '0', STR_PAD_LEFT);
}

