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
            {
                nome: "Editar",
                icone: "bx-edit",
                cor: "warning",
                callback: (id) => {
                    (async (id) => {
                        try {
                            const token = document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content");
                            let res = await fetch(
                                `/Documentos/Obras/${id}/edit`,
                                {
                                    headers: { Accept: "application/json" },
                                }
                            );
                            if (!res.ok)
                                throw new Error(
                                    `Falha ao obter dados (status ${res.status})`
                                );
                            const data = await res.json();
                            if (!document.getElementById("modalEditObra")) {
                                const modalHtml = `
                                        <div class="modal fade" id="modalEditObra" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title">Editar Documento</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                              </div>
                                              <form id="editForm" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                  <input type="hidden" name="id" />
                                                  <div class="mb-3">
                                                    <label class="form-label">Tipo de Documento</label>
                                                    <select class="form-select" name="TIPO_DOCUMENTO_ID">
                                                      <option value="">Selecione um tipo</option>
                                                      ${data.TIPO_DOCUMENTO.map(
                                                          (tipo) => `
                                                        <option value="${tipo.ID}">${tipo.NOME}</option>
                                                      `
                                                      ).join("")}
                                                    </select>
                                                  </div>
                                                  <div class="mb-3">
                                                    <label class="form-label">Descrição</label>
                                                    <textarea class="form-control" name="descricao" rows="3"></textarea>
                                                  </div>
                                                  <div class="mb-3">
                                                    <label class="form-label">Substituir arquivo (opcional)</label>
                                                    <input type="file" class="form-control" name="arquivo" />
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                  <button type="submit" class="btn btn-primary">Salvar alterações</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>`;
                                document.body.insertAdjacentHTML(
                                    "beforeend",
                                    modalHtml
                                );
                            }
                            const modalEl =
                                document.getElementById("modalEditObra");
                            const editForm =
                                document.getElementById("editForm");
                            editForm.querySelector('[name="id"]').value = id;
                            if (
                                (data.TIPO_DOCUMENTO_ID !== undefined ||
                                    data.TIPO_DOCUMENTO_ID !== undefined) &&
                                editForm.querySelector('[name="TIPO_DOCUMENTO_ID"]')
                            )
                                editForm.querySelector(
                                    '[name="TIPO_DOCUMENTO_ID"]'
                                ).value =
                                    data.TIPO_DOCUMENTO_ID ||
                                    data.TIPO_DOCUMENTO_ID ||
                                    "";
                            if (
                                (data.DESCRICAO !== undefined ||
                                    data.descricao !== undefined) &&
                                editForm.querySelector('[name="DESCRICAO"]')
                            )
                                editForm.querySelector(
                                    '[name="DESCRICAO"]'
                                ).value =
                                    data.DESCRICAO || data.descricao || "";
                            editForm.onsubmit = async function (e) {
                                e.preventDefault();
                                const formData = new FormData(this);
                                try {
                                    const resp = await fetch(
                                        `/Documentos/Obras/update/${id}`,
                                        {
                                            method: "POST",
                                            headers: {
                                                "X-CSRF-TOKEN": token,
                                                Accept: "application/json",
                                            },
                                            body: formData,
                                        }
                                    );
                                    if (!resp.ok) {
                                        let msg = `Erro ${resp.status}: ${resp.statusText}`;
                                        try {
                                            const errJson = await resp.json();
                                            if (errJson.message)
                                                msg = errJson.message;
                                        } catch {}
                                        throw new Error(msg);
                                    }
                                    const respJson = await resp.json();
                                    if (respJson.success) {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Documento atualizado!",
                                            showConfirmButton: false,
                                            timer: 1500,
                                        });
                                        bootstrap.Modal.getInstance(
                                            modalEl
                                        ).hide();
                                        tabelaObras.carregarDados(1, {}, false);
                                    } else {
                                        throw new Error(
                                            respJson.message ||
                                                "Falha ao atualizar documento."
                                        );
                                    }
                                } catch (err) {
                                    console.error("Erro ao atualizar:", err);
                                    Swal.fire(
                                        "Erro",
                                        err.message || "Erro inesperado.",
                                        "error"
                                    );
                                }
                            };
                            const bsModal = new bootstrap.Modal(modalEl);
                            bsModal.show();
                        } catch (err) {
                            console.error(err);
                            Swal.fire(
                                "Erro",
                                err.message ||
                                    "Não foi possível carregar dados do documento.",
                                "error"
                            );
                        }
                    })(id);
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
                    tabelaObras.carregarDados(1, {}, false);
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
        Swal.fire("Sucesso!", "Arquivo deletado com sucesso.", "success").then(
            () => {
                tabelaObras.carregarDados(1, {}, false);
            }
        );
    } catch (erro) {
        Swal.fire("Erro!", erro.message, "error");
    }
}

function searchDocumentos() {
    const filtroForm = document.getElementById("filtroForm");
    const filtros = {};
    Array.from(filtroForm.elements).forEach((el) => {
        if (el.name && el.value) {
            filtros[el.name] = el.value;
        }
    });
    tabelaObras.carregarDados(1, filtros, false);
}
