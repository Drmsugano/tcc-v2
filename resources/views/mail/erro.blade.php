<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro na Validação</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg p-4 text-center" style="max-width: 450px; border-radius: 12px;">
            <div class="mb-3">
                <div class="rounded-circle bg-danger bg-opacity-25 d-inline-flex justify-content-center align-items-center"
                    style="width: 90px; height: 90px;">
                    <i class="bi bi-x-circle text-danger" style="font-size: 50px;"></i>
                </div>
            </div>
            <h2 class="fw-bold text-danger mb-2">Erro na Validação</h2>
            <p class="text-secondary mb-4">
                O link de confirmação é inválido, expirou ou já foi utilizado.
                Caso o problema persista, solicite um novo envio de confirmação.
            </p>
            <a href="{{ route('login') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold">
                Voltar ao Login
            </a>
        </div>
    </div>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>

</html>