document.addEventListener("DOMContentLoaded", () => {
    window.formulario = new Formulario(
        "/Controle/EPI",
        "update",
        "form-update"
    );
});

function limparCamposEPI() {
    document.getElementById("nomeEPI").value = "";
    document.getElementById("descricaoEPI").value = "";
    document.getElementById("dataValidade").value = "";
    document.getElementById("btnSalvarEPI").disabled = true;
}
function editarEPI(event) {
    event.preventDefault();
    if (window.formulario) {
        window.formulario.enviarFormulario(event);
    } else {
        console.error("Classe Formulario não inicializada!");
    }
}

function habilitarEdicao() {
    const campos = document.querySelectorAll(
        '#form-update [data-editavel="true"]'
    );
    campos.forEach((campo) => {
        campo.removeAttribute("readonly");
        campo.setAttribute("required", "true");
    });
    document.getElementById("btnSalvarAlteracoes").style.display =
        "inline-block";
    document.getElementById("btnHabilitarEdicao").disabled = true;
    document.getElementById("btnCancelarEdicao").disabled = false;
    document.getElementById("btnSalvarAlteracoes").disabled = false;
    Swal.fire({
        title: "Edição Habilitada",
        text: "Você pode editar os campos agora.",
        icon: "info",
        timer: 2000,
        showConfirmButton: false,
    });
}

function procurarCA(ca) {
    fetch(`http://${window.location.hostname}:3000/CA/${ca}`)
        .then((response) => response.json())
        .then((data) => {
            if (!data || data.sucess === false) {
                swal.fire({
                    title: "CA não encontrado",
                    text: "Nenhum EPI encontrado com o CA informado.",
                    icon: "warning",
                });
                limparCamposEPI();
                return;
            }
            let dataValidade = null;
            if (data.DataValidade) {
                let dataValidadeString = data.DataValidade;
                if (/^\d{2}\/\d{2}\/\d{4}$/.test(dataValidadeString)) {
                    const [dia, mes, ano] = dataValidadeString.split("/");
                    dataValidadeString = `${ano}-${mes}-${dia}`;
                }
                dataValidade = new Date(dataValidadeString);
                if (!isNaN(dataValidade)) {
                    const hoje = new Date();
                    if (dataValidade < hoje) {
                        swal.fire({
                            title: "EPI Vencido",
                            text: "O EPI associado a este CA está vencido.",
                            icon: "warning",
                        });
                        document.getElementById("btnSalvarAlteracoes").disabled = true;
                        return;
                    }
                } else {
                    console.warn(
                        "Data de validade inválida:",
                        data.DataValidade
                    );
                }
            }
            document.getElementById("nomeEPI").value =
                data.NomeEquipamento || "";
            document.getElementById("descricaoEPI").value =
                data.DescricaoEquipamento || "";
            if (dataValidade && !isNaN(dataValidade)) {
                document.getElementById("dataValidade").value = dataValidade
                    .toISOString()
                    .split("T")[0];
            } else {
                document.getElementById("dataValidade").value = "";
            }
            const btnSalvar = document.getElementById("btnSalvarAlteracoes");
            btnSalvar.disabled = false;
            const novoBotao = btnSalvar.cloneNode(true);
            btnSalvar.parentNode.replaceChild(novoBotao, btnSalvar);
            novoBotao.addEventListener("click", (event) => salvarEPI(event));
        })
        .catch((error) => {
            console.error("Erro ao procurar EPI por CA:", error);
            swal.fire({
                title: "Erro",
                text: "Falha ao buscar informações do CA.",
                icon: "error",
            });
        });
}
