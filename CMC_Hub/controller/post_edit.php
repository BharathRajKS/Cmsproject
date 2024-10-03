<?php
require('../config.php');
require('../model/DB.php'); 

$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();

$post = null;
$message = "";

if (isset($_GET['id'])) {
    $postId = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT id, title, short_description, content, image FROM Cms_Post_table WHERE id = ?");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $post = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $post) {
    $title = trim($_POST['title']);
    $short_description = trim($_POST['short_description']);
    $content = trim($_POST['content']);
    $image = $post['image'];


    if (empty($title) || empty($short_description) || empty($content)) {
        $message = "All fields are required.";
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $uploadsDir = '../uploads/';
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imagePath = $uploadsDir . basename($imageName);

        $imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                $image = $imageName; 
            } else {
                $message = "Failed to upload the image.";
            }
        } else {
            $message = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    if (empty($message)) {
        $stmt = $conn->prepare("UPDATE Cms_Post_table SET title = ?, short_description = ?, content = ?, image = ? WHERE id = ?");
        $stmt->bind_param('ssssi', $title, $short_description, $content, $image, $postId);

        if ($stmt->execute()) {
            header('Location: ../view/blog_view.php?message=Post updated successfully!');
            exit;
        } else {
            $message = 'Error: ' . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>











<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #3f5eff; 
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff; 
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 20px; 
        }
        input[type="text"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 12px; 
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s; 
        }
        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff; 
            outline: none; 
        }
        textarea {
            height: 150px;
            resize: none; /* Prevent resizing */
        }
        button {
            padding: 12px;
            background-color: #007bff; /* Blue background */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s; /* Smooth background color change */
        }
        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .current-image {
            text-align: center;
        }
        .current-image img {
            width: 100%; /* Responsive image width */
            max-width: 200px; /* Max width for the image */
            border-radius: 4px;
            margin-top: 10px;
        }
        .message {
            color: #dc3545; /* Red for error messages */
            text-align: center;
            margin-bottom: 20px;
        }
        .success-message {
            color: #28a745; /* Green for success messages */
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px; /* Reduced padding for mobile */
            }
        }
    </style>

</head>
<body>
    <div class="container">
        <h2>Edit Post</h2>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            <textarea name="short_description" required><?php echo htmlspecialchars($post['short_description']); ?></textarea>
            <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>

            <?php if ($post['image']): ?>
                <div class="current-image">
                    <p>Current Image:</p>
                    <img src="../uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image">
                </div>
            <?php endif; ?>
            
            <input type="file" name="image">
            <button type="submit">Update Post</button>
        </form>
    </div>
</body>
</html> -->
