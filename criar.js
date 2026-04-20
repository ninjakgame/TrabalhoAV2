document.addEventListener("DOMContentLoaded", function () {

    const hoje = new Date();
    const dataMin = hoje.toISOString().split('T')[0];

    const dataMaxObj = new Date();
    dataMaxObj.setFullYear(dataMaxObj.getFullYear() + 1);
    const dataMax = dataMaxObj.toISOString().split('T')[0];

    const dataInput = document.getElementById("dataAgendamento");

    if (dataInput) {
        dataInput.setAttribute("min", dataMin);
        dataInput.setAttribute("max", dataMax);
    }

    const nomeInput = document.getElementById("nome");
    if (nomeInput) {
        nomeInput.addEventListener("input", function () {
            this.value = this.value.toUpperCase();
        });
    }

    // carregar edição
    const editarId = localStorage.getItem("editarId");

    if (editarId) {
        let lista = JSON.parse(localStorage.getItem("cadastros")) || [];

        const item = lista.find(i => i.id == editarId);

        if (item) {
            document.getElementById("nome").value = item.nome;
            document.getElementById("email").value = item.email;
            document.getElementById("agenda").value = item.agendamento || "";
            document.getElementById("dataAgendamento").value = item.data || "";
        }
    }
});

function validarSenha() {

    let lista = JSON.parse(localStorage.getItem("cadastros")) || [];

    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const agenda = document.getElementById("agenda").value;
    const data = document.getElementById("dataAgendamento").value;

    const editarId = localStorage.getItem("editarId");

    if (!agenda) {
        alert("Escolha um tipo de agendamento!");
        return false;
    }

    if (editarId) {
        // 🔥 EDITAR
        const index = lista.findIndex(i => i.id == editarId);

        if (index !== -1) {
            lista[index].nome = nome;
            lista[index].email = email;
            lista[index].agendamento = agenda;
            lista[index].data = data;
        }

        localStorage.removeItem("editarId");

    } else {
        // 🔥 CRIAR NOVO (caso use a mesma tela)
        const novo = {
            id: Date.now(),
            nome,
            email,
            agendamento: agenda,
            data,
            status: "Agendamento"
        };

        lista.push(novo);
    }

    const dataSelecionada = new Date(data + "T00:00:00");
    const hoje = new Date();
    hoje.setHours(0, 0, 0, 0);

    const limiteMax = new Date();
    limiteMax.setFullYear(hoje.getFullYear() + 1);

    // ❌ menor que hoje
    if (dataSelecionada < hoje) {
        alert("Não pode escolher uma data passada!");
        return false;
    }

    // ❌ maior que 1 ano
    if (dataSelecionada > limiteMax) {
        alert("Você só pode agendar até 1 ano à frente!");
        return false;
    }

    localStorage.setItem("cadastros", JSON.stringify(lista));

    window.location.href = "form-cadastro.html";

    return false;
}