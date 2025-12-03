// Define a data mínima (hoje) para o agendamento - fora da função
document.addEventListener("DOMContentLoaded", function () {
    const hoje = new Date().toISOString().split('T')[0];
    document.getElementById("dataAgendamento").setAttribute("min", hoje);

    // Transformar o nome automaticamente para MAIÚSCULO enquanto digita
    const nomeInput = document.getElementById("nome");
    nomeInput.addEventListener("input", function () {
        this.value = this.value.toUpperCase();
    });
});

function validarSenha() {
    const nomeInput = document.getElementById("nome");
    const emailInput = document.getElementById("email");
    const senhaInput = document.getElementById("senha");
    const confirmarInput = document.getElementById("confirmarSenha");
    const agendaInput = document.getElementById("agenda");
    const dataInput = document.getElementById("dataAgendamento");

    // Função para destacar o campo com foco e borda vermelha
    function destacarCampo(campo) {
        campo.focus();
        if (campo.value == "") {
            campo.classList.add("error");
        } else {
            campo.classList.remove("error");
        }
    }

    // Remove erro ao digitar
    document.querySelectorAll("input, select").forEach(campo => {
        campo.addEventListener("input", () => {
            if (campo.value !== "") {
                campo.classList.remove("error");
            }
        });
    });

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

    if (agendaInput.value === "escolha") {
        alert("Por favor, selecione uma opção de agendamento!");
        destacarCampo(agendaInput);
        return false;
    }

    // Verificação da data
    const hoje = new Date().toISOString().split('T')[0];
    if (dataInput.value < hoje) {
        alert("A data do agendamento não pode ser anterior à data atual!");
        destacarCampo(dataInput);
        return false;
    }

    alert("Cadastro realizado com sucesso!");
    return true;
}
