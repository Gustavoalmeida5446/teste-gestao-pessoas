<?php
require "connector.php";

$stmt = $pdo->query("SELECT * FROM pessoas ORDER BY id DESC");
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($dados);
