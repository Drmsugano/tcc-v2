document.addEventListener("DOMContentLoaded", function() {
    // Seleciona todos os elementos com a classe 'arrow' e adiciona o evento de clique
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio do formulário para evitar recarregamento da página
        // Aqui você pode adicionar a lógica de autenticação, como enviar os dados para o servidor
        const user = document.querySelector('input[name="login"]').value;
        const password = document.querySelector('input[name="password"]').value;
        // Simulação de autenticação bem-sucedida
        const formData = new FormData();
        formData.append('login', user);
        formData.append('senha', password);
        fetch('/auth/login', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao realizar login');
            }
            return response.json();
        })
        .then(data => {
            // Aqui você pode lidar com a resposta do servidor, como redirecionar o usuário ou exibir uma mensagem
            Swal.fire({
                title: 'Login bem-sucedido!',
                text: 'Você será redirecionado para a Homepage.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            // Redireciona para a Homepage após o login
            window.location.href = '/home';
        })
        .catch(error => {
            // Exibe um alerta de erro se a autenticação falhar
            Swal.fire({
                title: 'Erro ao fazer login',
                text: error.message,
                icon: 'error',
                confirmButtonText: 'Tentar novamente'
            });
        });
    });
});
