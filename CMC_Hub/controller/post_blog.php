<?php
require('../config.php');
require('../model/DB.php'); 

$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $short_description = $_POST['short_description'];
    $content = $_POST['content'];
    $image = '';

    $uploadsDir = '../uploads/';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imagePath = $uploadsDir . basename($imageName);

        if (move_uploaded_file($imageTmpName, $imagePath)) {
            $image = $imagePath;
        } else {
            echo 'Error uploading image. Please check the folder permissions.';
            exit;
        }
    } elseif (isset($_FILES['image']['error']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        echo 'Image upload failed with error code: ' . $_FILES['image']['error'];
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO Cms_Post_table (title, short_description, content, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $title, $short_description, $content, $image);

    if ($stmt->execute()) {
        echo 'Blog post submitted successfully!';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request method.';
}
