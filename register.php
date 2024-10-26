<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }
    $rawPassword = $password;
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("ss", $email, $rawPassword);
        if ($stmt->execute()) {
            echo "User registered successfully!";
        } else {
            if ($stmt->errno === 1062) { 
                echo "Error: Email already registered.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close(); 
    } else {
        echo "Preparation failed: " . $conn->error;
    }
}

$conn->close();
?>
