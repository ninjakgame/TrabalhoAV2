// ================= ELEMENTOS =================
const nomeInput = document.getElementById("nome");
const emailInput = document.getElementById("email");
const senhaInput = document.getElementById("senha");
const cpfInput = document.getElementById("cpf");
const telefoneInput = document.getElementById("telefone");
const cepInput = document.getElementById("cep");
const infoCep = document.getElementById("infoCep");
const barraSenha = document.getElementById("barraSenha");
const forcaSenha = document.getElementById("forcaSenha");
const requisitosSenha = document.getElementById("requisitosSenha");

let dadosTemp = {};

// ================= FUNÇÕES =================
function marcarErro(campo) {
    campo.classList.add("error");
}

function limparErro(campo) {
    campo.classList.remove("error");
}

// ================= CEP =================

// 🔥 máscara CEP
cepInput.addEventListener("input", function () {
    let v = this.value.replace(/\D/g, "").slice(0, 8);

    if (v.length > 5) {
        this.value = v.slice(0, 5) + "-" + v.slice(5);
    } else {
        this.value = v;
    }
});

// 🔥 validação CEP
function validarCEP(cep) {
    cep = cep.replace(/\D/g, "");

    if (cep.length !== 8) return false;

    if (/^(\d)\1+$/.test(cep)) return false;

    return true;
}

// 🔥 busca CEP
cepInput.addEventListener("blur", async () => {

    const cep = cepInput.value.replace(/\D/g, "");

    if (!validarCEP(cep)) {
        marcarErro(cepInput);
        infoCep.innerHTML = "";
        return;
    }

    try {
        const resposta = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const dados = await resposta.json();

        if (dados.erro) {
            marcarErro(cepInput);
            infoCep.innerHTML = "";
        } else {
            limparErro(cepInput);

            infoCep.innerHTML = `
                <p><strong>Rua:</strong> ${dados.logradouro}</p>
                <p><strong>Bairro:</strong> ${dados.bairro}</p>
                <p><strong>Cidade:</strong> ${dados.localidade}</p>
                <p><strong>Estado:</strong> ${dados.uf}</p>
            `;
        }

    } catch {
        marcarErro(cepInput);
    }
});

