<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php'); // importa o arquivo de conexão com o banco de dados
require_once('/xampp/htdocs/Helpdesk/Controller/Database/validacoes.php'); // importa o arquivo de validações 
session_start();

// verifica se foi setado algum valor para a session
$sessaoServidor = isset($_SESSION['idServidor']) ? true : false;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="/Helpdesk/View/style-geral.css">
    <!-- ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/Helpdesk/script.js"></script>

</head>

<body>
    <?php if (!verificaSessaoServidor($sessaoServidor)) {
        $_SESSION["acessoNegado"] = true;
        header("location: /Helpdesk/View/Servidor/tela-login-servidor.php");
    } else {

    ?>
        <!-- -->
        <div class="container" id="container">
            <!-- Menu lateral -->
            <div class="menu-lateral" id="menu-lateral">
                <div class="logo-sistema">
                    <img src="/Helpdesk/Image/icone-logo.png" alt="Ícone sistema">
                </div>

                <div class="opcoes-menu">
                    <ul>
                        <li><a title="Página inicial" href="/Helpdesk/View/Servidor/homepage-servidor.php"><i class="fa fa-home" style="padding: 10px;"></i></a></li>
                        <li><a title="Minha conta" href="#"><i class='fa fa-user-circle-o' style='padding: 10px'></i></a></li>
                        <li><a onclick="descricaoChamados()"><i class="fa fa-question-circle" style="padding: 10px;"></i></a></li>
                        <li><a href="#"><i class="fa fa-cog" style="padding: 10px;"></i></a></li>
                    </ul>
                </div>

                <div class="item-logout">
                    <a href="/Helpdesk/Controller/Database/logout.php"><i class="fa fa-sign-out" style="padding: 10px;"></i></a>
                </div>
            </div>

            <!-- Mensagem de boas vindas e previsão do tempo -->
            <div class="div-conteudo-principal" id="div-conteudo-principal">

                <div class="div-cabecalho">

                    <div class="div-boas-vindas">

                        <div class="div-mensagem">
                            <div class="div-imagem-suporte">
                                <img src="/Helpdesk/Image/icone-usuarioM.png" alt="Foto de perfil">
                            </div>
                            <div class="texto">
                                <h2>Olá, <?php echo $_SESSION["nome"] . " " . $_SESSION["sobrenome"] ?>! Como posso te ajudar hoje?</h2>
                            </div>
                        </div>

                        <div class="div-previsao-tempo">

                            <div class="div-icone-tempo">
                                <img src="/Helpdesk/Image/icone-sol.png" alt="Ícone sol">
                            </div>

                            <div class="div-temperatura">
                                <span>
                                    <?php
                                    $api_key = 'd396e08f6d51c7f382dd3b93359cd9d4'; // chave do OpenWeatherMap
                                    $latitude = -20.6597;
                                    $longitude = -43.7855;

                                    // url para acessar a API de clima
                                    $url = "http://api.openweathermap.org/data/2.5/weather?lat={$latitude}&lon={$longitude}&appid={$api_key}&units=metric";
                                    //http://api.openweathermap.org/data/2.5/weather?lat=-20.6597&lon=-43.7855&appid=d396e08f6d51c7f382dd3b93359cd9d4&units=metric
                                    // solicitação para a API
                                    $response = file_get_contents($url);

                                    // verifica se a solicitação foi feita 
                                    if ($response !== false) {
                                        // converte a resposta para JSON
                                        $json = json_decode($response);

                                        // verifica se a temperatura está presente nos dados
                                        if (isset($json->main->temp)) {
                                            $temperature = $json->main->temp;
                                            echo number_format($temperature, 0) . "°C";
                                        } else {
                                            echo "Não foi possível obter a temperatura atual.";
                                        }
                                    } else {
                                        echo "Erro na requisição!";
                                    }
                                    ?>
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Opções de chamados para abrir -->

                <div class="div-opcoes-chamados">
                    <!---->

                    <!-- Cartão chamado computador -->
                    <a class="cartao-chamado" href="/Helpdesk/View/Servidor/Chamados/chamados-computador.php">
                        <div class="icone-chamado">
                            <img src="/Helpdesk/Image/icone-computador.png" alt="Ícone computador">
                        </div>
                        <div class="categoria-chamado">
                            <span>COMPUTADOR</span>
                        </div>
                    </a>

                    <!-- Cartão chamado impressora -->
                    <a class="cartao-chamado" href="/Helpdesk/View/Servidor/Chamados/chamados-impressora.php">
                        <div class="icone-chamado">
                            <img src="/Helpdesk/Image/icone-impressora.png" alt="Ícone impressora">
                        </div>
                        <div class="categoria-chamado">
                            <span>IMPRESSORA</span>
                        </div>
                    </a>

                    <!-- Cartão chamado internet e redes -->
                    <a class="cartao-chamado" href="/Helpdesk/View/Servidor/Chamados/chamados-internet.php">
                        <div class="icone-chamado">
                            <img src="/Helpdesk/Image/icone-internet.png" alt="Ícone internet">
                        </div>
                        <div class="categoria-chamado">
                            <span>INTERNET</span>
                        </div>
                    </a>

                    <!-- Cartão chamado ponto eletronico (velti) -->
                    <a class="cartao-chamado" href="">
                        <div class="icone-chamado">
                            <img src="/Helpdesk/Image/icone-ponto-velti.png" alt="Ícone ponto">
                        </div>
                        <div class="categoria-chamado">
                            <span>PONTO</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- Descrição de cada chamado-->
        <!-- Vai aparecer quando o usuário clicar no Ícone de ajuda -->
        <div class="div-descricao-chamados" id="div-descricao-chamados" style="display: none;">
            <div class="campo-descricao-chamado">
                <div class="texto-descricao">
                    <p>Este tipo de chamado envolve problemas relacionados a computadores e notebooks, como reparos em hardware ou software. Pode incluir consertos de componentes defeituosos, formatação e troca de peças danificadas, como discos rígidos, memória RAM ou placas-mãe.</p>
                </div>
                <div class="titulo-descricao">
                    <h2>COMPUTADOR</h2>
                </div>
            </div>

            <div class="campo-descricao-chamado">
                <div class="texto-descricao">
                    <p>Esse tipo de chamado está relacionado a problemas com impressoras. Pode envolver a instalação de drivers de impressora, configuração de dispositivos de impressão em rede, substituição de cartuchos de toner ou resolução de problemas de impressão.</p>
                </div>
                <div class="titulo-descricao">
                    <h2>IMPRESSORA</h2>
                </div>
            </div>

            <div class="campo-descricao-chamado">
                <div class="texto-descricao">
                    <p>Esse tipo de chamado refere-se a sistemas de ponto eletrônico usados para controle de presença e horários de funcionários. Os chamados podem envolver a relocação de equipamentos ou a resolução de problemas relacionados a dispositivos com defeitos.</p>
                </div>
                <div class="titulo-descricao">
                    <h2>PONTO ELETRÔNICO</h2>
                </div>
            </div>

            <div class="campo-descricao-chamado">
                <div class="texto-descricao">
                    <p>Chamados relacionados a Internet e redes envolvem problemas de conectividade. Os usuários podem relatar a falta de sinal de Internet, problemas de velocidade, dificuldade de acesso a sites ou redes Wi-Fi e questões relacionadas à configuração de roteadores.</p>
                </div>
                <div class="titulo-descricao">
                    <h2>INTERNET E REDES</h2>
                </div>
            </div>
        </div>

        <!-- Icone para abrir campo de ajuda  -->
        <div class="div-suporte" id="div-suporte" style="display: none;">
            <div class="div-opcoes-suporte">
                <div class="mensagem-opcao">
                    <span>Escolha uma opção:</span>
                </div>
                <div class="opcao">
                    <a href="#">
                        <div class="icone-opcao">
                            <img src="/Helpdesk/Image/icone-aplicativos.png" alt="Ícone utilização">
                        </div>
                        <div class="nome-opcao">
                            <span>Utilização</span>
                        </div>
                    </a>
                </div>
                <div class="opcao">
                    <a href="#">
                        <div class="icone-opcao">
                            <img src="/Helpdesk/Image/icone-suporteF.png" alt="Ícone suporte">
                        </div>
                        <div class="nome-opcao">
                            <span>Suporte</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="botao-suporte">
            <button onclick="abrirSuporte()">
                <div class="icone-button">
                    <img src="/Helpdesk/Image/icone-suporteM.png" alt="Ícone suporte">
                </div>
            </button>
        </div>
    <?php } ?>
</body>

</html>