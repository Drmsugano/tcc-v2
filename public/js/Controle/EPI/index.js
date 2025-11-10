document.addEventListener("DOMContentLoaded", () => {
    // Inicializa a tabela dinâmica
    window.tabelaEpi = new TabelaDinamica({
        urlBase: "/Controle/EPI",
        corpoId: "corpoTabelaEpi",
        paginacaoId: "paginacaoEpi",
        colunas: ["CA", "NOME", "DESCRICAO", "QUANTIDADE_ESTOQUE"],
        acoes: [
            {
                nome: "Ver",
                texto: "Ver Detalhes",
                cor: "warning",
                callback: (id) => selecionar(id),
            },
        ],
        itensPorPagina: 10,
    });
    tabelaEpi.carregarDados(1, {}, false);
    window.formulario = new Formulario("/Controle/EPI", "store", "formNovoEPI", window.tabelaEpi);
});

function selecionar(id) {
    window.location.href = `/Controle/EPI/${id}`;
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
                        document.getElementById("btnSalvarEPI").disabled = true;
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
            const btnSalvar = document.getElementById("btnSalvarEPI");
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
function salvarEPI(event) {
    event.preventDefault();
    formulario.enviarFormulario(event);
}
function limparCamposEPI() {
    document.getElementById("nomeEPI").value = "";
    document.getElementById("descricaoEPI").value = "";
    document.getElementById("dataValidade").value = "";
    document.getElementById("btnSalvarEPI").disabled = true;
}

function limparFiltroEpi() {
    document.getElementById("filtroEpi").value = "";
    tabelaEpi.carregarDados(1, {}, false);
}
function pesquisarEpi(event) {
    event.preventDefault();
    const filtro = document.getElementById("filtroEpi").value;
    const filtros = {};
    if (filtro) {
        filtros.filtroEpi = filtro;
    }
    tabelaEpi.carregarDados(1, filtros, false);
}
