<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pessoa</title>
</head>

<body>
    <h1>Cadastro de Pessoa</h1>

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('cadastroPage') }}">
        @csrf

        <label for="nome">Nome:</label><br>
        <input type="text" name="nome" placeholder="Nome" required><br>

        <label for="nome_social">Nome Social (opcional):</label><br>
        <input type="text" name="nome_social" placeholder="Nome Social"><br>

        <label for="cpf">CPF:</label><br>
        <input type="text" name="cpf" placeholder="000.000.000-00" required><br>

        <label for="nome_pai">Nome do Pai:</label><br>
        <input type="text" name="nome_pai" placeholder="Nome do Pai"><br>

        <label for="nome_mae">Nome da Mãe:</label><br>
        <input type="text" name="nome_mae" placeholder="Nome da Mãe"><br>

        <label for="telefone">Telefone:</label><br>
        <input type="tel" name="telefone" placeholder="(31) 99999-9999"><br>

        <label for="email">E-mail:</label><br>
        <input type="email" name="email" placeholder="pessoa@gmail.com"><br>

        <button type="submit">Próximo</button>
    </form>
</body>

</html>