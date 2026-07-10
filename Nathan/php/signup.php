<?php
session_start();
require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['username'], $_POST['email'], $_POST['password'])) {
        die("Missing form data");
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            header("Location: ../index.html"); // Redirect ke halaman utama setelah signup
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Statement preparation failed: " . $conn->error;
    }
}
?>