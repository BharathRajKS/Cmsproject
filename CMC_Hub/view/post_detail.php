<?php
require('../config.php');
require('../model/DB.php'); 

$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();

if (isset($_GET['id'])) {
    $postId = intval($_GET['id']);
    $query = "SELECT id, title, short_description, content, image FROM Cms_Post_table WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    if (!$post) {
        die('Post not found.');
    }
} else {
    die('Invalid request.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            flex: 1;
            width: 100%;
            background: #00173d;
            color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 10px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo img {
            max-height: 50px;
        }
        .nav ul {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
        }
        .nav ul li {
            position: relative;
        }
        .nav ul li a {
            color: blue;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            transition: background-color 0.3s ease;
        }
        .nav ul li a:hover {
            background-color: #e0e0e0;
        }
        .main-content {
            padding: 20px;
            background-color: #00173d;
            color: #fff;
            min-height: calc(100vh - 80px);
        }
        .post {
            display: flex;
            align-items: flex-start;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 5% 5%;
            color: #333;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            gap: 58px;
        }
        .post img {
            max-width: 40%;
            height: auto;
            margin-right: 20px;
            border-radius: 4px;
            margin-top: 4%;
        }
        .post .content {
            flex: 2;
        }
        .post h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .post p {
            margin-bottom: 15px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 10%;
            overflow-y: auto; 
        }
        
        .action-buttons {
            margin-top: 20px;
        }
        .action-buttons a {
            margin-right: 10px;
            padding: 12px 28px;
            background-color: #060693;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .action-buttons a:hover {
            background-color: #0056b3;
        }
        .action-buttons a.delete {
            background-color: #060693;
        }
        .action-buttons a.delete:hover {
            background-color: #c82333;
        }

    .modal {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6); 

        
    }
    .modal-content {
        background-color: #fff;
        margin: 15% auto; 
        padding: 20px;
        border-radius: 8px; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        width: 90%; 
        max-width: 600px; 
        margin: 3% 27%;
        margin-top: 1%;
    }


    h2 {
        text-align: center;
        color: #333;
    }
    label {
        display: block;
        margin: 10px 0 5px;
        color: #555;
    }

    input[type="text"],
    textarea {
        width: calc(100% - 20px); 
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
      
    }
    
    textarea {
    width: calc(100% - 20px); 
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    height: 150px; 
     
   
}
    input[type="file"] {
        margin: 15px 0;
    }
    #editBtn{
        margin-right: 10px;
            padding: 12px 28px;
            background-color: #060693;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            height: 45px;
            width: 119px;
    }
    .btn {
        display: block;
        width: 100%; 
        padding: 10px;
        background-color: #28a745; 
        color: white; 
        border: none; 
        border-radius: 4px; 
        font-size: 16px;
        cursor: pointer; 
    
    }
    .btn:hover {
        background-color: #218838; 
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: #333; 
        text-decoration: none;
        cursor: pointer;
    }
    .current-image {
        margin: 15px 0;
        text-align: center;
    }
    
    button {
   color:white;
    background-color:#060693;;
    width: 118px;
    height: 38px;
    border: 1px solid #ccc;
}
.error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

body.modal-open {
    overflow: hidden; 
}
/* Style the scrollbar */
::-webkit-scrollbar {
    width: 8px; 
    height: 8px;
}


::-webkit-scrollbar-track {
    background-color: #f1f1f1; 
}


::-webkit-scrollbar-thumb {
    background-color: #060693; 
    border-radius: 10px; 
}

::-webkit-scrollbar-thumb:hover {
    background-color: #0056b3; 
}





    </style>
</head>
<body>
<header class="header">
    <div class="logo">
        <img src="./src/cms logo.png" alt="CMC_Management Logo">
    </div>
    <nav class="nav">
        <ul>
            <li class="dropdown"><a href="#">Solutions</a></li>
            <li class="dropdown"><a href="#">Integrations</a></li>
            <li class="dropdown"><a href="#">Customers</a></li>
            <li class="dropdown"><a href="#">Resources</a></li>
            <li class="dropdown"><a href="#">Pricing</a></li>
        </ul>
    </nav>
</header>

<div class="main-content">
    <div class="post">
        <?php if (!empty($post['image'])): ?>
            <img src="../uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
        <?php endif; ?>
        <div class="content">
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <p><strong>Description: </strong><?php echo htmlspecialchars($post['short_description']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <div class="action-buttons">
                <button id="editBtn">Edit</button>
                <a href="/controller/post_delete.php?id=<?php echo $post['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Edit Post Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Post</h2>
        <form id="editPostForm" method="POST" action="/controller/post_edit.php?id=<?php echo $post['id']; ?>" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>">
            <div id="titleError" class="error"></div>

            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_description"><?php echo htmlspecialchars($post['short_description']); ?></textarea>
            <div id="shortDescError" class="error"></div>

            <label for="content">Content</label>
            <textarea id="content" name="content"><?php echo htmlspecialchars($post['content']); ?></textarea>
            <div id="contentError" class="error"></div>

            <?php if ($post['image']): ?>
                <div class="current-image">
                    <p>Current Image:</p>
                    <img src="../uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" style="max-width: 200px;">
                </div>
            <?php endif; ?>
            
            <input type="file" name="image">
            <button type="submit">Update Post</button>
        </form>
    </div>
</div>

<script>
    // Get the modal and the button
    var modal = document.getElementById("editModal");
    var btn = document.getElementById("editBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Validation logic
    document.getElementById("editPostForm").addEventListener("submit", function(event) {
        var valid = true;
        
        var title = document.getElementById("title");
        var shortDescription = document.getElementById("short_description");
        var content = document.getElementById("content");

        var titleError = document.getElementById("titleError");
        var shortDescError = document.getElementById("shortDescError");
        var contentError = document.getElementById("contentError");

      
        titleError.textContent = "";
        shortDescError.textContent = "";
        contentError.textContent = "";

        title.classList.remove("invalid");
        shortDescription.classList.remove("invalid");
        content.classList.remove("invalid");

        // Title validation
        if (title.value.trim() === "") {
            valid = false;
            titleError.textContent = "Title is required.";
            title.classList.add("invalid");
        }

        // Short description validation
        if (shortDescription.value.trim() === "") {
            valid = false;
            shortDescError.textContent = "Short description is required.";
            shortDescription.classList.add("invalid");
        }

        // Content validation
        if (content.value.trim() === "") {
            valid = false;
            contentError.textContent = "Content is required.";
            content.classList.add("invalid");
        }

        if (!valid) {
            event.preventDefault();
        }
    });
    var modal = document.getElementById("editModal");
    var btn = document.getElementById("editBtn");
    var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
    document.body.classList.add("modal-open"); }

span.onclick = function() {
    modal.style.display = "none";
    document.body.classList.remove("modal-open"); 
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.body.classList.remove("modal-open"); 
    }
}

</script>
</body>
</html>