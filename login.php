<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $storedPassword = $user['password']; // Directly using the stored password

        // Compare the plain-text password directly
        if ($password === $storedPassword) {
            // Start session
            session_start();
            $_SESSION['user_email'] = $email; // Store user email in session

            // Redirect to userinterface.html
            header("Location: staff.php");
            exit(); // Make sure to call exit after header redirect
        } else {
            echo "Invalid credentials."; // Wrong password
        }
    } else {
        echo "Invalid credentials."; // Email not found
    }

    $stmt->close();
}

$conn->close();
?>
