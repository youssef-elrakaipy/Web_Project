<?php
include 'db_config.php';

// Prepare the response array
$response = array('success' => false, 'message' => '');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Start the session to get the logged-in user's email
    session_start();
    $logged_in_email = $_SESSION['email'];

    // Prepare the SQL statement
    if ($password) {
        // If password is provided, update it
        $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $logged_in_email);
    } else {
        // If password is not provided, do not update it
        $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $logged_in_email);
    }

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Update the session email if the email was changed
        $_SESSION['email'] = $email;
        $response['success'] = true;
        $response['message'] = "User information updated successfully.";
    } else {
        $response['message'] = "Update failed: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    $response['message'] = "Invalid Request Method";
}

// Close the database connection
$conn->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
