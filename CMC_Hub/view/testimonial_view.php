<?php
require('../config.php');
require('../model/DB.php');

$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $profilePicturePath = '';

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $profilePicture = $_FILES['profile_picture'];
        $uploadDir = '../uploads/';
        $profilePicturePath = $uploadDir . basename($profilePicture['name']);
        move_uploaded_file($profilePicture['tmp_name'], $profilePicturePath);
    }

    $stmt = $conn->prepare("INSERT INTO Cms_testimonial (content, profile_picture, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $content, $profilePicturePath);

    if ($stmt->execute()) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonial Submission</title>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .carousel-container {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .testimonial-slide {
            min-width: 100%;
            box-sizing: border-box;
            text-align: center;
            padding: 20px;
        }

        .testimonial-image img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #00173d;
            margin-bottom: 15px;
        }

        .testimonial-text {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }

        .testimonial-date {
            font-size: 12px;
            color: #888;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 2;
        }

        .carousel-btn.prev {
            left: 10px;
        }

        .carousel-btn.next {
            right: 10px;
        }

        .form-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-container label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .form-container input[type="file"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            transition: border-color 0.3s;
        }

        .form-container input[type="file"]:focus,
        .form-container textarea:focus {
            border-color: #00173d;
            outline: none;
        }

        .form-container button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00173d;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #1e3d6e;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2>Testimonial Form</h2>
            <form id="testimonial-form" method="POST" enctype="multipart/form-data">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*">

                <label for="content">Testimonial:</label>
                <textarea id="content" name="content" rows="4"></textarea>

                <button type="submit">Submit Testimonial</button>
            </form>
        </div>

        <div class="carousel-container">
            <button class="carousel-btn prev">‹</button>
            <button class="carousel-btn next">›</button>
            <div class="carousel">
                <?php
                $result = $conn->query("SELECT * FROM Cms_testimonial ORDER BY created_at DESC");
                while ($testimonial = $result->fetch_assoc()) {
                    echo '<div class="testimonial-slide">';
                    if ($testimonial['profile_picture']) {
                        echo '<div class="testimonial-image"><img src="' . htmlspecialchars($testimonial['profile_picture']) . '" alt="Profile Picture"></div>';
                    }
                    echo '<div class="testimonial-content">';
                    echo '<div class="testimonial-text">' . htmlspecialchars($testimonial['content']) . '</div>';
                    // echo '<div class="testimonial-date">' . date('Y-m-d', strtotime($testimonial['created_at'])) . '</div>';
                    echo '</div></div>';
                }
                ?>
            </div>
        </div>
    </div>
    <script>
    let currentIndex = 0;
    const carousel = document.querySelector('.carousel');
    const slides = document.querySelectorAll('.testimonial-slide');
    const totalSlides = slides.length;

    document.querySelector('.prev').addEventListener('click', function () {
        currentIndex = (currentIndex === 0) ? totalSlides - 1 : currentIndex - 1;
        updateCarousel();
    });

    document.querySelector('.next').addEventListener('click', function () {
        currentIndex = (currentIndex === totalSlides - 1) ? 0 : currentIndex + 1;
        updateCarousel();
    });

    function updateCarousel() {
        carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
</script>

</body>

</html>
