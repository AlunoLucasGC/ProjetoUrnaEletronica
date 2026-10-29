
<?php
require_once __DIR__ . '/conexao.php';

// Função responsável por excluir todos os votos
function zerarVotacao($pdo)
{
    try {
        // Faz o PDO lançar exceções quando ocorrer um erro SQL
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Inicia a transação
        $pdo->beginTransaction();

        // Exclui votos reais e bônus
        $sql = "DELETE FROM votos";

        $consulta = $pdo->prepare($sql);
        $consulta->execute();

        // Confirma a exclusão
        $pdo->commit();

        return true;

    } catch (Throwable $erro) {

        // Desfaz a operação se houver erro
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        // Registra o erro para podermos identificar o problema
        error_log("Erro ao zerar votação: " . $erro->getMessage());

        return false;
    }
}

// Aceita somente requisições POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

try {
    $pdo = conectarBanco();

    if (zerarVotacao($pdo)) {
        header('Location: index.php?status=sucesso');
    } else {
        header('Location: index.php?status=erro');
    }

    exit;

} catch (Throwable $erro) {

    error_log("Erro na conexão ao zerar votação: " . $erro->getMessage());

    header('Location: index.php?status=erro');
    exit;
}
