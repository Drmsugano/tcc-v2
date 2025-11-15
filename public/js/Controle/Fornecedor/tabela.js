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
            'STATUS',
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
