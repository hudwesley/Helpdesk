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

