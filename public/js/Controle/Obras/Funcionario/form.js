document.addEventListener("DOMContentLoaded", function () {
    window.formulario = new Formulario(
        `/Controle/Obras/Funcionarios/${window.location.pathname
            .split("/")
            .pop()}`,
        "store",
        "formFuncionariosObra",
        window.tabela
    );
});
function enviarFormulario(event) {
    event.preventDefault();
    window.formulario.enviarFormulario(event);
}
