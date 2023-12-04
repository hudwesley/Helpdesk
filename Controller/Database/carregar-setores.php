<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php');

if(isset($_GET["idSecretaria"])){
    $idSecretaria = $_GET["idSecretaria"];

    $sql = "SELECT idSetor, Nome FROM setor WHERE Secretaria_idSecretaria = $idSecretaria ORDER BY Nome ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["idSetor"] . '">' . $row["Nome"] . '</option>';
        }
    } else {
        echo '<option value="">Nenhum setor encontrado</option>';
    }
} else {
    echo '<option value="">Selecione uma Secretaria</option>';
}

?>