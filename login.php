<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";  

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the response array
$response = array('success' => false, 'message' => '');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; // No MD5 needed, we'll use password_verify instead

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password using bcrypt or other secure hashing algorithms
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email;
            $response['success'] = true;
        } else {
            $response['message'] = "Wrong email or password \nPlease check your data again.";
        }
    } else {
        $response['message'] = "No user found with this email.";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>