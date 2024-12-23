<?php
include 'db_config.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // SQL statement for inserting a new user
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the SQL statement
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to login page if successful
            header("Location: login.html");
            exit(); // Ensure no further code is executed after redirect
        } else {
            // Output error if execution failed
            echo "Execute Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Output error if preparation failed
        echo "Prepare Error: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid Request Method";
}
?>