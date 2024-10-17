<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <title>Admin Page</title>
</head>
<body>
<div id="particles-js"></div>
    <h1>Admin Page</h1>

    <form id="add-admin-form" action="add_admin.php" method="POST">
        <label for="new-username">New Admin Username:</label>
        <input type="text" id="new-username" name="username" required>
        <label for="new-password">New Admin Password:</label>
        <input type="password" id="new-password" name="password" required>
        <button type="submit">Add Admin</button>
</form>

    <ul id="user-list">
    </ul>
    <form id="reset-password-form">
        <input type="hidden" id="user-id" name="userId">
        <input type="password" id="new-password" name="newPassword" placeholder="New Password">
        <button type="submit">Reset Password</button>
    </form>
    <script src="admin.js"></script>
    <script src="particles-config.js"></script>
</body>
</html>
