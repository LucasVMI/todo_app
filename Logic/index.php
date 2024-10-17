<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>
<body>
    <div id="particles-js"></div>
    <header>
        <h1>Welcome, <span id="username"></span>!</h1>
    </header>
    <div class="container">
    <?php
    if ($_SESSION['role'] === 'admin') {
        echo '<a href="admin.php">Admin Page</a>';
    }
    ?>
        <h1>To-Do List</h1>
        <form id="todo-form">
            <input type="text" name="task" placeholder="Add a new task" required>
            <input type="date" name="due_date" placeholder="Due date">
            <input type="text" name="category" placeholder="Category">
            <select name="priority">
                <option value="low">Low Priority</option>
                <option value="medium">Medium Priority</option>
                <option value="high">High Priority</option>
            </select>
            <button type="submit">Add Task</button>
        </form>
        <ul id="task-list"></ul>
        <button id="delete-all-tasks" type="button">Delete All Tasks</button>
        <button id="delete-account" type="button">Delete Account</button>
        <button id="logout" class="logout-btn" type="button">Log Out</button>
    </div>
    <script src="scripts.js"></script>
    <script src="particles-config.js"></script>
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <p>Please log in to save your tasks.</p>
        </div>
    </div>
</body>
</html>