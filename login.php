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
        $storedPassword = $user['password']; 
        if ($password === $storedPassword) {
            session_start();
            $_SESSION['user_email'] = $email;
            header("Location: staff.php");
            exit(); 
        } else {
            echo "Invalid credentials."; 
        }
    } else {
        echo "Invalid credentials.";
    }

    $stmt->close();
}

$conn->close();
?>
