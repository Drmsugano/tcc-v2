document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (event) {
        event.preventDefault();

        const user = document.querySelector('input[name="login"]').value.trim();
        const password = document
            .querySelector('input[name="password"]')
            .value.trim();

        if (!user || !password) {
            Swal.fire({
                title: "Campos obrigatórios",
                text: "Preencha o login e a senha.",
                icon: "warning",
                confirmButtonText: "OK",
            });
            return;
        }

        const formData = new FormData();
        formData.append("login", user);
        formData.append("senha", password);

        Swal.fire({
            title: "Aguarde...",
            text: "Verificando suas credenciais",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        fetch("/auth/login", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        "Credenciais inválidas ou erro no servidor."
                    );
                }
                return response.json();
            })
            .then((data) => {
                Swal.fire({
                    title: "Login bem-sucedido!",
                    text: "Você será redirecionado para a Homepage.",
                    icon: "success",
                    confirmButtonText: "OK",
                }).then(() => {
                    const token = data.token; // Supondo que o token seja retornado na resposta
                    document.cookie = "jwt_token=" + token + "; path=/; Secure; SameSite=Lax";
                    localStorage.setItem("jwt_token", token);
                    window.location.href = "/Home";
                });
            })
            .catch((error) => {
                Swal.fire({
                    title: "Erro ao fazer login",
                    text: error.message,
                    icon: "error",
                    confirmButtonText: "Tentar novamente",
                });
            })
            .finally(() => {
                Swal.close(); // Garante que o loading desapareça
            });
    });
});
