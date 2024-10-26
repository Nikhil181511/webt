<?php
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT password FROM loginrecords WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $storedPassword = $user['password'];
        if ($password === $storedPassword) {
            session_start();
            $_SESSION['user_username'] = $username;
            header("Location: Userinterface.html");
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
