<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php');
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS do formulário -->
    <link rel="stylesheet" href="/Helpdesk/View/style_formularios.css">

</head>

<body>
    <div class="container">

        <!-- div do formulario -->
        <div class="div-formulario-login" id="div-formulario-login">



            <!-- FORMULÁRIO DE LOGIN DO USUÁRIO -->
            <form action="/Helpdesk/Controller/Database/login-servidor.php" class="formulario-login" method="POST" onsubmit="carregar()">

                <!-- Imagem cabeçalho formulário de login -->
                <div class="image-form-login">
                    <img src="/Helpdesk/Image/logo-prefeitura.png" alt="Ícone sistema">
                </div>

                <!--Campo de texto para o CPF -->
                <div class="input-usuario">

                    <input type="text" id="cpf" name="cpf-login" placeholder="CPF" oninput="maskCPF(this)" maxlength="14" required>
                </div>

                <!-- Campo de texto para a senha -->
                <div class="input-senha">


                    <input type="password" id="senha-login" name="senha-login" autocomplete="off" placeholder="Senha" maxlength="15" required>

                </div>


                <!-- Mostrar a senha -->
                <div class="checkbox-mostrar-senha">
                    <input type="checkbox" id="show-password" onclick="showPassword()">
                    <label for="mostrarSenha">Mostrar Senha</label>
                </div>

                <!-- Opções de recuperar a senha e criar conta -->
                <div class="opcoes-adicionais">
                    <div class="recuperar-senha">
                        <a href="#">Esqueceu a senha?</a>
                    </div>

                    <div class="criar-conta">
                        <a href="/Helpdesk/View/Servidor/Formularios/form-cadastro-servidor.php">Criar conta!</a>
                    </div>
                </div>

                <!-- Botão de entrar -->
                <div class="btn-entrar">
                    <button type="submit" id="entrar">ENTRAR</button>
                </div>

            </form>
        </div>

        <!-- ícone de carregar -->
        <div class="carregar-login" id="carregar-login" style="display: none;">

        </div>

        <!-- Modal de erros -->
        <div class="div-modal-alerta" id="modal">
            <?php
            // caso aconteça erro no login, exibe o modal de erro
            if (isset($_SESSION["erro"])) {

            ?>
                <!-- Cartão do modal -->
                <div class="card-modal-erro">
                    <div class="icone-modal">
                        <img src="/Helpdesk/Image/icon-erro.png" alt="Ícone chamado aberto">
                    </div>
                    <div class="mensagem-modal">
                        <span>Usuário ou senha inválidos!</span>
                    </div>
                </div>
            <?php
            }

            // limpa a SESSION
            unset($_SESSION["erro"]);



            // caso o usuário tente acessar alguma página sem realizar login, exibe o modal de pendencia
            if (isset($_SESSION["acessoNegado"])) {
            ?>
                <div class="card-modal-pendencia">
                    <div class="icone-modal">
                        <img src="/Helpdesk/Image/icon-pendencia.png" alt="Ícone chamado aberto">
                    </div>
                    <div class="mensagem-modal">
                        <span>Para utilizar o sistema, faça login primeiro !</span>
                    </div>
                </div>
            <?php
            }

            unset($_SESSION["acessoNegado"]);
            ?>
        </div>



    </div>
</body>
<script>
    // circulo para carregar página
    function carregar() {
        const formulario_login = document.getElementById('div-formulario-login');
        const loading = document.getElementById('carregar-login');

        // oculta o formulário
        formulario_login.style.display = 'none';

        // coloca o icone de carregar
        loading.style.display = 'block';

    }


    // função para mostrar a senha
    function showPassword() {
        var checkboxSenha = document.getElementById('senha-login');


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

    // define um tempo para o modal ficar exibido na tela
    setTimeout(() => {
        var modalErro = document.getElementById('modal');

        if (modalErro) {
            modalErro.style.display = 'none';
        }
    }, 5000);
    

</script>

</html>