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
    error_log("Database connection error: " . $e->getMessage());
    exit("Database connection error");
 }

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        echo "Password reset successfully";
    } catch (PDOException $e) {
        error_log("Update error: " . $e->getMessage());
        http_response_code(500);
        echo "Error: " . $e->getMessage();
    }
 }
 ?>