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
            {
                nome: "Deletar",
                texto: "Deletar Fornecedor",
                cor: "danger",
                callback: (id) => deletar(id),
            },
        ],
        itensPorPagina: 10,
    });
    tabelaFornecedores.carregarDados(1, {}, false);
});

function selecionar(id) {
    window.location.href = `/Controle/Fornecedor/${id}`;
}

function deletar(id) {
    Swal.fire({
        title: "Confirmação de Exclusão",
        text: "Tem certeza que deseja deletar este fornecedor? Esta ação não pode ser desfeita.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, deletar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/Controle/Fornecedor/delete/${id}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        Swal.fire({
                            title: "Deletado!",
                            text: "O fornecedor foi deletado com sucesso.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        tabelaFornecedores.carregarDados(1, {}, false);
                    } else {
                        Swal.fire({
                            title: "Erro!",
                            text:
                                data.message ||
                                "Ocorreu um erro ao deletar o fornecedor.",
                            icon: "error",
                        });
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        title: "Erro!",
                        text: "Ocorreu um erro ao processar a requisição.",
                        icon: "error",
                    });
                });
        }
    });
}
