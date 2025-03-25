<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Link para o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="container mt-4 center">
    <!-- Cabeçalho -->
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

    <!-- Scripts -->
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
        // Formatação para número de telefone
        document.addEventListener('DOMContentLoaded', function() {
            var inputTelefone = document.getElementById('telefone'); // Corrigir para telefone

            inputTelefone.addEventListener('input', function(event) {
                var valor = event.target.value;

                valor = valor.replace(/\D/g, ''); // Remove tudo que não for número

                if (valor.length <= 2) {
                    event.target.value = '(' + valor;
                } else if (valor.length <= 6) {
                    event.target.value = '(' + valor.substring(0, 2) + ') ' + valor.substring(2);
                } else {
                    event.target.value = '(' + valor.substring(0, 2) + ') ' + valor.substring(2, 7) + '-' + valor.substring(7, 11);
                }
            });

            // Formatação para o CEP
            var inputCep = document.getElementById('cep');
            inputCep.addEventListener('input', function(event) {
                var valorCep = event.target.value;

                valorCep = valorCep.replace(/\D/g, ''); // Remove tudo que não for número

                if (valorCep.length <= 5) {
                    event.target.value = valorCep;
                } else {
                    event.target.value = valorCep.substring(0, 5) + '-' + valorCep.substring(5, 8);
                }
            });
        });
    </script>

    <script>
        // Função para garantir que apenas números sejam inseridos no campo 'numero'
        function somenteNumeros(event) {
            let input = event.target;
            input.value = input.value.replace(/\D/g, ''); // Remove tudo que não for número
        }
    </script>


    <script>
        function consultarCEP() {
            var cep = document.getElementById('cep').value.replace(/\D/g, '');

            if (cep.length === 8) {
                var url = `https://viacep.com.br/ws/${cep}/json/`; // URL da API viaCEP

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            // preenche os campos do formulário com os dados retornados
                            document.getElementById('logradouro').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                        } else {
                            alert('CEP não encontrado.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao consultar o CEP:', error);
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