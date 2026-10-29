const digito1 = document.getElementById('digito1');
const digito2 = document.getElementById('digito2');
const numeroVoto = document.getElementById('numeroVoto');
const nomeCandidato = document.getElementById('nome');
const timeCandidato = document.getElementById('time');
const aviso = document.getElementById('aviso');
const foto = document.getElementById('foto');
const fotoBox = document.getElementById('fotoBox');
const formUrna = document.getElementById('urnaForm');

let numeroDigitado = '';
let votoBranco = false;

function atualizarTela() {
    digito1.textContent = numeroDigitado[0] || '';
    digito2.textContent = numeroDigitado[1] || '';
    numeroVoto.value = votoBranco ? 'BRANCO' : numeroDigitado;

    const candidato = [...document.querySelectorAll('.candidate-option')]
        .find(item => item.dataset.numero === numeroDigitado);

    document.querySelectorAll('.candidate-option').forEach(item => {
        item.classList.toggle('active', item === candidato);
    });

    if (votoBranco) {
        nomeCandidato.textContent = 'VOTO EM BRANCO';
        timeCandidato.textContent = '—';
        aviso.textContent = 'Confirme para registrar seu voto em branco.';
        foto.removeAttribute('src');
        fotoBox.classList.remove('has-photo');
        return;
    }

    if (numeroDigitado.length === 2 && candidato) {
        nomeCandidato.textContent = candidato.dataset.nome;
        timeCandidato.textContent = candidato.dataset.time;
        aviso.textContent = 'Confira os dados e pressione CONFIRMA.';
        foto.src = `assets/img/${candidato.dataset.foto}`;
        fotoBox.classList.add('has-photo');
        foto.onerror = () => fotoBox.classList.remove('has-photo');
    } else if (numeroDigitado.length === 2) {
        nomeCandidato.textContent = 'VOTO NULO';
        timeCandidato.textContent = 'Número não encontrado';
        aviso.textContent = 'Número inválido. Pressione CORRIGE para tentar novamente.';
        foto.removeAttribute('src');
        fotoBox.classList.remove('has-photo');
    } else {
        nomeCandidato.textContent = '—';
        timeCandidato.textContent = '—';
        aviso.textContent = numeroDigitado.length ? 'Digite o segundo número.' : 'Digite o número do seu candidato.';
        foto.removeAttribute('src');
        fotoBox.classList.remove('has-photo');
    }
}

function digitarNumero(numero) {
    if (votoBranco || numeroDigitado.length >= 2) return;
    numeroDigitado += String(numero);
    atualizarTela();
}

function corrigirVoto() {
    numeroDigitado = '';
    votoBranco = false;
    atualizarTela();
}

function selecionarBranco() {
    numeroDigitado = '';
    votoBranco = true;
    atualizarTela();
}

document.querySelectorAll('.number-key').forEach(botao => {
    botao.addEventListener('click', () => digitarNumero(botao.dataset.numero));
});

document.querySelectorAll('.candidate-option').forEach(botao => {
    botao.addEventListener('click', () => {
        numeroDigitado = botao.dataset.numero;
        votoBranco = false;
        atualizarTela();
    });
});

document.getElementById('btnCorrige').addEventListener('click', corrigirVoto);
document.getElementById('btnBranco').addEventListener('click', selecionarBranco);

document.addEventListener('keydown', evento => {
    if (/^[0-9]$/.test(evento.key)) digitarNumero(evento.key);
    if (evento.key === 'Backspace') corrigirVoto();
    if (evento.key.toLowerCase() === 'b') selecionarBranco();
    if (evento.key === 'Enter') {
        evento.preventDefault();
        formUrna.requestSubmit();
    }
});

formUrna.addEventListener('submit', evento => {
    const numero = numeroVoto.value;
    if (!numero) {
        evento.preventDefault();
        aviso.textContent = 'Digite um número ou escolha BRANCO antes de confirmar.';
        return;
    }
    if (numeroDigitado.length === 2) {
        const candidatoExiste = [...document.querySelectorAll('.candidate-option')]
            .some(item => item.dataset.numero === numeroDigitado);
        if (!candidatoExiste) numeroVoto.value = 'NULO';
    }
});

document.getElementById('formZerar').addEventListener('submit', evento => {
    if (!confirm('Tem certeza de que deseja apagar todos os votos?')) evento.preventDefault();
});

atualizarTela();
