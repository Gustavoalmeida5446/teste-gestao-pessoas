<?php

$env = parse_ini_file(__DIR__ . '/../.env');

try {
    $pdo = new PDO("mysql:host={$env['DB_HOST']}", $env['DB_USER'], $env['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS {$env['DB_NAME']}");
    $pdo->exec("USE {$env['DB_NAME']}");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS pessoas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            cpf VARCHAR(20) NOT NULL,
            idade INT NOT NULL,
            data_criacao DATE DEFAULT (CURRENT_DATE)
        )
    ");

    echo "Sucesso! Banco de dados e tabela criados.";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>