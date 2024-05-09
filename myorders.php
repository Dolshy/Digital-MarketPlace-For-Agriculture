<?php
// Start session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['login_user'])) {
    $login_user = $_SESSION['login_user']; // Fetch user_name from session
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit(); // Stop further execution
}

// Include db_connection.php file to establish database connection
include_once './db_connection.php';

// Define the $currentPage variable and set its initial value
$currentPage = basename($_SERVER['PHP_SELF']);

// Fetch orders for the logged-in user from the database
$sql = "SELECT * FROM orders WHERE user_name = '$login_user'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FarmAssist</title>
  <link rel="stylesheet" href="./agri-style.css">
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
        background-image: url('./images/seeds.png');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        height: 100vh; /* Set the body height to full viewport height */
    }

    .container {
        max-width: 1200px;
        padding: 0 20px;
        margin: 0 auto; /* Center the container horizontally */
    }

    /* Header styles */
    header {
        color: white;
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
        color: white;
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
        padding: 20px 0;
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

    /* Add hover styles for navigation links */
    nav ul li:hover a {
        color: #ffa500; /* Change text color on hover */
        text-decoration: underline; /* Underline text on hover */
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
    .order-card {
        display: flex;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .order-card h2 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #333; /* Title color */
    }

    .order-card p {
        margin-bottom: 5px;
        color: #666; /* Text color */
    }
    .title{
        text-align:center;
        margin-bottom:10px;
        color:#ffa500;
    }

    .order-card .image {
        flex: 0 0 150px; /* Set width of image */
        margin-right: 150px;
        

    }

    .order-card .image img {
        width:180px;
        height:150px;
        border-radius: 8px;
    }

    .order-card .content {
        flex: 1; /* Take remaining space */
    }
  </style>
</head>
<body>
  <header>
    <div class="container">
 
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
    </div>
  </header>
  
  <section class="main-content">
    <div class="container">
        <h1 class="title">My Orders</h1>
        <div class="orders">
            <!-- Orders will be dynamically added here -->
            <?php
            // Check if orders are fetched successfully
            if ($result && $result->num_rows > 0) {
                // Output each order as a card
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="order-card">';
                    // Fetch the image from the database using product_type and product_id
                   // Fetch the image from the database using product_type and product_id
$product_type = $row['product_type'];
$product_id = $row['product_id'];
$image_sql = "SELECT image_url FROM $product_type WHERE product_id = $product_id";

$image_result = $conn->query($image_sql);
if ($image_result && $image_result->num_rows > 0) {
    $image_row = $image_result->fetch_assoc();
    $image_src = $image_row['image_url']; // Update key to 'image_url'
    echo '<div class="image"><img src="' . $image_src . '" alt="Product Image"></div>';
} else {
    echo '<div class="image"><img src="./images/default.jpg" alt="Default Image"></div>';
}

                    // Display other order details
                    echo '<div class="content">';
                    echo '<h2>' . $row['product_name'] . '</h2>';
                    echo '<p>Weight: ' . $row['weight'] . '</p>';
                    echo '<p>Quantity: ' . $row['quantity'] . '</p>';
                    echo '<p>Total Price: Rs.' . $row['total_price'] . '/-</p>';
                    echo '<p>Order Date: ' . $row['order_date'] . '</p>';
                    echo '<p>Status: ' . $row['status'] . '</p>';
                    // Add more details as needed
                    echo '</div>'; // Close content div
                    echo '</div>'; // Close order-card div
                }
            } else {
                echo '<p>No orders found.</p>';
            }
            ?>
        </div> <!-- Close orders div -->
    </div> <!-- Close container div -->
  </section>
</body>
</html>
