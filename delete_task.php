<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

header('Content-Type: application/json');

$dsn = 'mysql:host=localhost;dbname=todo_app';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '1qaz!QAZ';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database connection error"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskId = $_POST['id'];

    try {
        $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
        $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Task not found"]);
        }
    } catch (PDOException $e) {
        error_log("Delete error: " . $e->getMessage());
        echo json_encode(["success" => false, "error" => "Error deleting task"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Method not allowed"]);
}
?>
