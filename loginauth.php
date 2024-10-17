<?php
session_start();

$dsn = 'mysql:host=localhost;dbname=todo_app';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '1qaz!QAZ';
$options = [];
try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    exit(json_encode(["error" => "Database connection error"]));
}

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $response['success'] = true;
        } else {
            $response['error'] = 'Invalid username or password';
        }
    } catch (PDOException $e) {
        error_log("Select error: " . $e->getMessage());
        $response['error'] = "Error: " . $e->getMessage();
    }
}

echo json_encode($response);
?>