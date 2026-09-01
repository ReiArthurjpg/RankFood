<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$host = 'db'; // Nome do serviço no docker-compose
$db = 'ranking_db';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $stmt = $pdo->query('SELECT * FROM companies ORDER BY stars DESC, name ASC');
        $companies = $stmt->fetchAll();
        echo json_encode($companies);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['name'])) {
            $stmt = $pdo->prepare('INSERT INTO companies (name, stars) VALUES (?, ?)');
            $stars = isset($data['stars']) ? $data['stars'] : 0;
            $stmt->execute([$data['name'], $stars]);
            $id = $pdo->lastInsertId();
            
            // Retorna a empresa recém-criada
            $stmt = $pdo->prepare('SELECT * FROM companies WHERE id = ?');
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch());
        } else {
            echo json_encode(['error' => 'Name is required']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id'])) {
            if (isset($data['name'])) {
                $stmt = $pdo->prepare('UPDATE companies SET name = ? WHERE id = ?');
                $stmt->execute([$data['name'], $data['id']]);
            }
            if (isset($data['stars'])) {
                $stmt = $pdo->prepare('UPDATE companies SET stars = ? WHERE id = ?');
                $stmt->execute([$data['stars'], $data['id']]);
            }
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'ID is required']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        // Para requisições DELETE, os dados também podem vir na URL ou corpo
        // Neste caso, o frontend vai enviar no corpo como JSON
        if (isset($data['id'])) {
            $stmt = $pdo->prepare('DELETE FROM companies WHERE id = ?');
            $stmt->execute([$data['id']]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'ID is required']);
        }
        break;
        
    default:
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
