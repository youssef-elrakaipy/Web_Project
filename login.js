document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Create a new FormData object
    const formData = new FormData();
    formData.append('email', username);
    formData.append('password', password);

    // Send the request via AJAX
    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Parse the response as JSON
    .then(data => {
        if (data.success) {
            // Redirect to the car collection page on successful login
            window.location.href = 'index.html';
        } else {
            // Display an error message if login fails
            document.getElementById('message').innerText = data.message || 'Login failed. Please try again.';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('message').innerText = 'An error occurred. Please try again later.';
    });
});
