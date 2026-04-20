let selecionado = null;

document.addEventListener("DOMContentLoaded", carregarTabela);

function criar() {
    window.location.href = "criar.html";
}

function carregarTabela() {
    const tbody = document.getElementById("tbody");
    tbody.innerHTML = "";

    let lista = JSON.parse(localStorage.getItem("cadastros")) || [];

    lista.forEach((item, index) => {
        let linha = `
        <tr>
            <td><input type="radio" name="select" onclick="selecionado = ${item.id}"></td>
            <td>${index + 1}</td>
            <td>${item.nome}</td>
            <td>${item.email}</td>
            <td>${item.agendamento || "-"}</td>
            <td>${item.horario}</td>
            <td>${formatarData(item.data)}</td>

            <td>
                <span class="status 
                    ${item.status === "Agendamento" ? "agendamento" : ""}
                    ${item.status === "Na lista" ? "lista" : ""}
                    ${item.status === "Cancelado" ? "cancelado" : ""}
                ">
                    ${item.status}
                </span>
            </td>

            <td>
                <button onclick="ver(${item.id})">Ver</button>
                <button onclick="excluir(${item.id})">X</button>
            </td>
        </tr>
        `;

        tbody.innerHTML += linha;
    });
}

function ver(id) {
    let lista = JSON.parse(localStorage.getItem("cadastros"));
    
    const item = lista.find(i => i.id === id);

    document.getElementById("mNome").innerText = item.nome;
    document.getElementById("mEmail").innerText = item.email;
    document.getElementById("mAgenda").innerText = item.agendamento || "-";
    document.getElementById("mHorario").innerText = item.horario;
    document.getElementById("mData").innerText = formatarData(item.data);
    document.getElementById("mStatus").innerText = item.status;

    const statusEl = document.getElementById("mStatus");
    statusEl.className = "status";

    if (item.status === "Agendamento") statusEl.classList.add("agendamento");
    if (item.status === "Na lista") statusEl.classList.add("lista");
    if (item.status === "Cancelado") statusEl.classList.add("cancelado");

    document.getElementById("modal").style.display = "block";
}

function fecharModal() {
    document.getElementById("modal").style.display = "none";
}

function excluir(id) {
    let lista = JSON.parse(localStorage.getItem("cadastros"));

    lista = lista.filter(item => item.id !== id);

    localStorage.setItem("cadastros", JSON.stringify(lista));
    carregarTabela();
}

function editarSelecionado() {
    if (selecionado == null) {
        alert("Selecione um registro!");
        return;
    }

    localStorage.setItem("editarId", selecionado);
    window.location.href = "editar.html";
}

function formatarData(data) {
    if (!data) return "";
    const d = new Date(data);
    return d.toLocaleDateString("pt-BR");
}