<?php
// Start session
session_start();

// Include database connection file
include './db_connection.php';

// Define the $currentPage variable and set its initial value
$currentPage = basename($_SERVER['PHP_SELF']);

// Check if crop_id parameter is set
if(isset($_GET['practice_id'])) {
    $practice_id = $_GET['practice_id'];

    // Fetch crop details from crop_practices table based on the selected practice_id
    $sql = "SELECT * FROM crop_practices WHERE practice_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $practice_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are rows in the result set
    if ($result && $result->num_rows > 0) {
        // Output crop details
        $row = $result->fetch_assoc();
        echo '<div class="crop-details-card">';
        echo '<h3>' . $row['crop_name'] . '</h3>';
        echo '<img src="' . $row['image_url'] . '" alt="' . $row['crop_name'] . '">';

        // Split the description into rows based on line breaks and output each row separately
        $descriptionRows = explode("<br>", $row['crop_description']);
        foreach ($descriptionRows as $row) {
            echo '<p>' . $row . '</p>';
        }

        echo '</div>';
    } else {
        echo 'No crop details available for this crop.';
    }
    exit(); // Stop further execution
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FarmAssist</title>
  
  <style>
    /* Add your CSS styles here */
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

    /* Crop card styles */
    .crop-card {
        width: 250px; /* Set a fixed width for crop cards */
        margin: 30px; /* Adjust margin for spacing between crop cards */
     
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        cursor: pointer; /* Change cursor to pointer on hover */
        transition: transform 0.3s ease-in-out;
        background-color: #fff; /* Set background color for crop cards */
        display: inline-block; /* Display crop cards inline */
        height: 250px; /* Set a fixed height for crop cards */
        vertical-align: top; /* Align crop cards to the top of the container */
    }

    .crop-card:hover {
        transform: scale(1.05); /* Scale up on hover */
    }

    .crop-card img {
        max-width: 250px; /* Adjust image width */
        height: 200px;
    }

    .crop-card h3 {
        margin-bottom: 10px;
    }

    /* Crop details card styles */
    .crop-details-card {
        width: 80%; /* Increase card width */
        margin: 10px auto; 
        margin-top:-70px;
        /* Center the card horizontally */
        padding: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center; /* Align text to the left */
        background-color: #fff;
    }

    .crop-details-card img {
        margin-bottom: 20px; /* Add bottom margin to the image */
        width:600px; /* Make sure the image does not exceed its container */
        height: auto; /* Maintain aspect ratio */
    }

    .crop-details-card h3 {
        margin-bottom: 10px;
        font-size: 25px;
    }

    .crop-details-card p {
        font-size: 15px;
        margin-bottom: 10px;
        text-align:left;
    }
/* CSS for highlighting text within <strong> tags */
.crop-details-card strong {
    font-weight: bold;
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
    
</style>
</head>
<body>
  <header>
    <div class="container">

      <div class="profile">
        <img src="./images/profile.jpg" alt="Profile Image">
        <div class="profile-details">
          <?php 
          // Check if the user is already logged in
          if (isset($_SESSION['login_user'])) : ?>
            <span class="profile-name"><?php echo $_SESSION['login_user']; ?></span>
            <a href="./login.php">Logout</a>
          <?php else :?>
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
      <div class="container" id="crop-cards-container">
        <!-- Crop content will be dynamically added here -->
        <?php
        // Fetch crop data from the database
        $sql = "SELECT practice_id, crop_name, image_url FROM crop_practices";
        $result = $conn->query($sql);
  
        // Check if there are rows in the result set
        if ($result && $result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Link crop cards to display crop details dynamically onclick
                echo '<div class="crop-card" onclick="displayCropDetails(' . $row['practice_id'] . ')">';
                echo '<img src="' . $row['image_url'] . '" alt="' . $row['crop_name'] . '">';
                echo '<h3>' . $row['crop_name'] . '</h3>';
                echo '</div>';
            }
        } else {
            echo '<p class="no-crops-msg">No crops available.</p>';
        }
        ?>
      </div>
    </section>
  
    <div id="crop-details-container"></div>
  
    <script>
  function displayCropDetails(practiceId) {
      // Send an AJAX request to fetch crop details based on the selected practice ID
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              // Update the body with the fetched crop details
              document.body.innerHTML += this.responseText;

              // Hide all crop cards
              var cropCards = document.getElementsByClassName("crop-card");
              for (var i = 0; i < cropCards.length; i++) {
                  cropCards[i].style.display = "none";
              }
          }
      };
      xhttp.open("GET", "./crop_practices.php?practice_id=" + practiceId, true);
      xhttp.send();
  }
</script>


  
  </body>
  </html>
  