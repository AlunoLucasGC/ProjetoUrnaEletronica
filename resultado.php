<?php
require_once __DIR__ . '/conexao.php';


function buscarResultados($pdo)
{
    $sql = "SELECT
                c.numero,
                c.nome,
                c.time,
                c.foto,

                SUM(CASE
                    WHEN v.tipo = 'REAL' THEN 1
                    ELSE 0
                END) AS votos_reais,

                SUM(CASE
                    WHEN v.tipo = 'BONUS' THEN 1
                    ELSE 0
                END) AS votos_bonus

            FROM candidatos c

            LEFT JOIN votos v
                ON c.numero = v.voto

            GROUP BY
                c.numero,
                c.nome,
                c.time,
                c.foto

            ORDER BY
                (votos_reais + votos_bonus) DESC";

    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

    return $resultados;
}

$resultados =[];

try{
    $pdo = conectarBanco();
    $resultados = buscarResultados($pdo);

}catch(Exception $erro){
    $mensagemErro = '';
}

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
            <?php if (!empty($mensagemErro)): ?>

            <div class="alert alert-danger">
            <?= htmlspecialchars($mensagemErro) ?>
            </div>

            <?php endif; ?>
            <?php if (empty($resultados)): ?>
                <div class="alert alert-info">Implemente a função <strong>buscarResultados()</strong> para carregar os dados do MySQL nesta tabela.</div>
            <?php else: ?>
                <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Número</th>
            <th>Jogador</th>
            <th>Time</th>
            <th>Votos reais</th>
            <th>Votos bônus</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($resultados as $resultado): ?>

            <tr>
                <td><?= htmlspecialchars($resultado['numero']) ?></td>

                <td><?= htmlspecialchars($resultado['nome']) ?></td>

                <td><?= htmlspecialchars($resultado['time']) ?></td>

                <td><?= $resultado['votos_reais'] ?></td>

                <td><?= $resultado['votos_bonus'] ?></td>

                <td>
                    <strong>
                        <?= $resultado['votos_reais'] + $resultado['votos_bonus'] ?>
                    </strong>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
            <?php endif; ?>
            <a href="index.php" class="btn btn-warning mt-3">Voltar para a urna</a>
        </section>
    </main>
</body>
</html>
