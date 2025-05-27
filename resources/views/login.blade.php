<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosfield - Sistema de SST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/terceiros/sweetalert2.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #6610f2;
        }
        .btn-primary {
            background-color: #6610f2;
            border: none;
        }
        .btn-primary:hover {
            background-color: #520dc2;
        }
    </style>
</head>
<body>

<div class="card p-4" style="width: 100%; max-width: 400px;">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Login</h2>
        <p class="text-muted">Rosfield</p>
    </div>
    <form>
        <div class="mb-3">
            <label for="login" class="form-label">Login</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" name="login" placeholder="Digite seu login">
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Digite sua senha">
            </div>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Entrar</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/Auth/login.js"></script>
<script src="/js/terceiros/sweetalert2.min.js"></script>
</body>
</html>