document.addEventListener("DOMContentLoaded", function () {
    // Inicializa a tabela dinâmica
    window.tabelaFuncionarios = new TabelaDinamica({
        urlBase: "/Controle/Funcionario",
        corpoId: "corpoTabelaFuncionario",
        paginacaoId: "paginacaoFuncionario",
        colunas: ["NOME_FUNCIONARIO", "FUNCAO", "DATA_ADMISSAO"],
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

function pesquisarFuncionario() {
    const nomeFuncionario = document.getElementById(
        "inputPesquisarFuncionario"
    ).value;
    const filtros = {
        nomeFuncionario: nomeFuncionario,
    };
    window.tabelaFuncionarios.carregarDados(1, filtros, false);
}

function limparFiltroFuncionario() {
    document.getElementById("filtroFuncionario").value = "";
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
