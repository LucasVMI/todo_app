document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_users.php')
        .then(response => response.json())
        .then(users => {
            const userList = document.getElementById('user-list');
            users.forEach(user => {
                const listItem = document.createElement('li');
                listItem.textContent = user.username;
                listItem.dataset.userId = user.id;
                listItem.style.cursor = 'pointer'; // Add cursor style to indicate clickable
                listItem.addEventListener('click', handleUserClick);
                userList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error fetching users:', error));
});

function handleUserClick(event) {
    const userId = event.target.dataset.userId;
    document.getElementById('user-id').value = userId;
    document.getElementById('user-id-admin').value = userId;
}

document.getElementById('reset-password-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const userId = document.getElementById('user-id').value;
    const newPassword = document.getElementById('new-password').value;

    fetch('reset_password.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ userId, newPassword })
    })
    .then(response => response.text())
    .then(data => alert(data))
    .catch(error => console.error('Error:', error));
});

document.getElementById('make-admin-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const userId = document.getElementById('user-id-admin').value;

    fetch('make_admin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ userId })
    })
    .then(response => response.text())
    .then(data => alert(data))
    .catch(error => console.error('Error:', error));
});
