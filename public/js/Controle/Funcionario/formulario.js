document.addEventListener("DOMContentLoaded", function () {
    window.formulario = new Formulario("/Controle/Funcionario", "store", "formNovoFuncionario", window.tabelaFuncionarios);
});
function enviarCadastro(event) {
    event.preventDefault();
    const cpfInput = document.getElementById("cpfFuncionario");
    if (cpfInput && cpfInput.classList.contains("is-invalid")) {
        return;
    }
    const pisInput = document.getElementById("pis");
    if (pisInput && pisInput.classList.contains("is-invalid")) {
        return;
    }
    window.formulario.enviarFormulario(event);
}