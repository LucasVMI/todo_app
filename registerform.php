<?php
session_start();
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;
        
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        error_log("Insert error: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    }
}
?>
