class Formulario {
    constructor(urlBase, params, formId, tabela) {
        this.urlBase = urlBase;
        this.params = params;
        this.formId = formId;
        this.tabela = tabela;
    }

    resetarFormulario() {
        const form = document.getElementById(this.formId);
        if (!form) {
            console.error(`Formulário com ID '${this.formId}' não encontrado.`);
            return;
        }

        form.reset();
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
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
            .then(async (response) => {
                // Tenta converter o JSON (pode lançar erro se resposta não for JSON)
                try {
                    return await response.json();
                } catch (e) {
                    throw new Error(`Resposta inesperada do servidor (${response.status})`);
                }
            })
            .then((data) => {
                if (data.success) {
                    swal.fire({
                        title: "Sucesso",
                        text: data.message || "Formulário enviado com sucesso.",
                        icon: "success",
                        showConfirmButton: true,
                    }).then(() => {
                        if (this.tabela) {
                            this.tabela.carregarDados(1, {}, false);
                        } else {
                            window.location.href = this.urlBase;
                        }
                    });

                    this.resetarFormulario();
                    return;
                }

                // Caso contrário, trata erro
                swal.fire({
                    title: "Erro",
                    text: data.message || "Ocorreu um erro ao enviar o formulário.",
                    icon: "error",
                });

                // Validações (422)
                if ((data.status === 422 || data.getStatusCode === 422) && data.errors) {
                    // limpa feedbacks antigos
                    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                    for (const [campo, mensagens] of Object.entries(data.errors)) {
                        const input = form.querySelector(`[name="${campo}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedback = document.createElement('div');
                            feedback.classList.add('invalid-feedback');
                            feedback.innerHTML = mensagens.join('<br>');
                            input.insertAdjacentElement('afterend', feedback);
                        }
                    }
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