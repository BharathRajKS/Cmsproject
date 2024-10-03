<?php
require('../config.php');
require('../model/DB.php'); 

$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? ''; 
    $profile_picture = '';
    $upload_errors = [];

    if (empty($content)) {
        $upload_errors[] = "Testimonial content cannot be empty.";
    }

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        
        $check = getimagesize($_FILES['profile_picture']['tmp_name']);
        if ($check !== false) {
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                $profile_picture = $target_file; 
            } else {
                $upload_errors[] = "There was an error uploading your file.";
            }
        } else {
            $upload_errors[] = "File is not an image.";
        }
    } elseif (isset($_FILES['profile_picture'])) {
        $upload_errors[] = "File upload error: " . $_FILES['profile_picture']['error'];
    }


    if (empty($upload_errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO Cms_testimonial (profile_picture, content) VALUES (:profile_picture, :content)");
            $stmt->execute(['profile_picture' => $profile_picture, 'content' => $content]);
            header("Location: testimonial_view.php");
            exit();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $upload_errors[] = "Failed to submit testimonial.";
        }
    }

    if (!empty($upload_errors)) {
        foreach ($upload_errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }
}
?>
