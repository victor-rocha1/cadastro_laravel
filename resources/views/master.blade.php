<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pVnFd0wWrcYTqQlKq7iVZtPdwkFqPrvqZTr+HkCg7ff+KLGTHbGq5vA2TVoHtID/vP2gXqZOmvCJUi4hj+0mDQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
</body>

</html>