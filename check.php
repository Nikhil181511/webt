<?php
include 'db.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT password FROM loginrecords WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $storedPassword = $user['password'];

        // Compare the plain-text password
        if ($password === $storedPassword) {
            session_start();
            $_SESSION['user_username'] = $username; // Store user info in session
            header("Location: Userinterface.html"); // Redirect on success
            exit();
        } else {
            echo "Invalid credentials."; // Wrong password
        }
    } else {
        echo "Invalid credentials."; // Username not found
    }

    $stmt->close();
}

$conn->close();
?>
