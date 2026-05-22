// ===============================
// MENU MOBILE
// ===============================

const menu = document.getElementById("menuLinks");
const overlay = document.getElementById("overlay");

function abrirMenu() {

    menu.classList.toggle("ativo");
    overlay.classList.toggle("ativo");

    // TROCAR ÍCONE
    const icon = document.querySelector(".menuMobile i");

    if (menu.classList.contains("ativo")) {
        icon.classList.remove("fa-bars");
        icon.classList.add("fa-xmark");
    } else {
        icon.classList.remove("fa-xmark");
        icon.classList.add("fa-bars");
    }
}

// FECHAR MENU AO CLICAR NO LINK

const links = document.querySelectorAll(".links a");

links.forEach(link => {
    link.addEventListener("click", () => {

        menu.classList.remove("ativo");
        overlay.classList.remove("ativo");

        const icon = document.querySelector(".menuMobile i");

        icon.classList.remove("fa-xmark");
        icon.classList.add("fa-bars");
    });
});

// ===============================
// ANIMAÇÃO AO SCROLL
// ===============================

function animarScroll() {

    const elementos = document.querySelectorAll(".animacao");

    elementos.forEach(el => {

        const topo = el.getBoundingClientRect().top;
        const alturaTela = window.innerHeight;

        if (topo < alturaTela - 100) {
            el.classList.add("ativo");
        }
    });
}

window.addEventListener("scroll", animarScroll);
window.addEventListener("load", animarScroll);

// ===============================
// FAQ ABRIR E FECHAR
// ===============================

const perguntas = document.querySelectorAll(".pergunta");

perguntas.forEach(pergunta => {

    pergunta.addEventListener("click", () => {

        const item = pergunta.parentElement;

        item.classList.toggle("ativo");
    });
});

// ===============================
// VER MAIS FAQ
// ===============================

const botao = document.querySelector(".ver-mais");
const extras = document.querySelectorAll(".extra");

if (botao) {

    botao.addEventListener("click", () => {

        extras.forEach(el => {

            el.classList.add("mostrar");
        });

        botao.style.display = "none";
    });
}

// ===============================
// BOTÃO AGENDAR
// ===============================

function agora() {

    window.location.href = "cadastroCliente.html";
}

function agendar() {

    window.location.href = "login.php";
}

// ===============================
// FORMULÁRIO
// ===============================

function enviar() {

    const nome = document.getElementById("nome");
    const email = document.getElementById("email");
    const mensagem = document.getElementById("mensagem");

    // VERIFICAR SE EXISTE

    if (!nome || !email || !mensagem) {

        alert("Campos não encontrados.");
        return;
    }

    // PEGAR VALORES

    const valorNome = nome.value.trim();
    const valorEmail = email.value.trim();
    const valorMensagem = mensagem.value.trim();

    // VALIDAR

    if (
        valorNome === "" ||
        valorEmail === "" ||
        valorMensagem === ""
    ) {

        alert("Preencha todos os campos.");
        return;
    }

    // EMAIL VÁLIDO

    const emailValido =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailValido.test(valorEmail)) {

        alert("Digite um e-mail válido.");
        return;
    }

    // SUCESSO

    alert("Mensagem enviada com sucesso para " + valorEmail);

    window.location.href = "paginaInicial.html";
}

