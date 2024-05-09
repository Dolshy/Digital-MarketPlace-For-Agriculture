:<?php
// Start session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['login_user'])) {
    $login_user = $_SESSION['login_user'];
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit(); // Stop further execution
}

// Define the $currentPage variable and set its initial value
$currentPage = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FarmAssist</title>
  <style>
    /* Define CSS animations */
    @keyframes fadeInDown {
      0% {
        opacity: 0;
        transform: translateY(-50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Global styles */
    body {
        font-family: Arial, sans-serif;
        background-image: url('./images/background.jpg');
        background-size: cover;
        background-position: center center;
        background-repeat: repeat;
        height: 100vh; /* Set the body height to full viewport height */
    }


    .container {
        max-width: 1200px;
        padding: 0 20px;
        margin: 0 auto; /* Center the container horizontally */
    }

    /* Header styles */
    header {
        color: #333; /* Darker text color */
        padding: 20px 0;
        position: relative;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Add shadow */
        height:100px;
    }

    header h1 {
        margin: 0;
        font-size: 24px;
        font-weight: bold; /* Add font weight */
        text-transform: uppercase; /* Uppercase header text */
        letter-spacing: 2px; /* Add letter spacing */
    }

    nav ul {
        list-style-type: none;
        margin-top: 10px; /* Add some margin */
    }

    nav ul li {
        display: inline;
        margin-right: 20px;
    }

    nav ul li a {
        text-decoration: none;
        color: #666; /* Lighter text color */
        transition: color 0.3s ease; /* Smooth transition */
    }

    /* Add hover styles for navigation links */
    nav ul li a:hover {
        color: #ffa500; /* Change text color on hover */
    }

    nav ul li a.active {
        color: #ffa500; /* Change to your desired active link color */
    }
 /* Profile section styles */
 .profile {
        display: flex;
        align-items: center;
        justify-content: flex-end; /* Align items to the right */
        position: absolute;
        top: 20px;
        right: 20px;
        color: black;
    }

    .profile img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        left: 0px; /* Adjust margin if needed */
    }

    .profile-details {
        margin-top:0px;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        margin-left: 20px; /* Align items to the right */
    }

    .profile-name {
        margin-top: 10px;
        margin-bottom: 10px;
        color: white; /* Add margin below the username */
    }

    /* Change color of login and logout links */
    .profile-details a {
        color: white;
    }

    /* Hover styles for login and logout links */
    .profile-details a:hover {
        color: #ffa500;
    }

    /* Banner section styles */
    .banner {
 /* Orange background color */
        color: black; /* White text color */
        padding: 100px 0;
        text-align: center;
        margin-top: 130px; /* Adjusted margin */
        margin-bottom: 230px; /* Adjusted margin */
        animation: fadeIn 1s ease-in-out;
    }

    .banner h2 {
        font-size: 30px;
        margin-bottom: 20px;
        font-style: italic;
    }

    /* Section styles */
    .section {
        padding: 80px 0;
        text-align: center; /* Center align section content */
        background-color: #fff; /* White background color */
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Add shadow */
        margin-bottom: 50px; /* Add margin */
        animation: fadeIn 1s ease-in-out; /* Add fade-in animation */
    }

    .section-content {
        max-width: 800px;
        margin: 0 auto; /* Center content horizontally */
    }

    .section h3 {
        font-size: 28px;
        
        margin-bottom: 20px;
        color: #333; /* Darker text color */
        text-transform: uppercase; /* Uppercase section headings */
        letter-spacing: 1px; /* Add letter spacing */
    }

    .section p {
        font-size: 18px;
        color: #666; /* Lighter text color */
        line-height: 1.6;
    }

    /* Testimonials section styles */
    .testimonial-section {
        padding: 80px 0;
        background-color: #fff;
        text-align: center;
        margin-bottom: 50px;
    }

    .testimonial-section h3 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #333; /* Darker text color */
        text-transform: uppercase; /* Uppercase section headings */
        letter-spacing: 1px; /* Add letter spacing */
    }

    .testimonial-text {
        font-size: 18px;
        color: #666; /* Lighter text color */
        margin-bottom: 40px;
    }

    .testimonial-text blockquote {
        font-style: italic;
        margin: 0;
        padding: 0;
    }

    .testimonial-author {
        font-weight: bold;
    }
    
  </style>
</head>
<body>
  <header>
    <div class="container">
      
      <nav>
        <ul>
          <li><a href="./agri.php" <?php if ($currentPage == 'agri.php') echo 'class="active"'; ?>>Home</a></li>
          <li><a href="./seeds.php" <?php if ($currentPage == 'seeds.php') echo 'class="active"'; ?>>Seeds</a></li>
          <li><a href="./protection.php" <?php if ($currentPage == 'protection.php') echo 'class="active"'; ?>>Protection</a></li>
          <li><a href="./crop_practices.php"<?php if ($currentPage == 'crop_practices.php') echo 'class="active"'; ?>>Crop Practices</a></li>
          <li><a href="./myorders.php"<?php if ($currentPage == 'myorders.php') echo 'class="active"'; ?>>MyOrders</a></li>
          <li><a href="./contact.php"<?php if ($currentPage == 'contact.php') echo 'class="active"'; ?>>Contact Us</a></li>
        </ul>
      </nav>
      <div class="profile">
        <img src="./images/profile.jpg" alt="Profile Image">
        <div class="profile-details">
          <?php if (isset($login_user)) : ?>
            <span class="profile-name"><?php echo $login_user; ?></span>
            <a href="./login.php">Logout</a>
          <?php else : ?>
            <a href="./login.php">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>
  
  <section class="banner">
    <div class="container">
      <h2>Empowering Farmers with Expert Advice and Quality Supplies</h2>
    </div>
  </section>
  <section class="section">
    <div class="container section-content">
      <h3>About Us</h3>
      <p>We are dedicated to providing farmers with the tools and knowledge they need to succeed. Our team of experts is here to support you at every step of your farming journey.</p>
    </div>
  </section>

  <section class="section">
    <div class="container section-content">
      <h3>Our Services</h3>
      <p>From seed selection to crop protection, we offer a comprehensive range of services to help you maximize your yield and profitability.</p>
    </div>
  </section>

  <section class="testimonial-section">
    <div class="container section-content">
      <h3>Testimonials</h3>
      <div class="testimonial-text">
        <blockquote>"FarmAssist has truly transformed the way I manage my farm. Their expert advice and quality supplies have helped me achieve higher yields and increased profitability."</blockquote>
        <p class="testimonial-author">- John Doe, Farmer</p>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container section-content">
      <h3>Contact Us</h3>
      <p>Feel free to contact us for any inquiries or assistance. We are here to help you.</p>
      <p>Email: info@farmassist.com</p>
      <p>Phone: 123-456-7890</p>
    </div>
  </section>
  
</body>
</html>
