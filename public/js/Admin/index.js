document.addEventListener("DOMContentLoaded", () => {
    // Instancia a tabela
    window.tabelaUsuario = new TabelaDinamica({
        urlBase: "/Admin/Usuario",
        corpoId: "corpoTabelaUsuario",
        paginacaoId: "paginacaoUsuario",
        colunas: ["NOME", "USUARIO", "STATUS"],
        acoes: [
            {
                nome: "Editar",
                texto: "Editar",
                cor: "warning",
                callback: (id,tabela) => selecionar(id,tabela),
            },
        ],
        itensPorPagina: 4,
    });
    window.tabelaObras = new TabelaDinamica({
        urlBase: "/Admin/Obras",
        corpoId: "corpoTabelaObras",
        paginacaoId: "paginacaoObras",
        colunas: ["NOME_OBRAS", "STATUS"],
        acoes: [
            {
                nome: "Editar",
                texto: "Editar",
                cor: "warning",
                callback: (id,tabela) => selecionar(id,tabela),
            },
        ],
        itensPorPagina: 4,
    });
    tabelaUsuario.carregarDados();
    tabelaObras.carregarDados();
});
function selecionar(id, tabela) {
    switch (tabela) {
        case "usuario":
            window.location.href = `/Admin/Usuario/Editar?id=${id}`;
            break;
        case "obras":
            window.location.href = `/Admin/Obra/Editar?id=${id}`;
            break;
    }
}
