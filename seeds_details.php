<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FarmAssist</title>
  
  <style>
    /* Add styles for profile section */
    /* Reset default styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Global styles */
    body {
        font-family: Arial, sans-serif;
        background-image: url('./images/cropsback.png');
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

    /* Main content styles */
    .main-content {
        padding: 50px 0;
    }

    /* Product card styles */
    .product-card {
        width: calc(25% - 40px); /* 25% of the container width minus margins */
        margin: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        display: inline-block; /* Display seed cards side by side */
        cursor: pointer; /* Change cursor to pointer on hover */
        transition: transform 0.3s ease-in-out;
        background-color: #fff; /* Set background color for seed cards */
        opacity: 0; /* Initially set opacity to 0 */
        animation: fadeIn 0.5s ease forwards; /* Apply fade-in animation */
        height: 100%; /* Make each card fill the height of the container */
        vertical-align: top; /* Align the cards to the top */
        box-sizing: border-box; /* Include padding and border in the height calculation */
        display: flex; /* Use flexbox for horizontal alignment */
        flex-direction: column; /* Align content vertically */
        justify-content: space-between; /* Space evenly between content */
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .product-card:hover {
        transform: scale(1.05); /* Scale up on hover */
    }

    .product-card img {
        max-width: 200px;
        height: 200px;
    }

    .product-card h3 {
        margin-bottom: 10px;
    }

    .product-card p {
        font-size: 14px;
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
  </style>
</head>
<body>
  <header>
    <div class="container">
      <h1>FarmAssist</h1>
      <div class="profile">
        <img src="./images/prof.png" alt="Profile Image">
        <div class="profile-details">
          <?php 
          // Start session
          session_start();

          // Check if the user is already logged in
          if (isset($_SESSION['login_user'])) : ?>
            <span class="profile-name"><?php echo $_SESSION['login_user']; ?></span>
            <a href="./logout.php">Logout</a>
          <?php else : ?>
            <a href="./login.php">Login</a>
          <?php endif; ?>
        </div>
      </div>
      <nav>
        <ul>
          <li><a href="./agri.php">Home</a></li>
          <li><a href="./seeds.php">Seeds</a></li>
          <li><a href="#">Protection</a></li>
          <li><a href="#">Soil test</a></li>
          <li><a href="#">Crop Practices</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="main-content">
    <div class="container" id="seeds-container">
      <!-- Seeds content will be dynamically added here -->
      <?php
            // Include database connection file
            include 'db_connection.php';

            // Check if seed_id is set in the URL
            if (isset($_GET['seed_id'])) {
                $seed_id = $_GET['seed_id'];
                $query = "SELECT * FROM seed_details WHERE seed_id = $seed_id";
            } else {
                // Handle case when seed_id is not provided
                exit("Invalid request.");
            }

            // Execute the query
            $result = $conn->query($query);

            // Check if there are rows in the result set
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    // Display seed details or product cards
                    // Modify this part according to your layout
                    echo '<div class="product-card">';
                    echo '<img src="' . $row['image_url'] . '" alt="' . $row['type'] . '">';
                    echo '<h3>' . $row['type'] . '</h3>';
                    echo '<p>Weight: ' . $row['weight'] . ' kgs</p>';
                    echo '<p>Price: Rs.' . $row['price'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo 'No products available for this seed.';
            }

            // Close database connection
            $conn->close();
            ?>

    </div>
  </section>
</body>
</html>
