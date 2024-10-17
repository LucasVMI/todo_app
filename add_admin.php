<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: idex.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $dsn = 'mysql:host=localhost;dbname=todo_app';
    $db_username = getenv('DB_USERNAME') ?: 'root';
    $db_password = getenv('DB_PASSWORD') ?: '1qaz!QAZ';
    $options = [];

    try {
        $pdo = new PDO($dsn, $db_username, $db_password, $options);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        $role = 'admin';
        $stmt->execute();

        echo "Admin user added successfully!";
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo "Error: " . $e->getMessage;
    }
}
?>