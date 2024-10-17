<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $list_id = $_POST['list_id'];
    $username = $_POST['username'];

    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmt = $pdo->prepare('INSERT INTO shared_lists (list_id, user_id, role) VALUES (?, ?, ?)');
        $stmt->execute([$list_id, $user['id'], 'editor']);
        echo "List shared successfully!";
    } else {
        echo "User not found";
    }
}
?>