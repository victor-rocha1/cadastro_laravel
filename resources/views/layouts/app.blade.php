<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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

    <!-- Scripts -->
    <script>
        function formatarCPF(event) {
            let input = event.target;
            let cpf = input.value.replace(/\D/g, ''); // Remove tudo que não for número

            if (cpf.length > 3 && cpf.length <= 6) {
                cpf = cpf.replace(/(\d{3})(\d{1,3})/, '$1.$2');
            } else if (cpf.length > 6 && cpf.length <= 9) {
                cpf = cpf.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
            } else if (cpf.length > 9) {
                cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
            }

            input.value = cpf;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Formatação telefone
            var inputTelefone = document.getElementById('telefone');
            inputTelefone.addEventListener('input', function(event) {
                var valor = event.target.value.replace(/\D/g, '');
                if (valor.length <= 2) {
                    event.target.value = '(' + valor;
                } else if (valor.length <= 6) {
                    event.target.value = '(' + valor.substring(0, 2) + ') ' + valor.substring(2);
                } else {
                    event.target.value = '(' + valor.substring(0, 2) + ') ' + valor.substring(2, 7) + '-' + valor.substring(7, 11);
                }
            });

            // Formatação CEP
            var inputCep = document.getElementById('cep');
            inputCep.addEventListener('input', function(event) {
                var valorCep = event.target.value.replace(/\D/g, '');
                if (valorCep.length <= 5) {
                    event.target.value = valorCep;
                } else {
                    event.target.value = valorCep.substring(0, 5) + '-' + valorCep.substring(5, 8);
                }
            });
        });

        function consultarCEP() {
            var cep = document.getElementById('cep').value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('logradouro').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                        } else {
                            alert('CEP não encontrado.');
                        }
                    })
                    .catch(error => {
                        alert('Erro ao consultar o CEP.');
                    });
            } else {
                alert('CEP inválido.');
            }
        }
    </script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>