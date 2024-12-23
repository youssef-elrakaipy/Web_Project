<?php
session_start();
include('db_connection.php');  // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$user_id = $_SESSION['user_id'];  // Get the logged-in user's ID from the session

// Prepare the SQL query to delete the user's account
$query = "DELETE FROM users WHERE user_id = ?";  // Use the appropriate field for user identification

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);  // Bind the user_id parameter

if ($stmt->execute()) {
    // Successfully deleted the account
    // Optionally, you can destroy the session to log the user out
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Your account has been deleted successfully.']);
} else {
    // Failed to delete the account
    echo json_encode(['success' => false, 'message' => 'Account deletion failed. Please try again.']);
}

$stmt->close();
$conn->close();
?>
