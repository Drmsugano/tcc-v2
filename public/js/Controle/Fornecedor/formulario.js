document.addEventListener("DOMContentLoaded", function () {
       window.formulario = new Formulario("/Controle/Fornecedor", "store", "formNovoFornecedor", window.tabelaFornecedores);
});
function enviarFormulario(event) {
    event.preventDefault();
    window.formulario.enviarFormulario(event);
    window.tabelaFornecedores.carregarDados(1, {}, false);
}
