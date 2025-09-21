document.addEventListener("DOMContentLoaded", () => {
    window.tabelaObras = new TabelaDinamica({
        urlBase: "/Controle/Obras",
        corpoId: "corpoTabelaObras",
        paginacaoId: "paginacaoObras",
        colunas: ["NOME_OBRA", "ENDERECO","STATUS","QTDE_FUNCIONARIO"],
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
    tabelaObras.carregarDados();
});
function selecionar(id) {
    window.location.href = `/Controle/Obras/${id}`;
}
