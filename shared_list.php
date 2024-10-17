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
</head>
<body>
    <header>
        <h1>Welcome, <span id="username"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></span>!</h1>
    </header>
    <div class="container">
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

        <!-- Form to share list -->
        <form id="share-list-form" action="share_list.php" method="POST">
            <input type="text" name="username" placeholder="Enter username to share with" required>
            <input type="hidden" name="list_id" value="1"> <!-- Replace with dynamic list ID -->
            <button type="submit">Share List</button>
        </form>
    </div>
</body>
</html>
