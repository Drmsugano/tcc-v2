document.addEventListener("DOMContentLoaded", function () {
    window.formulario = new Formulario(
        "/Controle/Funcionario",
        "update",
        "form-update"
    );
});

function enviarFormulario(event) {
    event.preventDefault();
    window.formulario.enviarFormulario(event);
    window.tabelaFornecedores.carregarDados(1, {}, false);
}

function habilitarEdicao() {
    const campos = document.querySelectorAll(
        '#form-update [data-editavel="true"]'
    );
    campos.forEach((campo) => {
        campo.removeAttribute("readonly");
        campo.setAttribute("required", "true");
    });
    document.getElementById("btnSalvarAlteracoes").style.display =
        "inline-block";
    document.getElementById("btnHabilitarEdicao").disabled = true;
    document.getElementById("btnCancelarEdicao").disabled = false;
    document.getElementById("btnSalvarAlteracoes").disabled = false;
    Swal.fire({
        title: "Edição Habilitada",
        text: "Você pode editar os campos agora.",
        icon: "info",
        timer: 2000,
        showConfirmButton: false,
    });
}
