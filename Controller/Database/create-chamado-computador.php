<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php');
require_once('/xampp/htdocs/Helpdesk/Controller/Database/validacoes.php');
date_default_timezone_set('America/Sao_Paulo');
session_start();



// gerar o numero da ordem de serviço
$numOS = gerarNumeroOs($conn, 'Computador');

// comando SQL  
$stmt = $conn->prepare("INSERT INTO Computador (NumOS, Local, Setor, Descricao, Responsavel, SenhaUsuario, NumPatrimonio, Outros, Data, Prioridade, Admin_idAdmin, Servidor_idServidor) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

// receber o conteúdo das variáveis


// enviar os dados para o banco


?>