document.addEventListener("DOMContentLoaded", function () {

    const nomeInput = document.getElementById("nome");

    // Deixar nome em maiúsculo
    nomeInput.addEventListener("input", function () {
        this.value = this.value.toUpperCase();
    });

    // Remove erro ao digitar
    document.querySelectorAll("input").forEach(campo => {
        campo.addEventListener("input", () => {
            if (campo.value !== "") {
                campo.classList.remove("error");
            }
        });
    });
});

function validarSenha() {
    const nomeInput = document.getElementById("nome");
    const emailInput = document.getElementById("email");
    const senhaInput = document.getElementById("senha");
    const confirmarInput = document.getElementById("confirmarSenha");

    function destacarCampo(campo) {
        campo.focus();
        campo.classList.add("error");
    }

    if (nomeInput.value === "") {
        alert("Você esqueceu de colocar o seu nome!");
        destacarCampo(nomeInput);
        return false;
    }

    if (emailInput.value === "") {
        alert("Você esqueceu de colocar o email!");
        destacarCampo(emailInput);
        return false;
    }

    if (senhaInput.value === "") {
        alert("Você esqueceu de colocar a senha!");
        destacarCampo(senhaInput);
        return false;
    }

    if (confirmarInput.value === "") {
        alert("Você esqueceu de confirmar a senha!");
        destacarCampo(confirmarInput);
        return false;
    }

    if (senhaInput.value !== confirmarInput.value) {
        alert("As senhas não são iguais!");
        destacarCampo(confirmarInput);
        return false;
    }

    alert("Cadastro realizado com sucesso!");

    // 🔥 REDIRECIONAMENTO AQUI
    window.location.href = "index.html";

    return false; // impede envio padrão
}