document.addEventListener("DOMContentLoaded", () => {
    window.formularioCadastro = new Formulario(
        "/Admin/Obras",
        "store",
        "form-cadastro",
        window.tabelaObras
    );
    window.formulario = new Formulario(
        "/Admin/Obras",
        "update",
        "form-update",
        null
    );
});
function enviarFormulario(event, id) {
    event.preventDefault();
    switch (id) {
        case "form-cadastro":
            window.formularioCadastro.enviarFormulario(event);
            break;
        case "form-update":
            window.formulario.enviarFormulario(event);
            break;
    }
}
