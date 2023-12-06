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
    const divDescricaoChamados = document.getElementById('div-descricao-chamados');
    const container = document.getElementById('container');
    const isHidden = divDescricaoChamados.style.display === 'none';

    if (isHidden) {
        fadeIn(divDescricaoChamados);
    } else {
        fadeOut(divDescricaoChamados);
    }
}

// Modifique as funções existentes para chamar fadeIn e fadeOut
function abrirSuporte() {
    const divSuporte = document.getElementById('div-suporte');
    const isHidden = divSuporte.style.display === 'none';

    if (isHidden) {
        fadeIn(divSuporte);
    } else {
        fadeOut(divSuporte);
    }
}

// Abrir passo a passo para resolução do chamado
function abrirPassosResolucao() {
    const passosProblema = document.getElementById('passos-problema');
    const isHidden = passosProblema.style.display === 'none';

    if (isHidden) {
        fadeIn(passosProblema);
    } else {
        fadeOut(passosProblema);
    }
}

// Abrir o formulário para criar chamado
function abrirModalChamado() {
    const modalFormulario = document.getElementById('modalFormulario');
    const container = document.getElementById('container');
    const isHidden = modalFormulario.style.display === 'none' || modalFormulario.style.display === '';

    if (isHidden) {
        fadeIn(modalFormulario);
    } else {
        fadeOut(modalFormulario);
    }
}
