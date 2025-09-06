<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosfield ERP</title>
    {{-- CSS Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Boxicons --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    {{-- Estilo custom --}}
    <link rel="stylesheet" href="/css/terceiros/sweetalert2/sweetalert2.min.css">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .navbar {
            background: linear-gradient(90deg, #212529, #343a40);
        }

        .navbar-brand img {
            border-radius: 6px;
        }

        .card-main {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        .card-body {
            padding: 2rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .nav-link:hover {
            color: #0d6efd !important;
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    @include('components/navbar')
    {{-- Conteúdo principal --}}
    <main class="container my-4">
        <div class="card card-main">
            <div class="card-body">
                @yield('conteudo')
            </div>
        </div>
    </main>
    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/terceiros/sweetalert2/sweetalert2.min.js"></script>
</body>

</html>