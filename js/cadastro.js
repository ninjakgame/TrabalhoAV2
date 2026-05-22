function mostrarMensagem(texto, tipo){
    const msg = document.getElementById("mensagem");

    msg.textContent = texto;
    msg.className = "mensagem mostrar " + tipo;

    setTimeout(() => {
        msg.classList.remove("mostrar");
    }, 3000);
}

function validar(){
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const confirmarSenha = document.getElementById("confirmarSenha").value;

    if(senha !== confirmarSenha){
        mostrarMensagem("As senhas não coincidem!", "erro");
        return false;
    }

    const usuario = {
        nome,
        email,
        senha
    };

    localStorage.setItem("usuario", JSON.stringify(usuario));

    mostrarMensagem("Cadastro realizado com sucesso!", "sucesso");

    setTimeout(() => {
        window.location.href = "login.html";
    }, 1500);

    return false;
}

function login(){
    window.location.href = "login.html";
}