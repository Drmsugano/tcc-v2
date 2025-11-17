document.addEventListener("DOMContentLoaded", function () {
    window.formulario = new Formulario(
        `/Controle/Funcionario/treinamentos/${window.location.pathname
            .split("/")
            .pop()}`,
        "store",
        "form-cadastro",
        window.tabela
    );
});
function enviarFormulario(event) {
    event.preventDefault();
    window.formulario.enviarFormulario(event);
}
