document.addEventListener("DOMContentLoaded", () => {
    window.tabelaObras = new TabelaDinamica({
        urlBase: "/Documentos/Obras",
        corpoId: "tabelaBody",
        paginacaoId: "paginacaoObras",
        colunas: ["OBRA", "DESCRICAO", "NOME_ARQUIVO", "CAMINHO"],
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
                    tabelaObras.carregarDados();
                    this.reset();
                    bootstrap.Modal.getInstance(
                        document.getElementById("modalUpload")
                    ).hide();
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

function baixar(id) {
    window.location.href = `/Controle/Obras/${id}`;
}
