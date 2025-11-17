document.addEventListener("DOMContentLoaded", function () {
    // Inicializa a tabela dinâmica
    window.tabelaFuncionarios = new TabelaDinamica({
        urlBase: "/Controle/Funcionario",
        corpoId: "corpoTabelaFuncionario",
        paginacaoId: "paginacaoFuncionario",
        colunas: ["NOME_FUNCIONARIO", "FUNCAO", "DATA_ADMISSAO", "STATUS"],
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
    window.tabelaFuncionarios.carregarDados(1, {}, false);
});

function selecionar(id) {
    window.location.href = `/Controle/Funcionario/${id}`;
}

function aplicarFiltro() {
    const form = document.querySelector("#pesquisaFuncionario");
    const formData = new FormData(form);
    const filtros = Object.fromEntries(formData.entries());
    window.tabelaFuncionarios.carregarDados(1, filtros, false);
}

function limparFiltro() {
    const form = document.querySelector("#pesquisaFuncionario");
    form.reset();
    window.tabelaFuncionarios.carregarDados(1, {}, false);
}
function pesquisarFuncionario(event) {
    event.preventDefault();
    const filtro = document.getElementById("filtroFuncionario").value;
    const filtros = {};
    if (filtro) {
        filtros.filtroFuncionario = filtro;
    }
    window.tabelaFuncionarios.carregarDados(1, filtros, false);
}
