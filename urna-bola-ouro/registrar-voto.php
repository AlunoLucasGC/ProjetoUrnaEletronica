<?php
require './urna-bola-ouro/conexao.php';

// ============================================================
// REGISTRO DO VOTO
// Esta função é propositalmente um esqueleto para você completar.
// ============================================================
$numero = $_POST['numero'] ?? '';

function registrarVoto($pdo, $numero)
{
    try {

        // Inicia a transação
        $pdo->beginTransaction();

        // 1. Identifica o tipo de voto
        if ($numero === 'BRANCO') {

            $votoRegistrado = 'BRANCO';

        } else {

            // Verifica se o candidato existe
            $sql = "SELECT numero FROM candidatos WHERE numero = ?";
            $consulta = $pdo->prepare($sql);
            $consulta->execute([$numero]);

            $candidato = $consulta->fetch();

            if ($candidato === false) {
                $votoRegistrado = 'NULO';
            } else {
                $votoRegistrado = $candidato['numero'];
            }
        }

        // 2. Registra o voto REAL
        $sql = "INSERT INTO votos (voto, tipo, data_hora)
                VALUES (?, 'REAL', NOW())";

        $consulta = $pdo->prepare($sql);
        $consulta->execute([$votoRegistrado]);

        // 3. Conta votos REAL de outros candidatos
        $sql = "SELECT COUNT(*) AS total
                FROM votos v
                INNER JOIN candidatos c ON c.numero = v.voto
                WHERE v.tipo = 'REAL'
                AND c.numero <> '09'";

        $consulta = $pdo->query($sql);
        $resultado = $consulta->fetch();

        $totalReal = (int) $resultado['total'];

        // 4. Calcula quantos votos BONUS devem existir
        $bonusNecessarios = intdiv($totalReal, 2) * 3;

        // 5. Descobre quantos BONUS já existem para Harry Kane
        $sql = "SELECT COUNT(*) AS total
                FROM votos
                WHERE voto = '09'
                AND tipo = 'BONUS'";

        $consulta = $pdo->query($sql);
        $resultado = $consulta->fetch();

        $bonusExistentes = (int) $resultado['total'];

        // 6. Calcula quantos votos BONUS ainda faltam
        $bonusFaltantes = $bonusNecessarios - $bonusExistentes;

        // Insere somente os votos BONUS que faltam
        if ($bonusFaltantes > 0) {

            $sql = "INSERT INTO votos (voto, tipo, data_hora)
                    VALUES ('09', 'BONUS', NOW())";

            $consulta = $pdo->prepare($sql);

            for ($i = 0; $i < $bonusFaltantes; $i++) {
                $consulta->execute();
            }
        }

        // 7. Confirma todas as operações
        $pdo->commit();

        return true;

    } catch (Exception $erro) {

        // Desfaz as operações caso aconteça algum erro
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        return false;
    }
}

$mensagem = 'Aguardando registro do voto.';
$tipoMensagem = 'warning';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $numero = $_POST['numero'] ?? '';

    $pdo = conectarBanco();

    if (registrarVoto($pdo, $numero)) {

        $mensagem = 'Voto registrado com sucesso!';
        $tipoMensagem = 'success';

    } else {

        $mensagem = 'Não foi possível registrar o voto.';
        $tipoMensagem = 'danger';

    }
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
