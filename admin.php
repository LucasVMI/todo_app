<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
</head>
<body>
    <h1>Admin Page</h1>
    <ul id="user-list">
        <!-- Users will be listed here -->
    </ul>
    <form id="reset-password-form">
        <input type="hidden" id="user-id" name="userId">
        <input type="password" id="new-password" name="newPassword" placeholder="New Password">
        <button type="submit">Reset Password</button>
    </form>
    <script src="admin.js"></script>
</body>
</html>
