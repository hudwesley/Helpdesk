<?php
    define("DB_SERVER", "127.0.0.1");  
    define("DB_USERNAME", "root"); // 
    define("DB_PASSWORD", "");  // 
    define("DB_NAME", "helpdesk");  

    // Criar um objeto de conexão usando constantes
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Verificar a conexão
    if($conn->connect_error){
        die("Falha na conexão: " . $conn->connect_error);
    }
?>
