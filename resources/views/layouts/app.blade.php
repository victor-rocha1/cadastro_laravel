<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <h1>@yield('header')</h1>


    @yield('content')

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <script>
        // Função para formatar CPF no campo de pesquisa
        function formatarCPF(event) {
            var cpf = event.target.value;

            // Remove todos os caracteres não numéricos
            cpf = cpf.replace(/\D/g, '');

            // Formata CPF com pontos e traço
            if (cpf.length <= 11) {
                cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
            }

            event.target.value = cpf;
        }
    </script>


    <script>
        // Script para formatar o número no formato (00) 00000-0000
        document.addEventListener('DOMContentLoaded', function() {
            var inputNumero = document.getElementById('numero');

            inputNumero.addEventListener('input', function(event) {
                var valor = event.target.value;

                // Remove todos os caracteres não numéricos
                valor = valor.replace(/\D/g, '');

                // Formata o número no padrão (00) 00000-0000
                if (valor.length <= 2) {
                    event.target.value = '(' + valor;
                } else if (valor.length <= 6) {
                    event.target.value = '(' + valor.substring(0, 2) + ') ' + valor.substring(2);
                } else {
                    event.target.value = '(' + valor.substring(0, 2) + ') ' + valor.substring(2, 7) + '-' + valor.substring(7, 11);
                }
            });

            // Script para formatar o CEP no formato 00000-000
            var inputCep = document.getElementById('cep');

            inputCep.addEventListener('input', function(event) {
                var valorCep = event.target.value;

                // Remove todos os caracteres não numéricos
                valorCep = valorCep.replace(/\D/g, '');

                // Formata o CEP no padrão 00000-000
                if (valorCep.length <= 5) {
                    event.target.value = valorCep;
                } else {
                    event.target.value = valorCep.substring(0, 5) + '-' + valorCep.substring(5, 8);
                }
            });
        });
    </script>
</body>

</html>