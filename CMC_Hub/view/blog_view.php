<?php
require('../config.php');
require('../model/DB.php');

$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();

// post_table
$query = "SELECT id, title, short_description, content, image FROM Cms_Post_table ORDER BY id DESC";
$result = $conn->query($query);
// author_table
$authorsQuery = "SELECT id, name FROM author_table ORDER BY name ASC";
$authorsResult = $conn->query($authorsQuery);

$isAdmin = true; 

$successMessage = isset($_GET['success']) ? $_GET['success'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Blog & View Entries</title>
    <style>

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
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
        }

        .nav ul li {
            position: relative;
        }

        .nav ul li a {
            color: #00173d;
            text-decoration: none;
            padding: 10px 15px;
            display: block;

        }

        .nav ul li a:hover {
            background-color: #e0e0e0;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-width: 160px;
            z-index: 1;
        }

        .dropdown-content a {
            color: #00173d;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #f4f4f4;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .container {
            flex: 1; 
            width: 100%;
            background: #00173d;
            color: #fff; 
        }

        .form-container {
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            display: none;
            width: 50%;
            margin: 1% 5% 5% 5%;
        }

        .form-container.show {
            display: block; 
        }

        .form-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #00173d; 
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin: 10px 0 5px;
            font-size: 14px;
            color: #333;
        }

        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="file"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .form-container textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-container button {
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .posts-container {
            margin: 5% 5%;
        }

        .posts-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ffffff;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .posts-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .post {
            padding: 20px;
            border-radius: 8px;
            width: calc(33.333% - 20px); 
            box-sizing: border-box;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            background-color: white;
        }

        .post img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .post h2 {
            margin: 0 0 10px;
            font-size: 20px;
            color: black;
        }

        .post p {
            margin: 0 0 10px;
            font-size: 16px;
            color: black;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
        }

        .post a {
            color: #003976;
            text-decoration: none;
            font-weight: bold;
        }

 

        .toggle-button {
            margin: 2% 2%;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            background-color: #737373;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .toggle-button:hover {
            background-color: #585858;
        }
        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: 5px;
        }
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
    <a href="/home.php">
        <img src="../view/src/cms logo.png" alt="CMC_Management Logo">
</a>
    </div>
    <nav class="nav">
        <ul>
            <li class="dropdown">
                <a href="#">Solutions</a>
                <div class="dropdown-content">
                    <a href="#">Solution 1</a>
                    <a href="#">Solution 2</a>
                    <a href="#">Solution 3</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#">Integrations</a>
                <div class="dropdown-content">
                    <a href="#">Integration 1</a>
                    <a href="#">Integration 2</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#">Customers</a>
                <div class="dropdown-content">
                    <a href="#">Customer 1</a>
                    <a href="#">Customer 2</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#">Resources</a>
                <div class="dropdown-content">
                    <a href="/view/blog_view.php">Blog</a>
                    <a href="/view/testimonial_view.php">Testimonial</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#">Pricing</a>
                <div class="dropdown-content">
                    <a href="#">Pricing Plan 1</a>
                    <a href="#">Pricing Plan 2</a>
                </div>
            </li>
        </ul>
    </nav>
</header>
<div class="container">
    <?php if ($isAdmin): ?>
        <button class="toggle-button" onclick="toggleForm()">Post Blog Form</button>
    <?php endif; ?>

    <div class="form-container" id="formContainer">
        <h1>Post a Blog Entry</h1>
        <form id="blogForm" action="./../controller/post_blog.php" method="post" enctype="multipart/form-data">
            <label for="title">Title: <span style="color: red;">*</span></label>
            <input type="text" id="title" name="title">
            <div id="titleError" class="error"></div>

            <label for="short_description">Short Description:</label>
            <textarea id="short_description" name="short_description"></textarea>

            <label for="content">Content: <span style="color: red;">*</span></label>
            <textarea id="content" name="content"></textarea>
            <div id="contentError" class="error"></div>
              
            <label for="author">Author: <span style="color: red;">*</span></label>
            <select id="author" name="author">
                <option value="">Select Author</option>
                <?php if ($authorsResult->num_rows > 0): ?>
                    <?php while ($author = $authorsResult->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($author['id']); ?>">
                            <?php echo htmlspecialchars($author['name']); ?>
                        </option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="">No authors available</option>
                <?php endif; ?>
            </select>
            <div id="authorError" class="error"></div>

            <label for="image">Image (optional):</label>
            <input type="file" id="image" name="image" accept="image/*">
            
            <button type="submit">Post Blog Entry</button>
        </form>
        
    </div>

    <div class="posts-container">
        <h1>All Blog Posts</h1>
        <div class="posts-row">
            <?php 
            while ($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <?php if (!empty($row['image'])): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <?php endif; ?>
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><?php echo htmlspecialchars($row['short_description']); ?></p>
                    <a href="post_detail.php?id=<?php echo htmlspecialchars($row['id']); ?>">Read more</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<script>
    function toggleForm() {
        const formContainer = document.getElementById('formContainer');
        formContainer.classList.toggle('show');
    }

    document.getElementById('formContainer').querySelector('form').addEventListener('submit', function (event) {
        const title = document.getElementById('title').value.trim();
        const content = document.getElementById('content').value.trim();
        let valid = true;

        document.getElementById('titleError').textContent = '';
        document.getElementById('contentError').textContent = '';

        if (title === '') {
            document.getElementById('titleError').textContent = 'Title is required.';
            valid = false;
        }

        if (content === '') {
            document.getElementById('contentError').textContent = 'Content is required.';
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); 
        }
    });

    document.getElementById('author').addEventListener('change', function () {
    const authorName = this.options[this.selectedIndex].text;
    const contentField = document.getElementById('content');

    if (contentField.value.trim() === '') {
        contentField.value = `Author: ${authorName}\n\n`;
    } 

    else {
        const lines = contentField.value.split('\n');
        if (lines[0].startsWith('Author:')) {
            lines[0] = `Author: ${authorName}`;
            contentField.value = lines.join('\n');
        }
         else {

            contentField.value = `Author: ${authorName}\n\n` + contentField.value;
        }
    }
});

</script>
</body>
</html>
