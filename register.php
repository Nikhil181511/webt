<?php
include 'db.php'; // Ensure this file contains the database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Get the raw password input

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Do not hash the password, use the raw password
    $rawPassword = $password;

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("ss", $email, $rawPassword);
        
        // Execute the statement and check for errors
        if ($stmt->execute()) {
            echo "User registered successfully!";
        } else {
            // Check for duplicate email error
            if ($stmt->errno === 1062) { // Error code for duplicate entry
                echo "Error: Email already registered.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close(); // Close the statement
    } else {
        echo "Preparation failed: " . $conn->error; // Handle prepare errors
    }
}

$conn->close(); // Close the database connection
?>