// ================= SENHA =================
senhaInput.addEventListener("input", function () {

    const senha = this.value;

    let temMaiuscula = /[A-Z]/.test(senha);
    let temMinuscula = /[a-z]/.test(senha);
    let temNumero = /\d/.test(senha);
    let temSimbolo = /[!@#$%^&*(),.?":{}|<>]/.test(senha);
    let tamanho = senha.length >= 6;

    let pontos = 0;

    if (temMaiuscula) pontos++;
    if (temMinuscula) pontos++;
    if (temNumero) pontos++;
    if (temSimbolo) pontos++;
    if (tamanho) pontos++;

    let porcentagem = (pontos / 5) * 100;
    barraSenha.style.width = porcentagem + "%";

    if (senha.length === 0) {
        barraSenha.style.width = "0%";
        forcaSenha.innerHTML = "";
    } else if (pontos <= 2) {
        barraSenha.style.background = "red";
        forcaSenha.innerHTML = "Senha fraca";
    } else if (pontos <= 4) {
        barraSenha.style.background = "orange";
        forcaSenha.innerHTML = "Senha média";
    } else {
        barraSenha.style.background = "green";
        forcaSenha.innerHTML = "Senha forte";
    }

    requisitosSenha.innerHTML = `
        <p class="${temMaiuscula ? 'ok' : 'erro'}">Letra maiúscula</p>
        <p class="${temMinuscula ? 'ok' : 'erro'}">Letra minúscula</p>
        <p class="${temNumero ? 'ok' : 'erro'}">Número</p>
        <p class="${temSimbolo ? 'ok' : 'erro'}">Símbolo</p>
        <p class="${tamanho ? 'ok' : 'erro'}">Mínimo 6 caracteres</p>
    `;

    senha.addEventListener("blur", function () {
    if (!validarTelefone(this.value)) {
        marcarErro(this);
    } else {
        limparErro(this);
    }
});
});

// ================= CPF =================
function validarCPF(cpf) {
    cpf = cpf.replace(/\D/g, "");
    if (cpf.length !== 11) return false;
    if (/^(\d)\1+$/.test(cpf)) return false;

    let soma = 0;
    for (let i = 0; i < 9; i++) soma += cpf[i] * (10 - i);

    let resto = (soma * 10) % 11;
    if (resto === 10) resto = 0;
    if (resto != cpf[9]) return false;

    soma = 0;
    for (let i = 0; i < 10; i++) soma += cpf[i] * (11 - i);

    resto = (soma * 10) % 11;
    if (resto === 10) resto = 0;

    return resto == cpf[10];
}

// máscara CPF
cpfInput.addEventListener("input", function () {
    let v = this.value.replace(/\D/g, "").slice(0, 11);
    v = v.replace(/(\d{3})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    this.value = v;
});

// validação CPF
cpfInput.addEventListener("blur", function () {
    if (!validarCPF(this.value)) {
        marcarErro(this);
    } else {
        limparErro(this);
    }
});

// ================= TELEFONE =================

// máscara telefone
telefoneInput.addEventListener("input", function () {
    let v = this.value.replace(/\D/g, "").slice(0, 11);

    if (v.length > 6) {
        this.value = `(${v.slice(0, 2)}) ${v.slice(2, 7)}-${v.slice(7)}`;
    } else if (v.length > 2) {
        this.value = `(${v.slice(0, 2)}) ${v.slice(2)}`;
    } else {
        this.value = v;
    }
});

// validação telefone REAL
function validarTelefone(tel) {
    tel = tel.replace(/\D/g, "");

    if (tel.length < 10 || tel.length > 11) return false;

    const ddd = tel.substring(0, 2);

    const dddsValidos = [
        "11","12","13","14","15","16","17","18","19",
        "21","22","24",
        "27","28",
        "31","32","33","34","35","37","38",
        "41","42","43","44","45","46",
        "47","48","49",
        "51","53","54","55",
        "61",
        "62","64",
        "63",
        "65","66",
        "67",
        "68",
        "69",
        "71","73","74","75","77",
        "79",
        "81","87",
        "82",
        "83",
        "84",
        "85","88",
        "86","89",
        "91","93","94",
        "92","97",
        "95",
        "96",
        "98","99"
    ];

    if (!dddsValidos.includes(ddd)) return false;

    const numero = tel.substring(2);

    if (/^(\d)\1+$/.test(numero)) return false;

    if (tel.length === 11 && numero[0] !== "9") return false;

    return true;
}

// validação visual telefone
telefoneInput.addEventListener("blur", function () {
    if (!validarTelefone(this.value)) {
        marcarErro(this);
    } else {
        limparErro(this);
    }
});

// ================= WHATSAPP =================
function enviarWhatsApp(nome, telefone, cpf, cep) {

    const numeroEmpresa = "5585999851307";

    const mensagem =
`Olá, gostaria de fazer um cadastro:

Nome: ${nome}
Email: ${emailInput.value}
Telefone: ${telefone}
CPF: ${cpf}
CEP: ${cep}`;

    const url = `https://wa.me/${numeroEmpresa}?text=${encodeURIComponent(mensagem)}`;
    window.open(url, "_blank");
}

// ================= FORM =================
function validarForm() {

    // limpa erros antes
    const campos = [nomeInput, emailInput, senhaInput, cpfInput, telefoneInput, cepInput];
    campos.forEach(c => c.classList.remove("error"));

    // 1️⃣ Nome
    if (nomeInput.value.trim() === "") {
        marcarErro(nomeInput);
        nomeInput.focus();
        alert("Digite seu nome!");
        return false;
    }

    const email = emailInput.value.toLowerCase();

    const emailValido = dominiosPermitidos.some(d => email.endsWith(d));

    if (!emailValido) {
        marcarErro(emailInput);
        emailInput.focus();
        alert("Use Gmail, Hotmail, Outlook ou empresa.com!");
        return false;
    }

    // 3️⃣ Senha
    if (senhaInput.value.length < 6) {
        marcarErro(senhaInput);
        senhaInput.focus();
        alert("Senha deve ter pelo menos 6 caracteres!");
        return false;
    }

    // 4️⃣ CPF
    if (!validarCPF(cpfInput.value)) {
        marcarErro(cpfInput);
        cpfInput.focus();
        alert("CPF inválido!");
        return false;
    }

    // 5️⃣ Telefone
    if (!validarTelefone(telefoneInput.value)) {
        marcarErro(telefoneInput);
        telefoneInput.focus();
        alert("Telefone inválido!");
        return false;
    }

    // 6️⃣ CEP
    if (!validarCEP(cepInput.value)) {
        marcarErro(cepInput);
        cepInput.focus();
        alert("CEP inválido!");
        return false;
    }

    // ✅ Se passou tudo
    dadosTemp = {
        nome: nomeInput.value,
        cpf: cpfInput.value,
        telefone: telefoneInput.value,
        cep: cepInput.value
    };

    document.getElementById("modalEscolha").style.display = "block";

    return false;
}

// ================= MODAL =================
function fecharModal() {
    document.getElementById("modalEscolha").style.display = "none";
}

function acaoWhats() {
    enviarWhatsApp(
        dadosTemp.nome,
        dadosTemp.telefone,
        dadosTemp.cpf,
        dadosTemp.cep
    );
}

function acaoTabela() {
    window.location.href = "form-cadastro.html";
}