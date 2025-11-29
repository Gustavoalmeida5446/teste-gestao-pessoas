<?php

$envPath = dirname(__DIR__, 2) . '/.env';

if (!file_exists($envPath)) {
    echo json_encode(["error" => "File .env not found at: $envPath"]);
    exit;
}

$env = parse_ini_file($envPath);

$host = $env['DB_HOST'];
$dbname = $env['DB_NAME'];
$user = $env['DB_USER'];
$pass = $env['DB_PASS'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    exit;
}
?>