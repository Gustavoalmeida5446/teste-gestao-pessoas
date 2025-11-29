<?php
require "connector.php";

$id = $_GET["id"];

$stmt = $pdo->prepare("DELETE FROM pessoas WHERE id = ?");
$stmt->execute([$id]);

echo "OK";
