document.addEventListener("DOMContentLoaded", function () {
    // Inicializa a tabela dinâmica
    window.tabelaFornecedores = new TabelaDinamica({
        urlBase: "/Controle/Fornecedor",
        corpoId: "corpoTabelaFornecedor",
        paginacaoId: "paginacaoFornecedor",
        colunas: [
            "NOME_FORNECEDOR",
            "CNPJ",
            "TIPO_FORNECEDOR",
            "STATUS",
            "ESTADO",
            "CIDADE",
        ],
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
    tabelaFornecedores.carregarDados(1, {}, false);
});

function selecionar(id) {
    window.location.href = `/Controle/Fornecedor/${id}`;
}

function aplicarFiltros() {
    const form = document.querySelector("#pesquisaFornecedor");
    const formData = new FormData(form);
    const filtros = Object.fromEntries(formData.entries());
    window.tabelaFornecedores.carregarDados(1, filtros, false);
}

function limparFiltros() {
    const form = document.querySelector("#pesquisaFornecedor");
    form.reset();
    window.tabelaFornecedores.carregarDados(1, {}, false);
}
