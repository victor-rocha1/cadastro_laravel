<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Endereço</title>
</head>

<body>
    <h1>Cadastro de Endereço</h1>
    <form method="POST" action="index.php?action=cadastroEndereco">

        <input type="hidden" name="id_pessoa" value="<?php echo isset($_GET['id_pessoa']) ? $_GET['id_pessoa'] : ''; ?>">

        <label for="cep">CEP:</label><br>
        <input type="text" name="cep" id="cep" required><br>

        <label for="logradouro">Logradouro:</label><br>
        <input type="text" name="logradouro" id="logradouro" required><br>

        <label for="numero">Número:</label><br>
        <input type="text" name="numero" id="numero" required><br>

        <label for="complemento">Complemento:</label><br>
        <input type="text" name="complemento" id="complemento"><br>

        <label for="bairro">Bairro:</label><br>
        <input type="text" name="bairro" id="bairro" required><br>

        <label for="estado">Estado:</label><br>
        <input type="text" name="estado" id="estado" required><br>

        <label for="cidade">Cidade:</label><br>
        <input type="text" name="cidade" id="cidade" required><br>

        <button type="submit">Finalizar Cadastro</button>
    </form>

</body>

</html>