<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../config.php');
require('../model/DB.php');

$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}


$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; 
$offset = ($current_page - 1) * $limit;


$total_stmt = $conn->query("SELECT COUNT(*) as total FROM Cms_testimonial");
$total_count = $total_stmt->fetch_assoc()['total'];
$total_pages = ceil($total_count / $limit);


$stmt = $conn->prepare("SELECT * FROM Cms_testimonial LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Testimonials</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
      line-height: 1.6;
      font-size: 16px;
      background-color: #f4f4f4;
      color: #333;
    }

    /* Header */
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
      color: blue;
      text-decoration: none;
      padding: 10px 15px;
      display: block;
      transition: background-color 0.3s ease;
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
      color: #333;
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

        .testimonial-list {
            margin: 20px;
        }

        .testimonial {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            background: #ffffff;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .testimonial img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .testimonial-content {
            flex: 1;
        }

        .testimonial-text {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .testimonial-date {
            font-size: 12px;
            color: #6c757d;
        }

        .pagination {
            margin: 20px 0;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
            padding: 5px 10px;
            border: 1px solid #007bff;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination .active {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }
    </style>
</head>
<body>
<header class="header">
    <div class="logo">
      <img src="../view/src/cms logo.png" alt="CMC_Management Logo">
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
            <a href="/controller/fetch_testimonials.php">Testimonial</a>
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

    <div class="testimonial-list" id="testimonial-list">
        <h3>All Testimonials</h3>

        <?php if ($result->num_rows > 0) : ?>
            <?php while ($testimonial = $result->fetch_assoc()) : ?>
                <div class="testimonial">
                    <?php if ($testimonial['profile_picture']) : ?>
                        <img src="<?php echo htmlspecialchars($testimonial['profile_picture']); ?>" alt="Profile Picture">
                    <?php endif; ?>
                    <div class="testimonial-content">
                        <div class="testimonial-text"><?php echo htmlspecialchars($testimonial['content']); ?></div>
                        <div class="testimonial-date"><?php echo date('Y-m-d', strtotime($testimonial['created_at'])); ?></div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No testimonials available.</p>
        <?php endif; ?>

        <div class="pagination">
            <?php if ($current_page > 1) : ?>
                <a href="?page=<?php echo $current_page - 1; ?>">&laquo; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo ($i === $current_page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages) : ?>
                <a href="?page=<?php echo $current_page + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
