document.addEventListener("DOMContentLoaded", function () {

    // Botões de excluir linhas
    document.querySelectorAll(".excluir").forEach(botao => {
        botao.addEventListener("click", function () {
            this.closest("tr").remove();
        });
    });

    // Remover erro ao digitar
    document.querySelectorAll("input, select").forEach(campo => {
        campo.addEventListener("input", () => campo.classList.remove("error"));
    });
});

function validarSenha(event) {
    event.preventDefault();

    const nomeInput = document.getElementById("nome");
    const emailInput = document.getElementById("email");
    const senhaInput = document.getElementById("senha");
    const confirmarInput = document.getElementById("confirmarSenha");
    const check = document.getElementById("confirmacao");
    const agendaInput = document.getElementById("eventos");
    const label = document.getElementById("labelConfirmacao");

    let formularioValido = true;
    let mensagem = "";

    function destacarCampo(campo) {
        campo.classList.add("error");
        campo.focus();
        formularioValido = false;
    }

    // --- VALIDAÇÕES ---
    if (nomeInput.value === "") {
        mensagem = "Você esqueceu de colocar o seu nome!";
        destacarCampo(nomeInput);
    }
    else if (emailInput.value === "") {
        mensagem = "Você esqueceu de colocar o email!";
        destacarCampo(emailInput);
    }
    else if (senhaInput.value === "") {
        mensagem = "Você esqueceu de colocar a senha!";
        destacarCampo(senhaInput);
    }
    else if (confirmarInput.value === "") {
        mensagem = "Você esqueceu de confirmar a senha!";
        destacarCampo(confirmarInput);
    }
    else if (senhaInput.value !== confirmarInput.value) {
        mensagem = "A senha e a confirmação não são iguais!";
        destacarCampo(confirmarInput);
    }
    else if (agendaInput.value === "escolha") {   // ⬅️ AGORA FUNCIONA!!
        mensagem = "Você precisa escolher uma opção de evento!";
        destacarCampo(agendaInput);
    }
    else if (!check.checked) {
        mensagem = "Você precisa aceitar os termos para continuar.";
        check.classList.add("checkErro");
        label.classList.add("checkErro");
        formularioValido = false;
    }

    // tirar erro ao marcar checkbox
    check.addEventListener("change", () => {
        if (check.checked) {
            check.classList.remove("checkErro");
            label.classList.remove("checkErro");
        }
    });

    if (!formularioValido) {
        alert(mensagem);
        return;
    }

    alert("Formulário enviado com sucesso!");
    document.querySelector("form").submit();
}

function criar(){
 window.location.href = "criar.html";
 }
 
 function editar(){
 window.location.href = "editar.html";
 }
