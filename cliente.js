function validarSenha() {
    const nomeInput = document.getElementById("nome");
    const emailInput = document.getElementById("email");
    const cpfInput = document.getElementById("cpf");
    const telefoneInput = document.getElementById("telefone");
    const senhaInput = document.getElementById("senha");
    const enderecoInput = document.getElementById("rua");
    const numeroInput = document.getElementById("numero");
    const cidadeInput = document.getElementById("cidade");

    // Verificações individuais
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

    if (cpfInput.value === "") {
        alert("Você esqueceu de colocar o CPF!");
        destacarCampo(cpfInput);
        return false;
    }

    if (telefoneInput.value === "") {
        alert("Você esqueceu de colocar o telefone!");
        destacarCampo(telefoneInput);
        return false;
    }

    if (enderecoInput.value === "") {
        alert("Você esqueceu de colocar o seu endereço (Rua)!");
        destacarCampo(enderecoInput);
        return false;
    }

    if (numeroInput.value === "") {
        alert("Você esqueceu de colocar o número da casa!");
        destacarCampo(numeroInput);
        return false;
    }

    if (cidadeInput.value === "") {
        alert("Você esqueceu de colocar a cidade!");
        destacarCampo(cidadeInput);
        return false;
    }

    alert("Cadastro realizado com sucesso!");
    return true;
}


//Função global para destacar o campo
function destacarCampo(campo) {
    campo.focus();

    if (campo.value === "") {
        campo.classList.add("error"); // Borda vermelha
    } else {
        campo.classList.remove("error");
    }
}


//Remove o erro quando o usuário começa a digitar
document.querySelectorAll("input, select").forEach(campo => {
    campo.addEventListener("input", () => {
        if (campo.value !== "") {
            campo.classList.remove("error");
        }
    });
});

document.getElementById("cpf").addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, ""); // Remove tudo que não for número
});

// Permitir somente números Telefone
document.getElementById("telefone").addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, ""); // Remove tudo que não for número
});

// Permitir somente números Telefone
document.getElementById("cep").addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, ""); // Remove tudo que não for número
});

// Permitir somente números Telefone
document.getElementById("numero").addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, ""); // Remove tudo que não for número
});

document.getElementById("rua").addEventListener("input", function(){
    this.value = this.value.replace(/[0-9]/g, ""); //Remove tudo que nao for letra
})

document.getElementById("cidade").addEventListener("input", function(){
    this.value = this.value.replace(/[0-9]/g, ""); //Remove tudo que nao for letra
})