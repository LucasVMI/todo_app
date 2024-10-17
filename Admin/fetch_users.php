<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit('Access denied');
}

$dsn = 'mysql:host=localhost;dbname=todo_app';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '1qaz!QAZ';
$options = [];
try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection error:" . $e->getMessage());
    exit("Database connection error");
}

try {
    $stmt = $pdo->query('SELECT id, username FROM users');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (PDOException $e) {
    error_log("Fetch error: " . $e->getMessage());
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>