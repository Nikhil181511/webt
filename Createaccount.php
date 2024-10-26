<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM loginrecords WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose another one.";
    } else {
        $stmt = $conn->prepare("INSERT INTO loginrecords (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        
        if ($stmt->execute()) {
            echo "Account created successfully!";
            header("Location: Userinterface.html");
            exit();
        } else {
            echo "Error creating account. Please try again.";
        }
    }

    $stmt->close();
}
$conn->close();
?>
