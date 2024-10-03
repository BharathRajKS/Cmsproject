<?php

session_start();
$db = require("../model/DB.php");
$config = require('../config.php');
$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();
define('ENCRYPTION_KEY', 'e5f6d7e8c9b10f11e5f6d7e8c9b10f11');

if(isset($_POST['name'], $_POST['email'], $_POST['password'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkEmailQuery = "SELECT * FROM Cms_Users WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        header("Location: ../login.php?error=email_exists");
        exit;
    }

    $encryptedPassword = openssl_encrypt($password, 'AES-128-ECB', ENCRYPTION_KEY);

    $sql = "INSERT INTO Cms_Users (name, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $encryptedPassword);

    if ($stmt->execute()) {
    
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_name'] = $name;
        header("Location: ../login.php?success=registered");
        exit;
    } else {
   
        error_log("Registration failed: " . $stmt->error);
        echo "Error: Registration failed";
    }
} else {
    echo "Invalid input data";
}

$conn->close();
?>
