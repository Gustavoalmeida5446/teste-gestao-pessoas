<?php
require "connector.php";

$id    = $_POST["id"];
$nome  = $_POST["name"];
$cpf   = $_POST["cpf"];
$idade = $_POST["age"];

$stmt = $pdo->prepare("UPDATE pessoas SET nome = ?, cpf = ?, idade = ? WHERE id = ?");
$stmt->execute([$nome, $cpf, $idade, $id]);

echo "OK";
