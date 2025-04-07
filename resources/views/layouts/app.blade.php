<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- garante que o css funcione no blade-->
    @stack('styles')

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f2f2f2;
            font-family: "Libre Franklin", sans-serif;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Cabeçalho -->
    <div class="container mt-4">
        <h1 class="text-center mt-4">@yield('header')</h1>

        <!-- Conteúdo -->
        @yield('content')
    </div>

    <footer class="mt-auto">
        <div class="container d-flex justify-content-center align-items-center">
            <img src="{{ asset('logo_prodemge.png') }}" alt="Logo Prodemge" width="150" class="me-3">
            <p class="mb-0">© 2025 - Victor Rocha - Prodemge.</p>
        </div>
    </footer>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/formatarCPF.js') }}"></script>
    <script src="{{ asset('js/formatarTelefone.js') }}"></script>
    <script src="{{ asset('js/formatarCEP.js') }}"></script>
    <script src="{{ asset('js/consultarCEP.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/mascaraCPF.js') }}"></script>

</body>

</html>