<?php

include 'conexao.php';

try {
    $pdo = conectarBanco();
    echo "Conexão realizada com sucesso!";
} catch (Exception $erro) {
    echo "Erro! Tente novamente: " . $erro->getMessage();
}

?>
