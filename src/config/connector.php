<?php
$envPath = dirname(__DIR__, 2) . '/.env';
$env = parse_ini_file($envPath);

$host = $env['DB_HOST'];
$dbname = $env['DB_NAME'];
$user = $env['DB_USER'];
$pass = $env['DB_PASS'];

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>