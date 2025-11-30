<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once __DIR__ . '/../config/connector.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $result = $pdo->query("SELECT * FROM pessoas ORDER BY id DESC");
    $people = $result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($people);
    exit;
}

if ($method === 'POST') {
    $name = $_POST['name'];
    $cpf = $_POST['cpf'];
    $age = $_POST['age'];
    
    $pdo->prepare("INSERT INTO pessoas (nome, cpf, idade) VALUES (?, ?, ?)")
        ->execute([$name, $cpf, $age]);
    
    echo json_encode(['ok' => true]);
    exit;
}

if ($method === 'PUT') {
    parse_str(file_get_contents('php://input'), $data);
    
    $id = $_GET['id']; 
    $name = $data['name'];
    $cpf = $data['cpf'];
    $age = $data['age'];
    
    $pdo->prepare("UPDATE pessoas SET nome = ?, cpf = ?, idade = ? WHERE id = ?")
        ->execute([$name, $cpf, $age, $id]);
    
    echo json_encode(['ok' => true]);
    exit;
}

if ($method === 'DELETE') {
    $id = $_GET['id'];
    
    $pdo->prepare("DELETE FROM pessoas WHERE id = ?")
        ->execute([$id]);
    
    echo json_encode(['ok' => true]);
    exit;
}
?>