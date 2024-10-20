<?php
session_start();

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
    exit(json_encode(["error" => "Database connection error"]));
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['username'])) {
        // Handle guest task creation
        $task = htmlspecialchars($_POST['task']);
        $due_date = $_POST['due_date'];
        $category = htmlspecialchars($_POST['category']);
        $priority = htmlspecialchars($_POST['priority']);
        // Simulate saving task for guests (e.g., in a session or temporary storage)
        $_SESSION['guest_tasks'][] = [
            'task' => $task,
            'due_date' => $due_date,
            'category' => $category,
            'priority' => $priority
        ];
        $response['message'] = 'Task added for guest';
    } else {
        // Handle authenticated user task creation
        $task = htmlspecialchars($_POST['task']);
        $due_date = $_POST['due_date'];
        $category = htmlspecialchars($_POST['category']);
        $priority = htmlspecialchars($_POST['priority']);
        $user_id = $_SESSION['user_id'];
        $list_id = 1; // Default list ID, replace with dynamic list ID if available
        try {
            $stmt = $pdo->prepare('INSERT INTO tasks (task, due_date, category, priority, user_id, list_id) VALUES (:task, :due_date, :category, :priority, :user_id, :list_id)');
            $stmt->bindParam(':task', $task);
            $stmt->bindParam(':due_date', $due_date);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':priority', $priority);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':list_id', $list_id);
            $stmt->execute();
            $response['message'] = 'Task saved successfully!';
            $response['task_id'] = $pdo->lastInsertId(); // Get the last inserted ID
        } catch (PDOException $e) {
            error_log("Insert error: " . $e->getMessage());
            http_response_code(500);
            $response['error'] = "Error: " . $e->getMessage();
        }
    }
} else {
    if (!isset($_SESSION['username'])) {
        // Return guest tasks
        $response = $_SESSION['guest_tasks'] ?? [];
    } else {
        // Return authenticated user tasks
        $user_id = $_SESSION['user_id'];
        try {
            // Fetch tasks from the user's own lists
            $stmt = $pdo->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch tasks from lists shared with the user
            $stmt = $pdo->prepare('
                SELECT tasks.* FROM tasks
                JOIN shared_lists ON tasks.list_id = shared_lists.list_id
                WHERE shared_lists.user_id = :user_id
            ');
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $shared_tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Merge both arrays
            $response = array_merge($tasks, $shared_tasks);
        } catch (PDOException $e) {
            error_log("Select error: " . $e->getMessage());
            http_response_code(500);
            $response['error'] = "Error: " . $e->getMessage();
        }
    }
}

echo json_encode($response);
?>
