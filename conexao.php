<?php
// ============================================================
// CONEXÃO COM O BANCO DE DADOS
// Complete esta função usando PDO.
// ============================================================

function conectarBanco()
{
    $host = 'localhost';
    $usuario = 'root';
    $senha = '123456';
    $banco = 'urna_eletronica';

    // 2. Montagem da string de conexão
    $dsn = "mysql:host=$host;dbname=$banco;charset=utf8mb4";

    // 3. Configurações do PDO
    $opcoes = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    $pdo = new PDO($dsn, $usuario, $senha, $opcoes);

    return $pdo;
}
