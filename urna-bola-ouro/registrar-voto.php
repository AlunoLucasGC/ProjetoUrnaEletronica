<?php
require_once __DIR__ . '/conexao.php';

// ============================================================
// REGISTRO DO VOTO
// Esta função é propositalmente um esqueleto para você completar.
// ============================================================

function registrarVoto($pdo, $numero)
{
    // TODO 1: validar se $numero é um candidato existente, BRANCO ou NULO.

    // TODO 2: iniciar uma transação com $pdo->beginTransaction().

    // TODO 3: inserir o voto da pessoa na tabela `votos` com tipo = 'REAL'.

    // TODO 4: se o voto for de outro candidato (não for o número '09'),
    //         contar quantos votos REAL existem para candidatos diferentes de '09'.

    // TODO 5: descobrir quantos votos BONUS de Harry Kane já foram gravados.
    //         A regra é: para cada 2 votos REAL de outros candidatos,
    //         devem existir 3 votos BONUS para o número '09'.

    // TODO 6: inserir somente os votos BONUS que ainda estiverem faltando.

    // TODO 7: finalizar com commit(); em caso de erro, use rollBack().

    return false; // Troque pelo resultado da gravação após implementar.
}

$mensagem = 'A função de registro ainda precisa ser implementada.';
$tipoMensagem = 'warning';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'] ?? '';

    // TODO 8: chamar conectarBanco() e depois registrarVoto().
    // Exiba uma mensagem de sucesso ou erro conforme o retorno.
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro do voto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="d-flex align-items-center">
    <main class="container py-5" style="max-width: 650px;">
        <div class="surface-card">
            <p class="eyebrow">URNA BOLA DE OURO</p>
            <h1 class="panel-title mb-3">Processamento do voto</h1>
            <div class="alert alert-<?= htmlspecialchars($tipoMensagem) ?>">
                <?= htmlspecialchars($mensagem) ?>
            </div>
            <a href="index.php" class="btn btn-warning">Voltar para a urna</a>
        </div>
    </main>
</body>
</html>
