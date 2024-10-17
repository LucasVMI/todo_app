<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="particles-js"></div>
    <header>
        <h1>Welcome To Remember!</h1>
        <span id="username"></span>
    </header>
    <div class="container">
        <h2>Get Started</h2>
        <form id="todo-form">
            <input type="text" name="task" placeholder="Add a new task" required>
            <input type="date" name="due_date" placeholder="Due date">
            <input type="text" name="category" placeholder="Category">
            <select name="priority">
                <option value="low">Low Priority</option>
                <option value="medium">Medium Priority</option>
                <option value="high">High Priority</option>
            </select>
            <button type="submit" class="btn">Add Task</button>
        </form>
        <ul id="task-list"></ul>
        <button onclick="window.location.href='login.php'" class="btn">Log In</button>
        <button onclick="window.location.href='register.php'" class="btn">Register</button>
    </div>

    <!-- Login Modal -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <p>Please log in or register to save your tasks.</p>
            <button onclick="window.location.href='register.php'" class="btn">Register</button>
            <button onclick="window.location.href='login.php'" class="btn">Login</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="particles-config.js"></script>
    <script src="scripts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginModal = document.getElementById('login-modal');
            const closeModal = document.querySelector('.close');
            const form = document.getElementById('todo-form');

            // Function to show the login modal
            function showLoginModal() {
                loginModal.style.display = 'block';
            }

            // Function to close the login modal
            function closeLoginModal() {
                loginModal.style.display = 'none';
            }

            // Event listener for the close button
            closeModal.addEventListener('click', function() {
                closeLoginModal();
            });

            // Event listener for clicks outside the modal content
            window.addEventListener('click', function(event) {
                if (event.target == loginModal) {
                    closeLoginModal();
                }
            });

            // Event listener for form submission
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting
                showLoginModal(); // Show the login modal
            });
        });
    </script>
</body>
</html>
