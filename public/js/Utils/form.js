class Formulario {
    constructor(urlBase, params, formId, tabela) {
        this.urlBase = urlBase;
        this.params = params;
        this.formId = formId;
        this.tabela = tabela;
    }

    resetarFormulario() {
        const form = document.getElementById(this.formId);
        if (form) {
            form.reset();
        } else {
            console.error(`Formulário com ID '${this.formId}' não encontrado.`);
        }
        if (this.tabela) {
            this.tabela.carregarDados(1, {}, false);
        } else {
            window.location.reload();
        }
    }

    enviarFormulario(event) {
        event.preventDefault();
        const form = document.getElementById(this.formId);
        if (!form) {
            console.error(`Formulário com ID '${this.formId}' não encontrado.`);
            return;
        }

        const dados = new FormData(form);

        fetch(`${this.urlBase}/${this.params}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: dados,
        })
            .then((response) => response.json())
            .then((data) => {
                switch (data.success) {
                    case true:
                        swal.fire({
                            title: "Sucesso",
                            text:
                                data.message ||
                                "Formulário enviado com sucesso.",
                            icon: "success",
                        });
                        break;
                    case false:
                        swal.fire({
                            title: "Erro",
                            text:
                                data.message ||
                                "Ocorreu um erro ao enviar o formulário.",
                            icon: "error",
                        });
                        break;
                }
                this.resetarFormulario();
            })
            .catch((error) => {
                console.error("Erro ao enviar o formulário:", error);
                swal.fire({
                    title: "Erro",
                    text: "Ocorreu um erro ao enviar o formulário.",
                    icon: "error",
                });
            });
    }
}
