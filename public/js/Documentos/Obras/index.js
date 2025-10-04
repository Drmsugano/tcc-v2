document.addEventListener("DOMContentLoaded", () => {
    window.tabelaObras = new TabelaDinamica({
        urlBase: "/Documento/Obras",
        corpoId: "tabelaBody",
        paginacaoId: "paginacaoObras",
        colunas: ["NOME_OBRA", "DESCRICAO", "ARQUIVO"],
        acoes: [
            {
                nome: "Ver",
                texto: "Baixar",
                cor: "success",
                callback: (id) => baixar(id),
            },
        ],
        itensPorPagina: 10,
    });
    tabelaObras.carregarDados();
});
function baixar(id) {
    window.location.href = `/Controle/Obras/${id}`;
}
