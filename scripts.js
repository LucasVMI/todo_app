document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript file loaded'); // Debugging log

    const form = document.querySelector('form');
    const input = document.querySelector('input[name="task"]');
    const dateInput = document.querySelector('input[name="due_date"]');
    const categoryInput = document.querySelector('input[name="category"]');
    const prioritySelect = document.querySelector('select[name="priority"]');
    const ul = document.querySelector('ul');
    const deleteAllTasksBtn = document.getElementById('delete-all-tasks');
    const deleteAccountBtn = document.getElementById('delete-account');
    const usernameSpan = document.getElementById('username');
    const loginModal = document.getElementById('login-modal');
    const closeModal = document.querySelector('.close');
    const logoutBtn = document.getElementById('logout'); // Add this line
    console.log('Page loaded, calling loadTasks');
    console.log('Login modal element:', loginModal);

    let isGuest = true;

    if (usernameSpan) {
        fetch('get_username.php')
            .then(response => response.json())
            .then(data => {
                if (data.username) {
                    usernameSpan.textContent = data.username;
                    isGuest = false;
                } else {
                    usernameSpan.textContent = 'Guest';
                }
            });
    }

    // Load tasks from server
    loadTasks();

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const text = input.value.trim();
        const dueDate = dateInput.value;
        const category = categoryInput.value.trim();
        const priority = prioritySelect.value;

        console.log('Form submitted:', { text, dueDate, category, priority});

        if (text !== '') {
            if (isGuest) {
                addTask({ task: text, due_date: dueDate, category: category, priority: priority });
                form.reset();
                showLoginModal();
            } else {
                fetch('todo_list.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        task: text,
                        due_date: dueDate,
                        category: category,
                        priority: priority
                    })
                }).then(response => {
                    console.log('Full response:', response);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        throw new Error('Received non-JSON response');
                    }
                }).then(data => {
                    console.log(data);
                    if (data.message) {
                        addTask({ task: text, due_date: dueDate, category: category, priority: priority });
                        input.value = '';
                        dateInput.value = '';
                        categoryInput.value = '';
                        prioritySelect.value = 'low';
                    } else if (data.error) {
                        alert(data.error);
                    }
                }).catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
            }
        }
    });

    function loadTasks() {
        fetch('todo_list.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    throw new Error('Received non-JSON response');
                }
            })
            .then(tasks => {
                console.log('Tasks loaded:', tasks);
                tasks.forEach(task => addTask(task));
            })
            .catch(error => {
                console.error('Error loading tasks:', error);
            });
    }
    

    function addTask(task) {
        console.log('Adding task:', task);
        const li = document.createElement('li');
        li.setAttribute('data-id', task.id);
        li.textContent = `${task.task} (Due: ${task.due_date}, Category: ${task.category}, Priority: ${task.priority})`;

        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Delete';
        deleteBtn.classList.add('delete-btn');
        li.appendChild(deleteBtn);
        ul.appendChild(li);
    }

    ul.addEventListener('click', function(e) {
        if (e.target.tagName === 'BUTTON' && e.target.classList.contains('delete-btn')) {
            removeTask(e.target.parentElement);
        }
    });

    deleteAllTasksBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to delete all tasks?')) {
            deleteAllTasks();
        }
    });

    deleteAccountBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            deleteAccount();
        }
    });

    function removeTask(task) {
        task.remove();
    }

    function deleteAllTasks() {
        ul.innerHTML = '';
        fetch('delete_all_tasks.php', { method: 'POST' });
    }

    function deleteAccount() {
        fetch('delete_account.php', { method: 'POST' })
            .then(response => {
                if (response.ok) {
                    window.location.href = 'login.html';
                } else {
                    alert('Failed to delete account.');
                }
            });
    }

    function showLoginModal() {
        console.log('showLoginModal Called');
        loginModal.style.display = 'block';
    }

    closeModal.addEventListener('click', function() {
        loginModal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == loginModal) {
            loginModal.style.display = 'none';
        }
    });

    ul.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-btn')) {
            const li = event.target.parentElement;
            const taskId = li.getAttribute('data-id');

            console.log('Delete button clicked for task ID:', taskId);

            fetch('delete_task.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    id: taskId
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response from server:', data);
                if (data.success) {
                    li.remove();
                } else {
                    alert('Failed to delete task');
                }
            })
            .catch(error => {
                console.error('Error deleting task:', error);
            });
        }
    });

    if (logoutBtn) { // Add this null check
        logoutBtn.addEventListener('click', function() {
            window.location.href = 'logout.php';
        });
    }
});
