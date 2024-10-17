<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="auth-styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="particles-js"></div>
    <div class="container login">
        <h2>Login</h2>
        <p id="error-message" class="error" style="display: none;"></p>
        <form id="login-form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="particles-config.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('login-form');
            const errorMessage = document.getElementById('error-message');

            loginForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting the traditional way

                const formData = new FormData(loginForm);

                fetch('loginauth.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          window.location.href = 'index.php'; // Redirect on successful login
                      } else {
                          errorMessage.textContent = data.error; // Display error message
                          errorMessage.style.display = 'block'; // Ensure the error message is visible
                      }
                  }).catch(error => {
                      console.error('Error:', error);
                  });
            });
        });
    </script>
</body>
</html>
