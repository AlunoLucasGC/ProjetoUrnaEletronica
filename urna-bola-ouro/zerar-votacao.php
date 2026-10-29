<?php
require_once __DIR__ . '/conexao.php';

function zerarVotacao($pdo)
{
    // TODO: executar DELETE FROM votos.
    // Dica: use uma instrução preparada com $pdo->prepare(...).

    return false; // Troque pelo retorno da operação.
}

$mensagem = 'A função para zerar a votação ainda precisa ser implementada.';
// TODO: aceitar somente requisições POST, conectar ao banco e chamar zerarVotacao().
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zerar votação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="d-flex align-items-center">
    <main class="container py-5" style="max-width: 650px;">
        <div class="surface-card">
            <p class="eyebrow">PAINEL ADMINISTRATIVO</p>
            <h1 class="panel-title mb-3">Zerar votação</h1>
            <div class="alert alert-warning"><?= htmlspecialchars($mensagem) ?></div>
            <a href="index.php" class="btn btn-warning">Voltar para a urna</a>
        </div>
    </main>
</body>
</html>
