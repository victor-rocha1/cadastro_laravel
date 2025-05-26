<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        crossorigin="anonymous" />

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <title>Sistema de Cadastro</title>
</head>

<body>
    @yield('content')

    <footer class="mt-auto">
        <div class="container d-flex justify-content-center align-items-center">
            <img src="{{ asset('/images/logo_prodemge.png') }}" alt="Logo Prodemge" width="150" class="me-3">
            <p class="mb-0">© 2025 - Victor Rocha - Prodemge.</p>
        </div>
    </footer>

    <script src="{{ mix('js/app.js') }}"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoFQO7FQp9nUUN1c5kN91mN+Nc1p+I92cHfXehG5DkLl2o6"
        crossorigin="anonymous"></script>
</body>

</html>