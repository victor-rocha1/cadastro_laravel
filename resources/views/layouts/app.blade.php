<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos adicionais -->
    @stack('styles')

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Cabeçalho -->
    <div class="container mt-4">
        <h1 class="text-center mt-4">@yield('header')</h1>

        <!-- Conteúdo -->
        @yield('content')

        <!-- Exibição de erros -->
        @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <!-- Footer -->
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