const funcionarioPublicId = window.location.pathname.split("/").pop();
document.addEventListener("DOMContentLoaded", function () {
    window.tabela = new TabelaDinamica({
        urlBase: `/Controle/Funcionario/treinamentos/${funcionarioPublicId}`,
        corpoId: "corpoTabelaTreinamento",
        paginacaoId: "paginacaoTabela",
        colunas: [
            "NOME_TREINAMENTO",
            "DATA_TREINAMENTO",
            "DATA_VALIDADE",
            "STATUS",
            "USUARIO_CADASTRO",
        ],
        acoes: [
            {
                nome: "Protocolo de Entrega",
                texto: "Gerar Certificado",
                cor: "info",
                callback: (id) => gerarProtocolo(id),
            },
        ],
        itensPorPagina: 10,
    });
    window.tabela.carregarDados(1, {}, false);
});
function aplicarFiltro() {
    const form = document.querySelector("#formFiltro");
    const formData = new FormData(form);
    const filtros = Object.fromEntries(formData.entries());
    window.tabela.carregarDados(1, filtros, false);
}

function gerarProtocolo(id) {
    window.open(
        `/Controle/Funcionario/treinamentos/${funcionarioPublicId}/protocolo?id=${id}`,
        "_blank"
    );
}

function limparFiltro() {
    const form = document.querySelector("#formFiltro");
    form.reset();
    window.tabela.carregarDados(1, {}, false);
}
