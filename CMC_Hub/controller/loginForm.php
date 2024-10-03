<?php
session_start();
require_once("../model/DB.php");
$config = require('../config.php');

$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();

$defaultAdminEmail = 'Admin@gmail.com';
$defaultAdminPasswordHash = password_hash('admin123', PASSWORD_DEFAULT); 

if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Cms_Users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPasswordHash = $row['password_hash'];

        if (password_verify($password, $storedPasswordHash)) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['is_admin'] = ($email === $defaultAdminEmail);

            echo json_encode([
                'status' => 'success',
                'role' => $_SESSION['is_admin'] ? 'admin' : 'user',
                'message' => 'Login successful'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ]);
        }
    } else if ($email === $defaultAdminEmail) {
  
        if (password_verify($password, $defaultAdminPasswordHash)) {
            $_SESSION['name'] = 'Admin';
            $_SESSION['is_admin'] = true;

            echo json_encode([
                'status' => 'success',
                'role' => 'admin',
                'message' => 'Login successful'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid credentials'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid input data'
    ]);
}

$conn->close();
?>
