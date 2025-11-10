function formatarCNPJ(input) {
    let valor = input.value.replace(/\D/g, "");
    if (valor.length > 2) {
        valor = valor.replace(/^(\d{2})(\d)/, "$1.$2");
    }
    if (valor.length > 5) {
        valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
    }
    if (valor.length > 8) {
        valor = valor.replace(/\.(\d{3})(\d)/, ".$1/$2");
    }
    if (valor.length > 12) {
        valor = valor.replace(/(\d{4})(\d)/, "$1-$2");
    }
    input.value = valor.substring(0, 18);
}
function formatarCEP(cep) {
    cep = cep.replace(/\D/g, "");
    if (cep.length !== 8) {
        return "";
    }
    return cep.replace(/^(\d{5})(\d{3})$/, "$1-$2");
}
function procurarCNPJ(cnpj) {
    Swal.fire({
        title: "Buscando CNPJ...",
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: false,
        timer: 1200,
    });
    buscarCNPJ(cnpj);
}
function buscarCNPJ(cnpj) {
    cnpj = cnpj.replace(/\D/g, "");
    if (cnpj.length !== 14) {
        alert("CNPJ inválido. Por favor, verifique o número informado.");
        return;
    }
    fetch(`https://brasilapi.com.br/api/cnpj/v1/${cnpj}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "ERROR") {
                Swal.fire({
                    icon: "error",
                    title: "CNPJ não encontrado",
                    position: "top-end",
                    timer: 3000,
                    showConfirmButton: false,
                    text: "O CNPJ informado não foi encontrado. Verifique o número e tente novamente.",
                });
                return;
            }
            document.getElementById("nomeFornecedor").value =
                data.razao_social || "";
            document.getElementById("estadoFornecedor").value = data.uf || "";
            document.getElementById("CEP").value = formatarCEP(data.cep) || "";
            document.getElementById("cidadeFornecedor").value =
                data.municipio || "";
            document.getElementById("enderecoFornecedor").value = `${
                data.logradouro || ""
            }, ${data.numero || ""} - ${data.bairro || ""}, ${
                data.municipio || ""
            } - ${data.uf || ""}, ${data.cep || ""}`;
        })
        .catch((error) => {
            Swal.fire({
                icon: "error",
                title: "Erro ao buscar CNPJ. Tente novamente mais tarde.",
                timer: 3000,
                showConfirmButton: false,
            });
        });
}
function formatarTelefone(input) {
    let valor = input.value.replace(/\D/g, "");
    if (valor.length === 10 && valor[2] !== "9") {
        valor = valor.slice(0, 2) + "9" + valor.slice(2);
    }
    if (valor.length > 11) valor = valor.substring(0, 11);
    if (valor.length > 10) {
        valor = valor.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
    } else if (valor.length > 6) {
        valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4})$/, "($1) $2-$3");
    } else if (valor.length > 2) {
        valor = valor.replace(/^(\d{2})(\d{0,5})$/, "($1) $2");
    } else if (valor.length > 0) {
        valor = valor.replace(/^(\d{0,2})$/, "($1");
    }
    input.value = valor;
}
