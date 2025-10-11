document.addEventListener("DOMContentLoaded", () => {
    window.tabelaObras = new TabelaDinamica({
        urlBase: "/Documentos/Obras",
        corpoId: "tabelaBody",
        paginacaoId: "paginacaoDocObra",
        colunas: ["OBRA", "DESCRICAO", "NOME_ARQUIVO"],
        acoes: [
            {
                nome: "Ver",
                texto: "Baixar",
                cor: "success",
                callback: (id) => baixar(id),
            },
            {
                nome: "Deletar",
                icone: "bx-trash",
                cor: "danger",
                callback: (id) => {
                    Swal.fire({
                        title: "Tem certeza?",
                        text: "Esta ação não pode ser desfeita!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Sim, deletar!",
                        cancelButtonText: "Cancelar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deletar(id);
                        }
                    });
                },
            },
        ],
        itensPorPagina: 10,
    });

    tabelaObras.carregarDados();

    // Upload
    document
        .getElementById("uploadForm")
        .addEventListener("submit", async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            try {
                const res = await fetch("/Documentos/Obras/store", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": token,
                        Accept: "application/json",
                    },
                    body: formData,
                });

                if (!res.ok) {
                    let msg = `Erro ${res.status}: ${res.statusText}`;
                    try {
                        const errorData = await res.json();
                        if (errorData.message) msg = errorData.message;
                    } catch {}
                    throw new Error(msg);
                }

                const data = await res.json();
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Documento enviado com sucesso!",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    this.reset();
                    bootstrap.Modal.getInstance(
                        document.getElementById("modalUpload")
                    ).hide();
                    tabelaObras.carregarDados();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Falha ao enviar documento",
                        text:
                            data.message || "O servidor não retornou sucesso.",
                    });
                }
            } catch (err) {
                console.error("Erro ao enviar documento:", err);
                Swal.fire({
                    icon: "error",
                    title: "Erro ao enviar documento",
                    text: err.message || "Erro inesperado. Veja o console.",
                });
            }
        });
});

async function baixar(id) {
    try {
        const response = await fetch(`/Documentos/Obras/${id}`, {
            method: "GET",
        });
        if (!response.ok) throw new Error("Falha ao baixar o arquivo.");
        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = ""; // O nome vem do header do servidor
        document.body.appendChild(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);
    } catch (erro) {
        Swal.fire("Erro!", erro.message, "error");
    }
}

async function deletar(id) {
    try {
        const token = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const response = await fetch(`/Documentos/Obras/delete/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        const data = await response.json();
        if (!response.ok || data.success === false) {
            throw new Error(data.error || "Falha ao deletar o arquivo.");
        }
        Swal.fire("Sucesso!", "Arquivo deletado com sucesso.", "success");
        tabelaObras.carregarDados();
    } catch (erro) {
        Swal.fire("Erro!", erro.message, "error");
    }
}
