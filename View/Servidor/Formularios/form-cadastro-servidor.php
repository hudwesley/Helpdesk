<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php');
require_once('/xampp/htdocs/Helpdesk/Controller/Database/validacoes.php');

session_start();


if (isset($_GET["idSecretaria"])) {
    $idSecretaria = $_GET["idSecretaria"];
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <!-- CSS do formulário -->
    <link rel="stylesheet" href="/Helpdesk/View/style_formularios.css">
</head>

<body>
    <div class="container">

        <!-- div do formulário -->
        <div class="div-formulario-cadastro">

            <!--FORMULÁRIO DE CADASTRO DE SERVIDOR -->
            <form action="/Helpdesk/Controller/Database/create-servidor.php" class="formulario-cadastro" method="POST">

                <!-- Imagem cabeçalho formulário de cadastro -->
                <div class="image-form-cadastro">
                    <img src="/Helpdesk/Image/icone-logo.png" alt="Ícone sistema">
                </div>

                <!-- div do nome do usuário -->
                <div class="input-nome-servidor">
                    <input type="text" name="nome-servidor" placeholder="Nome" required>
                </div>

                <!-- div do sobrenome do usuário -->
                <div class="input-sobrenome-servidor">
                    <input type="text" name="sobrenome-servidor" placeholder="Sobrenome" required>
                </div>

                <!-- div do e-mail do usuário -->
                <div class="input-email-servidor">
                    <input type="email" name="email-servidor" placeholder="E-mail" required>
                </div>

                <!-- div do cpf do usuário -->
                <div class="input-cpf-servidor">
                    <input type="text" name="cpf-servidor" placeholder="000.000.000-00" oninput="maskCPF(this)" maxlength="14" required>
                </div>

                <div class="select-sexo-servidor">
                    <select name="sexo-servidor" id="sexo-servidor">
                        <option value="Feminino">Feminino</option>
                        <option value="Masculino">Masculino</option>
                    </select>
                </div>

                <!-- div do secretaria do usuário -->
                <div class="select-secretaria-servidor">
                    <select name="secretaria-servidor" id="secretaria-servidor" required>
                        <option value="0" selected disabled>Selecione uma secretaria</option>

                        <!-- SQL para buscar e retornar todas as secretarias -->
                        <?php
                        $sql = "SELECT idSecretaria, Nome FROM secretaria";

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option  value="' . $row["idSecretaria"] . '">' . $row["Nome"] . '</option>';
                            }
                        }

                        ?>
                    </select>
                </div>

                <!-- div do setor do usuário -->
                <div class="select-setor-servidor">
                    <select name="setor-servidor" id="setor-servidor" class="setor-servidor" required>
                        <option value="0" selected disabled>Selecione um setor</option>
                        <?php

                        // verifica se foi setado algum valor para a variavel $idSecretaria
                        if (isset($idSecretaria)) {

                            // SQL para buscar e retornar todos os setores de acordo com a secretaria selecionada
                            $sql = "SELECT idSetor, Nome FROM setor WHERE Secretaria_idSecretaria = $idSecretaria ORDER BY Nome asc";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["idSetor"] . '">' . $row["Nome"] . '</option>';
                                }
                            }
                        }

                        ?>
                    </select>
                </div>
                <!-- div do senha do usuário -->
                <div class="input-senha-servidor">
                    <input type="password" name="senha-servidor" placeholder="Senha" id="senha-servidor" required>
                </div>

                <!-- Mostrar a senha -->
                <div class="checkbox-mostrar-senha">
                    <input type="checkbox" id="show-password" onclick="showPassword()">
                    <label for="mostrarSenha">Mostrar Senha</label>
                </div>

                <!-- Botão de entrar -->
                <div class="btn-cadastrar">
                    <button type="submit" id="entrar">CRIAR</button>
                </div>
            </form>
            <div class="fazer-login">
                <span>Já possui uma conta? <a href="/Helpdesk/View/Servidor/tela-login-servidor.php">Faça login!</a></span>
            </div>
        </div>
    </div>


    <div class="div-modal-alerta" id="modal">

        <!-- Modal de e-mail já cadastrado -->

        <?php
        if (isset($_SESSION["email-cadastrado"])) {
        ?>
            <div class="card-modal-pendencia">
                <div class="icone-modal">
                    <img src="/Helpdesk/Image/icon-pendencia.png" alt="Ícone chamado aberto">
                </div>
                <div class="mensagem-modal">
                    <span>O e-mail digitado já está cadastrado!</span>
                </div>
            </div>
        <?php
        }

        unset($_SESSION["email-cadastrado"]);
        ?>

        <!-- Modal de CPF já cadastrado -->
        <?php
        if (isset($_SESSION["cpf-cadastrado"])) {
        ?>
            <div class="card-modal-pendencia">
                <div class="icone-modal">
                    <img src="/Helpdesk/Image/icon-pendencia.png" alt="Ícone chamado aberto">
                </div>
                <div class="mensagem-modal">
                    <span>O CPF digitado já está cadastrado!</span>
                </div>
            </div>
        <?php
        }
        unset($_SESSION["cpf-cadastrado"]);
        ?>

        <!-- Modal de erro generico -->
        <?php
        if (isset($_SESSION["erro-generico"])) {
        ?>
            <div class="card-modal-erro">
                <div class="icone-modal">
                    <img src="/Helpdesk/Image/icon-erro.png" alt="Ícone chamado aberto">
                </div>
                <div class="mensagem-modal">
                    <span>Erro ao realizar o cadastro!</span>
                </div>
            </div>
        <?php
        }
        unset($_SESSION["erro-generico"]);
        ?>

        <!-- Modal de sucesso na criação de conta -->

        <?php
        if (isset($_SESSION["sucesso-criacao-conta"])) {
        ?>
            <div class="card-modal-sucesso">
                <div class="icone-modal">
                    <img src="/Helpdesk/Image/icon-accept.png" alt="Ícone chamado aberto">
                </div>
                <div class="mensagem-modal">
                    <span>Conta criada com sucesso!</span>
                </div>
            </div>
        <?php
        }
        unset($_SESSION["sucesso-criacao-conta"]);
        ?>


    </div>

