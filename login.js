function mostrarMensagem(texto, tipo){
    const msg = document.getElementById("mensagem");

    msg.textContent = texto;
    msg.className = "mensagem mostrar " + tipo;

    setTimeout(() => {
        msg.classList.remove("mostrar");
    }, 3000);
}

function validar(){
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;

    const usuario = JSON.parse(localStorage.getItem("usuario"));

    if(!usuario){
        mostrarMensagem("Nenhum usuário cadastrado!", "erro");
        return false;
    }

    if(email === usuario.email && senha === usuario.senha){
        localStorage.setItem("logado", "true");

        mostrarMensagem("Login realizado!", "sucesso");

        setTimeout(() => {
            window.location.href = "index.html";
        }, 1500);

    } else {
        mostrarMensagem("Email ou senha incorretos!", "erro");
    }

    return false;
}

function cadastro(){
    window.location.href = "cadastro.html";
}