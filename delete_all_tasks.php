<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Database connection
$dsn = 'mysql:host=localhost;dbname=todo_app';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '1qaz!QAZ';
$options = [];
try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    exit("Database connection error");
}

try {
    $stmt = $pdo->prepare('DELETE FROM tasks');
    $stmt->execute();
    echo "All tasks deleted successfully.";
} catch (PDOException $e) {
    error_log("Delete error: " . $e->getMessage());
    echo "Error: " . $e->getMessage();
}
?>