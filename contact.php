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
    <title>Contact Us</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file -->
    <style>
        /* Add your CSS styles here */
        /* Reset default styles */
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            background-image: url('./images/seeds.png');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed; /* Fix the background image */
            height: 100vh; /* Set the body height to full viewport height */
            margin: 0;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header styles */
        header {
            color: #fff;
            padding: 20px 0;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        nav ul {
            list-style-type: none;
            margin-top:5px;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
        }

        /* Add hover styles for navigation links */
        nav ul li a:hover {
            color: #ffa500; /* Change text color on hover */
            text-decoration: underline; /* Underline text on hover */
        }

        nav ul li a.active {
            color: #ffa500; /* Change to your desired active link color */
        }

        /* Main content styles */
        .main-content {
            padding: 50px 0;
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

        /* Add hover styles for navigation links */
        nav ul li:hover a {
            color: #ffa500; /* Change text color on hover */
            text-decoration: underline; /* Underline text on hover */
        }

        .no-crops-msg {
            color: white;
        }
        form {
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color:white;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            border-color: #ffa500;
        }

        button[type="submit"] {
            background-color: #ffa500;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left:40%;
        }

        button[type="submit"]:hover {
            background-color: #ff7c00;
        }
        .main-content h2{
           color:black;
           font-style:italic;
           text-align:center;
        }
        
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>FarmAssist</h1>
            <div class="profile">
                <img src="./images/profile.jpg" alt="Profile Image">
                <div class="profile-details">
                    <?php if (!empty($login_user)) : ?>
                        <span class="profile-name"><?php echo $login_user; ?></span>
                        <a href="./login.php">Logout</a> <!-- Assuming you have a logout.php file -->
                    <?php else : ?>
                        <a href="./login.php">Login</a>
                    <?php endif; ?>
                </div>
            </div>
            <nav>
                <ul>
                <li><a href="./agri.php" <?php if ($currentPage == 'agri.php') echo 'class="active"'; ?>>Home</a></li>
            <li><a href="./seeds.php" <?php if ($currentPage == 'seeds.php') echo 'class="active"'; ?>>Seeds</a></li>
            <li><a href="./protection.php" <?php if ($currentPage == 'protection.php') echo 'class="active"'; ?>>Protection</a></li>
            <li><a href="./crop_practices.php" <?php if ($currentPage == 'crop_practices.php') echo 'class="active"'; ?>>Crop Practices</a></li>
            <li><a href="./myorders.php"<?php if ($currentPage == 'myorders.php') echo 'class="active"'; ?>>MyOrders</a></li>
            <li><a href="./contact.php"<?php if ($currentPage == 'contact.php') echo 'class="active"'; ?>>Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="main-content">
        <div class="container">
            <form id="contact-form" action="send_email.php" method="post">
            <h2>Contact Us</h2>
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="subject">Your Subject:</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Your Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>
</body>
</html>
