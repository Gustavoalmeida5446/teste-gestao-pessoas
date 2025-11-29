<?php
$host = 'localhost';
$dbname = 'db_gestao';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
} catch (PDOException $e) {
echo $e->getMessage();
}
?>