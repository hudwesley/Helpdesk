<?php
require_once('/xampp/htdocs/Helpdesk/Controller/Conexao/Conexao.php'); // importa o arquivo de conexão com o banco de dados
require_once('/xampp/htdocs/Helpdesk/Controller/Database/validacoes.php'); // importa o arquivo de validações 
session_start();

// verifica se foi setado algum valor para a session
$sessaoServidor = isset($_SESSION['idServidor']) ? true : false;

$idServidor = $_SESSION['idServidor'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus chamados - Computador</title>
    <link rel="stylesheet" href="/Helpdesk/View/style-geral.css">
    <!-- ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="/Helpdesk/script.js"></script>

</head>

<body id="body">
    <?php if (!verificaSessaoServidor($sessaoServidor)) {
        $_SESSION["acessoNegado"] = true;
        header("location: /Helpdesk/View/Servidor/tela-login-servidor.php");
    } else {
    ?>
        <!-- Div da página inteira -->
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
            <!-- Tela dos chamados -->
            <div class="div-tela-chamados" id="div-tela-chamados">
                <div class="legenda">
                    <div class="imagem-chamado">
                        <img src="/Helpdesk/Image/icone-computador.png" alt="">
                        <h2>Chamados - Computador e Notebook</h2>
                    </div>
                    <div class="tipos-status">
                        <span class="recusado"></span>
                        <h3>Recusado</h3>
                        <span class="aguardando"></span>
                        <h3>Aguardando análise</h3>
                        <span class="em-analise"></span>
                        <h3>Em análise</h3>
                        <span class="retirada"></span>
                        <h3>Aguardando retirada</h3>
                        <span class="concluido"></span>
                        <h3>Concluído</h3>
                    </div>
                </div>
                <div class="meus-chamados">
                    <?php
                    $sql = "SELECT * FROM Computador WHERE Servidor_idServidor = $idServidor ORDER BY CASE status
                        WHEN 'Aguardando retirada' THEN 1
                        WHEN 'Em análise' THEN 2
                        WHEN 'Aguardando análise    ' THEN 3
                        WHEN 'Recusado' THEN 4
                        WHEN 'Concluído' THEN 5
                        ELSE 6
                      END";
                    $dados = $conn->query($sql);
                    if ($dados->num_rows > 0) {
                        while ($exibir = $dados->fetch_assoc()) {
                            $date = date_create($exibir["Data"]);
                            $adm = $exibir["Admin_idAdmin"];
                            $statusClass = '';
                            $referencia = '';
                            switch (strtolower($exibir["Status"])) {
                                case 'aguardando análise':
                                    $statusClass = 'status-aguardando';
                                    break;
                                case 'em análise':
                                    $statusClass = 'status-em-analise';
                                    break;
                                case 'concluído':
                                    $statusClass = 'status-concluido';
                                    break;
                                case 'recusado':
                                    $statusClass = 'status-recusado';
                                    break;

                                case 'aguardando retirada':
                                    $statusClass = 'status-retirada';
                                    break;
                                default:

                                    break;
                            }
                    ?>
                            <div class="chamado">
                                <div class="<?= $statusClass; ?>">
                                    <span><?php echo $exibir["NumOS"] ?></span>
                                </div>

                                <div class="data-chamado">
                                    <?php
                                    $date = date_create($exibir["Data"]);

                                    $date2 = $exibir["Finalizado"];
                                    echo  "Aberto em: " . date_format($date, 'd/m/Y H:i') . "<br>"; // Formate a data .
                                    if ($date2 == null) {
                                        echo "Última atualização: -";
                                    } else {
                                        $date2 = date_create($exibir["Finalizado"]);
                                        echo "Última atualização: " . date_format($date2, 'd/m/Y H:i');
                                    }
                                    ?>
                                </div>
                                <div class="opcoes-chamado">
                                    <div class="opcao-editar">
                                        <a href="#" title="Editar" onclick="editarChamado('<?php echo $exibir['idComputador'] ?>','<?php echo $exibir['NumOS'] ?>')"><i class="fas fa-eye"></i></a>
                                    </div>

                                    <?php
                                    if ($exibir["Status"] == "Aguardando análise") {
                                    ?>
                                        <div class="opcao-excluir">
                                            <a href="#" title="Excluir" onclick="excluirChamado('<?php echo $exibir['idComputador'] ?>','<?php echo $exibir['NumOS'] ?>', 'Computador')"><i class="fas fa-trash-alt"></i></a>
                                        </div>

                                    <?php
                                    }
                                    ?>

                                    <?php

                                    if ($exibir["Status"] == "Aguardando retirada") {
                                    ?>
                                        <div class="opcao-concluir">
                                            <a href="#" title="Concluir o serviço" onclick="concluirChamado('<?php echo $exibir['idComputador'] ?>','<?php echo $exibir['NumOS'] ?>','Computador')"><i class="fa fa-handshake-o"></i></a>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                </div>

                <div class="abrir-chamado">
                    <span>Caso esteja com problemas no seu equipamento </span>
                    <div class="btn-enviar">
                        <button onclick="abrirPassosResolucao()" id="abrirModal"> Clique aqui</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Passo a passo para a resolução do problema -->
        <div class="passos-problema" id="passos-problema" style="display: none;">
            <!-- Fechar o modal -->
            <div class="btn-fechar">
                <button onclick="abrirPassosResolucao()"><img src="/Helpdesk/Image/icon-close.png" alt=""></button>
            </div>
            <!-- Titulo do chamado -->
            <div class="categoria-chamado">
                <!-- Imagem do chamado -->
                <img src="/Helpdesk/Image/icone-computador.png" alt="Imagem computador">

                <!-- Titulo do chamado -->
                <span>Computador e Notebook</span>

            </div>
            <h2>Realize os testes abaixo:</h2>
            <h3>Teste 1:</h3>
            <ul>
                <li>Retire o equipamento de internet da tomada, aguarde 1 minuto e ligue novamente. Após 3 minutos o equipamento se estabilizará e voltará a conexão.</li>
            </ul>
            <h3>Teste 2:</h3>
            <ul>
                <li>Reinicie o computador e verifique se a conexão normalizou.</li>
            </ul>
            <h3>Teste 3:</h3>
            <ul>
                <li>Em caso de conexão via cabo de rede, verificar se o cabo está devidamente conectado no computador.</li>
            </ul>
            <span>Caso problema não tenha sido resolvido: <a href="#" onclick="abrirModalChamado()">Abra um chamado!</a></span>

        </div>

        <!-- div do formulário de abertura de chamado -->
        <div class="div-formulario-chamado" id="modalFormulario" style="display: none;">

            <!-- Fechar o modal -->
            <div class="btn-fechar">
                <button onclick="abrirModalChamado()"><img src="/Helpdesk/Image/icon-close.png" alt=""></button>
            </div>
            <form action="#" class="formulario-chamado">
                <!-- Titulo do chamado -->
                <div class="categoria-chamado">
                    <!-- Imagem do chamado -->
                    <img src="/Helpdesk/Image/icone-computador.png" alt="Imagem computador">

                    <!-- Titulo do chamado -->
                    <span>Computador e Notebook</span>

                </div>

                <!-- Local do chamado -->
                <div class="input-group-chamado">
                    <input type="text" name="local-chamado" placeholder="Local">
                </div>

                <!-- Setor do usuário -->
                <div class="select-group-chamado">
                    <select name="setor-chamado" id="setor-chamado">
                        <option value="#" selected disabled>Selecione o setor</option>
                        <?php
                        $sql = "SELECT idSetor, Nome FROM setor ORDER BY nome ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["idSetor"] . '">' . $row["Nome"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <!-- Responsável pelo chamado -->
                <div class="input-group-chamado">
                    <input type="text" name="responsavel-chamado" placeholder="Responsável pelo chamado">
                </div>

                <!-- Senha do equipamento -->
                <div class="input-group-chamado">
                    <input type="text" name="senha-chamado" placeholder="Senha do equipamento">
                </div>
                <!-- Nº do patrimônio -->
                <div class="input-group-chamado">
                    <input type="text" class="num-patrimonio-chamado" placeholder="Nº do chamado">
                </div>
                <!-- Descrição do problema -->
                <div class="input-group-chamado">
                    <textarea name="descricao-problema" cols="60" rows="10" placeholder="Descrição do problema"></textarea>
                </div>
                <!-- Checkbox para itens que vão acompanhar o equipamento -->
                <div class="span-itens">
                    <label for="itens">Marque os itens que você vai enviar junto com o:</label>
                </div>
                <div class="itens-chamado">
                    <div class="checkbox-item">
                        <input type="checkbox" value="Backup" name="outros[]">
                        <label for="outros">Backup</label>
                    </div>

                    <div class="checkbox-item">
                        <input type="checkbox" value="Fonte" name="outros[]">
                        <label for="outros">Fonte</label>
                    </div>

                    <div class="checkbox-item">
                        <input type="checkbox" value="Teclado" name="outros[]">
                        <label for="outros">Teclado</label>
                    </div>

                    <div class="checkbox-item">
                        <input type="checkbox" value="Mouse" name="outros[]">
                        <label for="outros">Mouse</label>
                    </div>

                    <div class="checkbox-item">
                        <input type="checkbox" value="Monitor" name="outros[]">
                        <label for="outros">Monitor</label>
                    </div>

                    <div class="checkbox-item">
                        <input type="checkbox" value="Cabos" name="outros[]">
                        <label for="outros">Cabos</label>
                    </div>
                </div>
                <!-- Botão de evniar -->
                <div class="btn-enviar">
                    <button type="submit" id="entrar">ENVIAR</button>
                </div>
            </form>
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

        <!-- Botão para abrir o campo de suporte -->
        <div class="botao-suporte">
            <button onclick="abrirSuporte()">
                <div class="icone-button">
                    <img src="/Helpdesk/Image/icone-suporteM.png" alt="Ícone suporte">
                </div>
            </button>
        </div>
<?php
                    }
                }

?>
</body>


</html>