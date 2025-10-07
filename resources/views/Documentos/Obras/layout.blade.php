<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosfield ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <!-- Container de Toasts -->
    <div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
        <div id="toast-container">
            @if(session('success'))
                <div class="toast align-items-center text-bg-success border-0 mb-2" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Fechar"></button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="toast align-items-center text-bg-danger border-0 mb-2" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Fechar"></button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="toast align-items-center text-bg-danger border-0 mb-2" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $erro)
                                    <li>{{ $erro }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Fechar"></button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('components/navbar')
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'))
            toastElList.forEach(function (toastEl) {
                const toast = new bootstrap.Toast(toastEl, { delay: 5000 }) // 5 segundos
                toast.show()
            })
        })
    </script>
</body>

</html>