

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CMC_Management</title>
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
      color: #00173d;
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

    .login-signup {
      color: #00173d;
    }

    .login-signup a {
      color: #00173d;
      text-decoration: none;
      margin: 0 5px;
      transition: color 0.3s ease;
    }

    .login-signup a:hover {
      text-decoration: underline;
      color: darkblue;
    }


    .hero-section {
      text-align: center;
      background-color: #00173d;
      color: white;
      padding: 60px 20px;
    }


    .hero-section h1 {
      font-size: 3.5rem;
      margin-bottom: 20px;
    }

    .hero-section p {
      font-size: 1.4rem;
      margin: 20px 0;
    }

    .hero-section button {
      padding: 12px 25px;
      background-color: white;
      color:#00173d ;
      border: 2px solid white;
      cursor: pointer;
      font-size: 1rem;
      border-radius: 5px;
    }

    .hero-section button:hover {
      background-color: grey;
      color: white;
      border-color: white;
    }
    .hero-section a{
      color: white;
      text-decoration: none;
      margin: 0 10px;
      
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
    .integration-graphic {
      text-align: center;
      margin: 40px 0;
    }

    .integration-graphic img {
      max-width: 80%;
      height: auto;
    }


    .trusted-by {
      background-color: #f9f9f9;
      padding: 40px 20px;
      text-align: center;
    }

    .trusted-by h2 {
      margin-bottom: 20px;
    }

    .trusted-by .brands {
      display: flex;
      justify-content: center;
      gap: 50px;
    }

    .trusted-by .brands img {
      max-width: 150px;
      height: auto;
      opacity: 0.8;
      transition: opacity 0.3s ease;
    }

    .trusted-by .brands img:hover {
      opacity: 1;
    }


    .features {
      padding: 40px 20px;
      background-color: #fff;
    }

    .features h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .feature-list {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
    }

    .feature {
      text-align: center;
      padding: 20px;
      max-width: 300px;
    }

    .feature h3 {
      margin-bottom: 15px;
    }

    .feature p {
      color: #666;
    }


    .workflow-section {
      padding: 40px 20px;
      text-align: center;
    }

    .workflow-section img {
      max-width: 80%;
      height: auto;
    }

 
    .why-CMS {
      background-color: #f9f9f9;
      padding: 40px 20px;
      text-align: center;
    }

    .why-CMS h2 {
      margin-bottom: 20px;
    }

    .benefits {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
    }

    .benefit {
      text-align: center;
      max-width: 300px;
      padding: 20px;
    }

    .benefit h3 {
      margin-bottom: 15px;
    }

    .benefit p {
      color: #666;
    }

    .footer {
      background-color: #00173d;
      color: white;
      text-align: center;
      padding: 30px 0;
    }

    .footer-logo img {
      max-height: 40px;
      margin-bottom: 10px;
    }

    .footer-links a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
    }

    .footer-links a:hover {
      text-decoration: underline;
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
    <div class="login-signup" id="auth-links">
      <a href="login.php" id="loginBtn">Login</a> | 
      <a href="register.php" id="signupBtn">Sign Up</a>
    </div>
  </header>

  <section class="hero-section">
    <h1>Make your systems talk to each other.</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt omnis harum libero magnam provident voluptates.</p>
    <a href="../view/blog_view.php" class="button">Show the content</a>
  </section>
   

  <section class="integration-graphic">
    <img src="../view/src/images.png" alt="ERP Integration Diagram">
  </section>



  <section class="trusted-by">
    <h2>Trusted by Leading Manufacturers & Distributors</h2>
    <div class="brands">
      <img src="../view/src/images (1).jpeg" alt="Brand 1">
      <img src="../view/src/images (1).jpeg" alt="Brand 2">
      <img src="../view/src/images (1).jpeg" alt="Brand 3">
      <img src="../view/src/images (1).jpeg" alt="Brand 4">
    </div>
  </section>


  <section class="features">
    <h2>Features</h2>
    <div class="feature-list">
      <div class="feature">
        <h3>Feature 1</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
      <div class="feature">
        <h3>Feature 2</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
      <div class="feature">
        <h3>Feature 3</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
      
    </div>
  </section>


  <section class="workflow-section">
    <img src="../view/src/images (1).jpeg" alt="Workflow Diagram">
  </section>


  <section class="why-CMS">
    <h2>Why CMS_Management</h2>
    <div class="benefits">
      <div class="benefit">
        <h3>Benefit 1</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
      <div class="benefit">
        <h3>Benefit 2</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
      <div class="benefit">
        <h3>Benefit 3</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
    </div>
  </section>


  <!-- Footer -->
  <footer class="footer">
    <div class="footer-logo">
      <img src="../view/src/cms logo.png" alt="CMC_Management Logo">
    </div>
    <div class="footer-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Use</a>
      <a href="#">Contact Us</a>
    </div>
  </footer>



<script>

  let isLoggedIn = true;

  function handleLogout() {
 
    isLoggedIn = true;

 

    
    window.location.href = 'login.php'; 
  }

  window.onload = function() {
    const authLinks = document.getElementById('auth-links');


    if (isLoggedIn) {
      authLinks.innerHTML = '<a href="#" id="logoutBtn">Logout</a>';

   
      const logoutBtn = document.getElementById('logoutBtn');
      logoutBtn.addEventListener('click', function(e) {
        e.preventDefault(); 
        handleLogout(); 
      });
    }
  }
</script>


</body>
</html>
