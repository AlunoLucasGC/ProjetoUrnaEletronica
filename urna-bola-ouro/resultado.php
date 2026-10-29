<?php
require_once __DIR__ . '/conexao.php';

function buscarResultados($pdo)
{
    // TODO 1: fazer uma consulta que agrupe os votos por número de candidato.
    // TODO 2: separar votos REAL e BONUS para conseguir mostrar os dois totais.
    // TODO 3: relacionar o resultado com a tabela `candidatos`.

    return []; // Substitua pelo array retornado da consulta.
}

$resultados = [];
// TODO 4: conectar ao banco e chamar buscarResultados($pdo).
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultado da votação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="container py-5" style="max-width: 900px;">
        <section class="surface-card">
            <p class="eyebrow">APURAÇÃO</p>
            <h1 class="panel-title mb-4">Resultado da votação</h1>
            <?php if (empty($resultados)): ?>
                <div class="alert alert-info">Implemente a função <strong>buscarResultados()</strong> para carregar os dados do MySQL nesta tabela.</div>
            <?php else: ?>
                <!-- TODO: montar as linhas da tabela usando os dados de $resultados. -->
            <?php endif; ?>
            <a href="index.php" class="btn btn-warning mt-3">Voltar para a urna</a>
        </section>
    </main>
</body>
</html>
