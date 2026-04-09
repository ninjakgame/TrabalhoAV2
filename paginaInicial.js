// FAQ abrir e fechar

/*const buttons = document.querySelectorAll(".faq-btn");

buttons.forEach(btn => {
    btn.addEventListener("click", function () {
        const content = this.nextElementSibling;
        if (content.style.display === "block") {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }
    });
});

const elementos = document.querySelectorAll('.scroll-animacao');

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('mostrar');
        }
    });
}, { threshold: 0.15 }); // Quando 15% do elemento aparecer

elementos.forEach(elemento => observer.observe(elemento));

*/

function agendar(){
    window.location.href = 'login.html';
}


function animarScroll() {
  const elementos = document.querySelectorAll('.animacao');

  elementos.forEach(el => {
    const topo = el.getBoundingClientRect().top;
    const alturaTela = window.innerHeight;

    if (topo < alturaTela - 100) {
      el.classList.add('ativo');
    }
  });
}
// ABRIR / FECHAR
const perguntas = document.querySelectorAll('.pergunta');

perguntas.forEach(pergunta => {
  pergunta.addEventListener('click', () => {
    const item = pergunta.parentElement;
    item.classList.toggle('ativo');
  });
});

// VER MAIS
const botao = document.querySelector('.ver-mais');
const extras = document.querySelectorAll('.extra');

botao.addEventListener('click', () => {
  extras.forEach(el => {
    el.classList.add('mostrar');
  });

  botao.style.display = 'none';
});

function agora(){
  window.location.href = "cadastroCliente.html"
}


window.addEventListener('scroll', animarScroll);
window.addEventListener('load', animarScroll);
