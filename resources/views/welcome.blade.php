<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cadastro</title>

</head>

<body>
    <h1>Filtrar Pessoas Cadastradas</h1>
    <form method="POST" action="index.php">
        <label for="pesquisar">Pesquisar por nome ou CPF:</label><br>
        <input type="text" id="pesquisar" name="pesquisar" placeholder="Digite o nome ou CPF" value="<?= isset($_POST['pesquisar']) ? $_POST['pesquisar'] : '' ?>" required> <br>
        <button type="submit">Pesquisar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pesquisar'])) {
        $pesquisar = $_POST['pesquisar'];
        $pessoas = buscarPessoas($pesquisar); // Chama a função de busca
    }

    if (isset($pessoas) && !empty($pessoas)): ?>
        <div>
            <?php foreach ($pessoas as $pessoa): ?>
                <div class="resultado">
                    <h2><strong></strong> <?= htmlspecialchars($pessoa['nome']) ?></h2>
                    <p><strong>CPF:</strong> <?= htmlspecialchars($pessoa['cpf']) ?></p>
                </div>
                <div class="linha-separadora"></div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($_POST['pesquisar'])): ?>
        <p>Nenhuma pessoa encontrada para: <?= htmlspecialchars($pesquisar) ?></p> 
    <?php endif; ?>

    <a href="{{ route('cadastro') }}">Realizar Novo Cadastro</a>
</body>
</html>