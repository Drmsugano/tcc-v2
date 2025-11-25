const obraPublicId = window.location.pathname.split("/").pop();
document.addEventListener("DOMContentLoaded", function () {
    window.tabela = new TabelaDinamica({
        urlBase: `/Controle/Funcionario/epi/${obraPublicId}`,
        corpoId: "corpoTabela",
        paginacaoId: "paginacaoFuncionarios",
        colunas: [
            "NOME_EPI",
            "DATA_ENTREGA",
            "DATA_DEVOLUCAO",
            "QUANTIDADE",
            "RESPONSAVEL_ENTREGA",
            "STATUS_EPI",
            "STATUS_USO",
            "STATUS_MATERIAL",
        ],
        acoes: [
            {
                nome: "Remover",
                texto: "Remover EPI",
                cor: "danger",
                callback: (id) => removerEPI(id),
            },
            {
                nome: "Devolver EPI",
                texto: "Devolver EPI",
                cor: "warning",
                callback: (id) => devolverEPI(id),
            },
            {
                nome: "Protocolo de Entrega",
                texto: "Gerar Protocolo",
                cor: "info",
                callback: (id) => gerarProtocolo(id),
            },
        ],
        itensPorPagina: 10,
    });
    window.tabela.carregarDados(1, {}, false);
});

function removerEPI(id) {
    Swal.fire({
        title: "Confirma a remoção deste EPI?",
        text: "Esta ação não poderá ser desfeita!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, remover!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(
                `/Controle/Funcionario/epi/${obraPublicId}/remover?id=${id}`,
                {
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        "Content-Type": "application/json",
                    },
                }
            )
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        Swal.fire(
                            "Removido!",
                            "O EPI foi removido com sucesso.",
                            "success"
                        );
                        window.tabela.carregarDados(1, {}, false);
                    } else {
                        Swal.fire(
                            "Erro!",
                            data.message ||
                                "Houve um erro ao processar a solicitação.",
                            "error"
                        );
                    }
                })
                .catch((error) => {
                    Swal.fire(
                        "Erro!",
                        "Houve um erro ao processar a solicitação.",
                        "error"
                    );
                });
        }
    });
}
function devolverEPI(id) {
    Swal.fire({
        title: "Confirma a devolução deste EPI?",
        text: "Esta ação não poderá ser desfeita!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, devolver!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(
                `/Controle/Funcionario/epi/${obraPublicId}/devolver?id=${id}`,
                {
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        "Content-Type": "application/json",
                    },
                }
            )
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        Swal.fire(
                            "Devolvido!",
                            "O EPI foi devolvido com sucesso.",
                            "success"
                        );
                        window.tabela.carregarDados(1, {}, false);
                    } else {
                        Swal.fire(
                            "Erro!",
                            data.message ||
                                "Houve um erro ao processar a solicitação.",
                            "error"
                        );
                    }
                });
        }
    });
}
function gerarProtocolo(id) {
    window.open(
        `/Controle/Funcionario/epi/${obraPublicId}/protocolo?id=${id}`,
        "_blank"
    );
}
function aplicarFiltro() {
    const form = document.querySelector("#formFiltro");
    const formData = new FormData(form);
    const filtros = Object.fromEntries(formData.entries());
    window.tabela.carregarDados(1, filtros, false);
}

function limparFiltro() {
    const form = document.querySelector("#formFiltro");
    form.reset();
    window.tabela.carregarDados(1, {}, false);
}