</body>
<script>
    // função para mostrar a senha
    function showPassword() {
        var checkboxSenha = document.getElementById('senha-servidor');

        if (checkboxSenha.type === 'password') {
            checkboxSenha.type = 'text';
        } else {
            checkboxSenha.type = 'password';
        }
    }

    // função para usar a mascara do CPF 000.000.000-00
    function maskCPF(valor) {

        var formatacao = valor.value;

        if (isNaN(formatacao[formatacao.length - 1])) { // impede entrar outro caractere que não seja número
            valor.value = formatacao.substring(0, formatacao.length - 1);
            return;
        }

        valor.setAttribute("maxlength", "14");
        if (formatacao.length == 3 || formatacao.length == 7) valor.value += ".";
        if (formatacao.length == 11) valor.value += "-";

    }

    // função para carregar os setores de acordo com a secretaria
    function carregaSetores() {
        var idSecretaria = document.getElementById("secretaria-servidor").value;
        var setorSelect = document.getElementById("setor-servidor");

        var xhr = new XMLHttpRequest();

        xhr.open("GET", "/Helpdesk/Controller/Database/carregar-setores.php?idSecretaria=" + idSecretaria, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                setorSelect.innerHTML = xhr.responseText;
            }
        };

        xhr.send();
    }

    // Adicione um ouvinte de evento para o select de Secretaria
    document.getElementById("secretaria-servidor").addEventListener("change", carregaSetores);

    // define um tempo para o modal ficar exibido na tela
    setTimeout(() => {
        var modalErro = document.getElementById('modal');

        if (modalErro) {
            modalErro.style.display = 'none';
        }
    }, 5000);
</script>

</html>