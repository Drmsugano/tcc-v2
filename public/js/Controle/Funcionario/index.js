function formatarCpf(input) {
    let cpf = input.value.replace(/\D/g, ""); // remove tudo que não for número
    if (cpf.length > 3) cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    if (cpf.length > 6) cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    if (cpf.length > 9) cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    input.value = cpf.substring(0, 14);
    validarCpf(cpf) ? input.classList.remove("is-invalid") : input.classList.add("is-invalid");
}

function validarCpf(cpf) {
    cpf = cpf.replace(/\D/g, "");
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
        return false;
    }
    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let resto = 11 - (soma % 11);
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(9))) {
        return false;
    }
    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = 11 - (soma % 11);
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(10))) {
        return false;
    }
    return true;
}

function validarPis(pis) {
    pis = pis.replace(/\D/g, "");
    if (pis.length !== 11) {
        return false;
    }
    const pesos = [3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    let soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(pis.charAt(i)) * pesos[i];
    }
    let resto = soma % 11;
    let digitoVerificador = resto < 2 ? 0 : 11 - resto;
    return digitoVerificador === parseInt(pis.charAt(10));
}

function formatarPis(input) {
    let pis = input.value.replace(/\D/g, ""); // remove tudo que não for número

    if (pis.length > 3) pis = pis.replace(/(\d{3})(\d)/, "$1.$2");
    if (pis.length > 8) pis = pis.replace(/(\d{5})(\d)/, "$1.$2");
    if (pis.length > 11) pis = pis.replace(/(\d{2})(\d)/, "$1-$2");
    input.value = pis.substring(0, 14);
    validarPis(pis) ? input.classList.remove("is-invalid") : input.classList.add("is-invalid");
}
