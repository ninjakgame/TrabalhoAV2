// FAQ abrir e fechar
const buttons = document.querySelectorAll(".faq-btn");

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

