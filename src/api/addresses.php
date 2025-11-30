<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once __DIR__ . '/../config/connector.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $person_id = $_GET['person_id'];
    
    $sql = "SELECT * FROM enderecos WHERE pessoa_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$person_id]);
    $address = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode($address);
    exit;
}

if ($method === 'POST') {
    $person_id = $_POST['person_id'];
    $address = $_POST['address'];
    
    $sql = "INSERT INTO enderecos (pessoa_id, endereco) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$person_id, $address]);
    
    echo json_encode(['ok' => true]);
    exit;
}

if ($method === 'PUT') {
    parse_str(file_get_contents('php://input'), $data);
    
    $person_id = $_GET['person_id'];
    $address = $data['address'];
    
    $sql = "SELECT id FROM enderecos WHERE pessoa_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$person_id]);
    $exists = $stmt->fetch();
    
    if ($exists) {
        $sql = "UPDATE enderecos SET endereco = ? WHERE pessoa_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$address, $person_id]);
    } else {
        $sql = "INSERT INTO enderecos (pessoa_id, endereco) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$person_id, $address]);
    }
    
    echo json_encode(['ok' => true]);
    exit;
}
?>