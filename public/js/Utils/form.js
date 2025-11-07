class Formulario {
    constructor(urlBase, params, formId) {
        this.urlBase = urlBase;
        this.params = params;
        this.formId = formId;
    }

    resetarFormulario() {
        const form = document.getElementById(this.formId);
        if (form) {
            form.reset();
        } else {
            console.error(`Formulário com ID '${this.formId}' não encontrado.`);
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
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: dados,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    swal.fire({
                        title: "Sucesso",
                        text: data.message || "Formulário enviado com sucesso.",
                        icon: "success",
                    });
                    this.resetarFormulario();
                } else {
                    swal.fire({
                        title: "Erro",
                        text: data.message || "Ocorreu um erro ao enviar o formulário.",
                        icon: "error",
                    });
                }
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