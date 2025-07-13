<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/sidebar.css">
    <link rel="icon" type="image/x-icon" href="/img/Caixa.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Rosfield</title>
</head>

<body>
    @include('components/sidebar')
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu position-fixed pt-4'></i>
        </div>
        <br>
        <div class="m-4">
            <div class="card border-dark" style="width:95%; height:auto; margin: 0 auto;">
                <div class="card-body">
                    <div class="card-title">
                        <img src="" height="55rem">
                    </div>
                    @yield('conteudo')
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script src="/js/sidebar.js"></script>
</body>

</html>