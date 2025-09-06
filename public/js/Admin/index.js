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
                cor: "alert",
                callback: (id) => selecionar(id),
            },
        ],
        itensPorPagina: 4,
    });
    tabelaUsuario.carregarDados();
});
function selecionar(id) {
    Swal.fire({
        title: "Carregando...",
        text: "Coletando dados.",
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => Swal.showLoading(),
    });
}
