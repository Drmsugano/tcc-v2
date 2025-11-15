document.addEventListener("DOMContentLoaded", () => {
    // Instancia a tabela
    window.tabelaObras = new TabelaDinamica({
        urlBase: "/Admin/Obras",
        corpoId: "corpoTabelaObras",
        paginacaoId: "paginacaoObras",
        colunas: ["NOME_OBRA", "ENDERECO", "STATUS", "DATA_INICIO", "DATA_FIM"],
        acoes: [
            {
                nome: "Editar",
                texto: "Editar",
                cor: "warning",
                callback: (id) => selecionar(id),
            },
            {
                nome: "Deletar",
                texto: "Deletar",
                cor: "danger",
                callback: (id) => deletar(id),
            }
        ],
        itensPorPagina: 20,
    });
    tabelaObras.carregarDados();
});

function selecionar(id) {
    window.location.href = `/Admin/Obras/${id}`;
}
function deletar(id) {
    Swal.fire({
        title: "Confirma a exclusão desta obra?",
        text: "Esta ação não poderá ser desfeita!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/Admin/Obras/deletar/${id}`, {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        Swal.fire(
                            "Excluído!",
                            "A obra foi excluída com sucesso.",
                            "success"
                        ).then(() => {
                            tabelaObras.carregarDados();
                        });
                    }
                    else {
                        Swal.fire(
                            "Erro!",
                            data.message || "Houve um erro ao excluir a obra.",
                            "error"
                        );
                    }
                });
        }
    });
}
