<?php
require "connector.php";

$nome  = $_POST["name"];
$cpf   = $_POST["cpf"];
$idade = $_POST["age"];

$stmt = $pdo->prepare("INSERT INTO pessoas (nome, cpf, idade) VALUES (?, ?, ?)");
$stmt->execute([$nome, $cpf, $idade]);

echo "OK";
