<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Validado</title>
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
                <div class="rounded-circle bg-success bg-opacity-25 d-inline-flex justify-content-center align-items-center"
                    style="width: 90px; height: 90px;">
                    <i class="bi bi-check2-circle text-success" style="font-size: 50px;"></i>
                </div>
            </div>
            <h2 class="fw-bold text-success mb-2">Conta Verificada!</h2>
            <p class="text-secondary mb-4">
                Seu email foi confirmado com sucesso. Agora você já pode acessar todos os recursos da plataforma.
            </p>
            <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 fw-semibold">
                Ir para o Login
            </a>
        </div>
    </div>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>

</html>