<?php
require('../config.php');
require('../model/DB.php'); 

$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();

if (isset($_GET['id'])) {
    $postId = intval($_GET['id']);
    
    $stmt = $conn->prepare("DELETE FROM Cms_Post_table WHERE id = ?");
    $stmt->bind_param("i", $postId);

    if ($stmt->execute()) {

        header('Location: ../view/blog_view.php?message=Post deleted successfully!');
        exit;
    } else {
        echo 'Error deleting post: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    die('Invalid request.');
}
?>
