<?php

require dirname(__DIR__) . '/config/connector.php';

header("Content-Type: application/json");

if (isset($_GET["create"])) {
    $nome  = $_POST["name"];
    $cpf   = $_POST["cpf"];
    $idade = $_POST["age"];

    $stmt = $pdo->prepare("INSERT INTO pessoas (nome, cpf, idade) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $cpf, $idade]);

    echo "OK";
    exit;
}

if (isset($_GET["delete"])) {
    $id = $_GET["id"];

    $stmt = $pdo->prepare("DELETE FROM pessoas WHERE id = ?");
    $stmt->execute([$id]);

    echo "OK";
    exit;
}

if (isset($_GET["list"])) {
    $stmt = $pdo->query("SELECT * FROM pessoas ORDER BY id DESC");
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($dados);
    exit;
}

if (isset($_GET["update"])) {
    $id= $_POST["id"];
    $nome  = $_POST["name"];
    $cpf   = $_POST["cpf"];
    $idade = $_POST["age"];

    $stmt = $pdo->prepare("UPDATE pessoas SET nome = ?, cpf = ?, idade = ? WHERE id = ?");
    $stmt->execute([$nome, $cpf, $idade, $id]);

    echo "OK";
    exit;
}