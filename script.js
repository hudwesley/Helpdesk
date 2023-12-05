// animação aparecer

function fadeIn(element) {
    element.style.display = 'flex';
    element.style.opacity = 0;

    let opacity = 0;
    const fadeInInterval = setInterval(function() {
        if (opacity < 1) {
            opacity += 0.1;
            element.style.opacity = opacity;
        } else {
            clearInterval(fadeInInterval);
        }
    }, 50);
}

// animação desaparecer
function fadeOut(element) {
    let opacity = 1;
    const fadeOutInterval = setInterval(function() {
        if (opacity > 0) {
            opacity -= 0.1;
            element.style.opacity = opacity;
        } else {
            element.style.display = 'none';
            clearInterval(fadeOutInterval);
        }
    }, 50);
}

// Função para alternar a exibição da descrição de chamados
function descricaoChamados() {
    // Seleciona a div de descrição de chamados e o container
    const divDescricaoChamados = document.getElementById('div-descricao-chamados');
    const container = document.getElementById('container');

    // Verifica se a div de descrição de chamados está oculta
    const isHidden = divDescricaoChamados.style.display === 'none';

    // Altera a exibição da div de descrição de chamados e a opacidade do container
    divDescricaoChamados.style.display = isHidden ? 'flex' : 'none';
    container.style.opacity = isHidden ? '0.2' : '1';
}



// Modifique as funções existentes para chamar fadeIn e fadeOut
function abrirSuporte() {
    const divSuporte = document.getElementById('div-suporte');

    if (divSuporte.style.display == 'none') {
        fadeIn(divSuporte);
    } else {
        fadeOut(divSuporte);
    }
}

// Abrir passo a passo para resolução do chamado
function abrirPassosResolucao() {
    const passos_problema = document.getElementById('passos-problema');

    if (passos_problema.style.display == 'none') {
        fadeIn(passos_problema);
    } else {
        fadeOut(passos_problema);
    }
}

// Abrir o formulário para criar chamado
function abrirModalChamado() {
    const modalFormulario = document.getElementById('modalFormulario');
    const container = document.getElementById('container');

    if (modalFormulario.style.display === 'none' || modalFormulario.style.display === '') {
        fadeIn(modalFormulario);
    } else {
        fadeOut(modalFormulario);
    }
}