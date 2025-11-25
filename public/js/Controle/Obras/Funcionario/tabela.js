const obraPublicId = window.location.pathname.split("/").pop();
document.addEventListener("DOMContentLoaded", function () {
    window.tabela = new TabelaDinamica({
        urlBase: `/Controle/Obras/Funcionarios/${obraPublicId}`,
        corpoId: "corpoTabelaFuncionariosObra",
        paginacaoId: "paginacaoFuncionarios",
        colunas: [
            "NOME_FUNCIONARIO",
            "FUNCAO",
            "STATUS",
            "DATA_INICIO",
        ],
        acoes: [
            {
                nome: "Remover",
                texto: "Remover da Obra",
                cor: "danger",
                callback: (id) => removerFuncionario(id),
            },
        ],
        itensPorPagina: 10,
    });
    window.tabela.carregarDados(1, {}, false);
});

function removerFuncionario(id) {
    swal.fire({
        title: "Confirmação",
        text: "Tem certeza que deseja remover este funcionário da obra?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, remover",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(
                `/Controle/Obras/Funcionarios/${obraPublicId}/delete?funcionarioId=${id}`,
                {
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                }
            )
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        swal.fire("Removido!", data.message, "success");
                        window.tabela.carregarDados(1, {}, false);
                    } else {
                        swal.fire("Erro", data.message, "error");
                    }
                })
                .catch((error) => {
                    console.error("Erro ao remover funcionário:", error);
                    swal.fire(
                        "Erro",
                        "Ocorreu um erro ao tentar remover o funcionário.",
                        "error"
                    );
                });
        }
    });
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
