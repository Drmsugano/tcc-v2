document.addEventListener("DOMContentLoaded", function () {
    window.formulario = new Formulario("/Controle/Funcionario", "store", "formNovoFuncionario", window.tabelaFuncionarios);
});
function enviarCadastro(event) {
    event.preventDefault();
    window.formulario.enviarFormulario(event);
}