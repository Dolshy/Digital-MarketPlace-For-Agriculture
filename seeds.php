<?php
// Start session
session_start();

// Include database connection file
include 'db_connection.php';

// Define the $currentPage variable and set its initial value
$currentPage = basename($_SERVER['PHP_SELF']);

// Check if seed_id parameter is set
if (isset($_GET['seed_id'])) {
    $seed_id = $_GET['seed_id'];

    // Fetch product cards from seed_details table based on the selected seed_id
    $sql = "SELECT * FROM seed_details WHERE seed_id = $seed_id";
    $result = $conn->query($sql);

    // Check if there are rows in the result set
    if ($result && $result->num_rows > 0) {
        // Output product cards
        while ($row = $result->fetch_assoc()) {
            // Add the data-product-id attribute to each product card
            echo '<div class="product-card" data-product-id="' . $row['product_id'] . '" data-seed-id="' . $row['seed_id'] . '">';
            echo '<img src="' . $row['image_url'] . '" alt="' . $row['product_name'] . '" style="max-width: 100px;">';
            echo '<h3>' . $row['product_name'] . '</h3>';
            echo '<p>Weight: ' . $row['weight'] . '</p>';
            echo '<p>Price: ' . $row['price'] . '</p>';
            echo '</div>';
        }
    } else {
        echo 'No products available for this seed.';
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

    /* Seed card styles */
    .seed-card {
        width: 200px; /* Set a fixed width for seed cards */
        margin: 30px; /* Adjust margin for spacing between seed cards */
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        cursor: pointer; /* Change cursor to pointer on hover */
        transition: transform 0.3s ease-in-out;
        background-color: #fff; /* Set background color for seed cards */
        opacity: 0; /* Initially set opacity to 0 */
        animation: fadeIn 0.5s ease forwards; /* Apply fade-in animation */
        display: inline-block; /* Display seed cards inline */
        height: 300px; /* Set a fixed height for seed cards */
        vertical-align: top; /* Align seed cards to the top of the container */
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .seed-card:hover {
        transform: scale(1.05); /* Scale up on hover */
    }

    .seed-card img {
        max-width: 150px; /* Adjust image width */
        height: auto;
    }

    .seed-card h3 {
        margin-bottom: 10px;
    }

    .seed-card p {
        font-size: 14px;
    }

    /* Product card styles */
    .product-card {
        width: calc(25% - 40px); /* 25% of the container width minus margins */
        margin: 30px 20px; /* Adjust margin for spacing between product cards */
        padding: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        cursor: pointer; /* Change cursor to pointer on hover */
        transition: transform 0.3s ease-in-out;
        background-color: #fff; /* Set background color for product cards */
        display: inline-block; /* Display product cards inline */
        height: 350px;
        vertical-align: top;
    }

    .product-card:hover {
        transform: scale(1.05); /* Scale up on hover */
    }

    .product-card img {
        max-width: 500px; /* Increase the max-width of the image */
        height: auto; /* Maintain aspect ratio */
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

    .no-products-msg {
        color: white;
    }

    /* Product details card styles */
    .product-details-card {
        width: 60%; /* Increase card width */
        margin: 10px auto; /* Center the card horizontally */
        padding: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: left; /* Align text to the left */
        background-color: #fff;
        display: flex; /* Use flexbox for alignment */
        justify-content: flex-start; /* Align items to the start (left) */
        align-items: flex-start; /* Align items to the start (top) */
        flex-direction: column;
        margin-top: -100px; /* Arrange items vertically */
    }

    .product-details-card img {
        margin: 0 auto 20px; /* Center align the image and add bottom margin */
        display: block; /* Ensure the image is displayed as a block element */
        max-width: 600px; /* Adjust max-width of the image */
        height: 350px; /* Maintain aspect ratio */
    }

    .product-details-card h3 {
        margin-bottom: 10px;
        font-size: 25px;
    }

    .product-details-card p {
        font-size: 15px;
        margin-bottom: 10px;
        margin-top: 10px;
    }

    /* Add to Cart and Buy button styles */
    .button-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .button-conatiner:hover {
        background-color: #45a049; /* Darker green */
    }

    #total-price {
        font-size: 25px; /* Adjust the font size as needed */
    }

    .whatsapp-button {
      background-color: #25d366; /* WhatsApp green */
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-left:400px;
  }
  #note{

      font-size:20px;
  }

  .whatsapp-button:hover {
      background-color: #128c7e; /* Darker green */
  }

  .whatsapp-icon {
      width: 20px;
      margin-right: 5px;
      vertical-align: middle;
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
    <div class="container" id="product-cards-container">
      <!-- Seeds content will be dynamically added here -->
      <?php
      // Fetch seed data from the database
      $sql = "SELECT seed_id, seed_name, image_url FROM seeds";
      $result = $conn->query($sql);

      // Check if there are rows in the result set
      if ($result && $result->num_rows > 0) {
          // Output data of each row
          while ($row = $result->fetch_assoc()) {
              // Link seed cards to display product cards dynamically onclick
              echo '<div class="seed-card" onclick="displayProductCards(' . $row['seed_id'] . ')">';
              echo '<img src="' . $row['image_url'] . '" alt="' . $row['seed_name'] . '">';
              echo '<h3>' . $row['seed_name'] . '</h3>';
              echo '</div>';
          }
      } else {
          echo 'No seeds available.';
      }
      ?>
    </div>
  </section>

  <div id="product-details-container"></div>

  <script>
    function displayProductCards(seedId) {
      // Send an AJAX request to fetch product cards based on the selected seed ID
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Update the product-cards-container with the fetched product cards
          document.getElementById("product-cards-container").innerHTML = this.responseText;
          // Attach event listeners to the newly added product cards
          attachEventListenersToProductCards();
        }
      };
      xhttp.open("GET", "seeds.php?seed_id=" + seedId, true); // Change the URL to the current page
      xhttp.send();
    }

    
    function calculateTotalPrice() {
      var quantity = parseInt(document.getElementById("quantity").value);
      console.log("Quantity:", quantity);

      var priceText = document.querySelector('.product-details-card p:nth-child(4)').innerText;
      console.log("Price Text:", priceText);

      var pricePattern = /Rs\.\s*(\d+)\//; // Matches "Rs.", followed by digits, before "/"
      var priceMatch = priceText.match(pricePattern);
      console.log("Price Match:", priceMatch);

      if (priceMatch) {
        var price = parseFloat(priceMatch[1]);
        console.log("Price:", price);

        var totalPrice = price * quantity;
        console.log("Total Price:", totalPrice);

        document.getElementById("total-price").innerText = "Total Price: Rs." + totalPrice.toFixed(2);
      } else {
        console.error("Price extraction failed. Price pattern not matched.");
      }
    }

    function attachEventListenersToProductCards() {
      var productCards = document.querySelectorAll('.product-card');
      productCards.forEach(function(card) {
        card.addEventListener('click', function() {
          var productId = this.getAttribute('data-product-id');
          var seedId = this.getAttribute('data-seed-id'); // Add this line to retrieve seed ID
          showProductDetails(productId);
        });
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Attach event listeners to product cards on page load
      attachEventListenersToProductCards();
    });
    
    function showProductDetails(productId) {
    // Send an AJAX request to fetch product details based on the selected product ID
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var productDetailsContainer = document.getElementById("product-details-container");
            // Parse the JSON response to extract product details
            var productDetails = JSON.parse(this.responseText);
            
            // Retrieve product_id and product_type from seed_details table
            var seedId = productDetails.seed_id;
            var productType = productDetails.product_type;
            var quantityAvailable = productDetails.quantity_available; // Retrieve available quantity
            
            // Create a new card to display product details
            var productDetailsCard = document.createElement("div");
            productDetailsCard.classList.add("product-details-card");
            
            // Populate the card with product details
            productDetailsCard.innerHTML = `
                <img src="${productDetails.image_url}" alt="${productDetails.product_name}" style="max-width: 200px;">
                <h3>${productDetails.product_name}</h3>
                <p><strong>Weight: </strong>${productDetails.weight}</p>
                <p><strong>Price: </strong>${productDetails.price}</p>
                <p><strong>Description: </strong>${productDetails.description}</p>
                <label for="quantity"><strong>Quantity:  </strong><input type="number" id="quantity" name="quantity" min="1" max="${quantityAvailable}" value="1" oninput="calculateTotalPrice()"></label>
                <p id="total-price"><strong>Total Price: </strong>${productDetails.price}</p>
                
                <p id="note" style="color: red; font-size:15px;">Note :To Place Order after opening WhatsApp, press Ctrl+V to paste the product details.</p>
                <!-- Add to Cart and Buy buttons -->
                <div class="button-container">
                    <button class="whatsapp-button" onclick="whatsappAdmin(${seedId}, '${productType}')">WhatsApp</button>
                </div>
            `;
            
            // Clear the product-cards-container before appending the new card
            document.getElementById("product-cards-container").innerHTML = '';
            // Append the new card to the product-cards-container
            productDetailsContainer.appendChild(productDetailsCard);
        }
    };
    xhttp.open("GET", "product_details.php?product_id=" + productId, true);
    xhttp.send();
}


function whatsappAdmin(seedId, productType) {
    // Replace 'admin_whatsapp_number' with the actual admin WhatsApp number
    var adminPhoneNumber = "+918919933106"; // Add the country code with a plus sign

    // Retrieve product details and quantity
    var productDetailsContainer = document.querySelector('.product-details-card');
    var productName = productDetailsContainer.querySelector('h3').innerText;
    var weight = productDetailsContainer.querySelector('p:nth-child(3)').innerText;
    var totalPrice = document.getElementById("total-price").innerText; // Get total price from the total-price element
    var quantity = document.getElementById("quantity").value.trim(); // Get the selected quantity

    // Fetch user details using AJAX
    var userName = "<?php echo isset($_SESSION['login_user']) ? $_SESSION['login_user'] : ''; ?>";
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var userDetails = JSON.parse(this.responseText);
            var userId = userDetails.user_id;
            var userEmail = userDetails.email;

            // Construct the product details text
            var productDetails = "Order Received!\n\n" +
                "Product Name: " + productName + "\n" +
                "Weight: " + weight + "\n" +
                "Total Price: " + totalPrice + "\n" +
                "Quantity: " + quantity + "\n" +
                "Product ID: " + seedId + "\n" +
                "Product Type: " + productType + "\n\n" +
                "User Details:\n" +
                "User ID: " + userId + "\n" +
                "Username: " + userName + "\n" +
                "Email: " + userEmail;


                var dummyTextarea = document.createElement("textarea");
    dummyTextarea.value = productDetails;
    dummyTextarea.setAttribute("readonly", "");
    dummyTextarea.style.position = "absolute";
    dummyTextarea.style.left = "-9999px";
    document.body.appendChild(dummyTextarea);
    dummyTextarea.select();
    document.execCommand("copy");
    document.body.removeChild(dummyTextarea);
            // Open WhatsApp with admin's number and modified product details
            window.location.href = "https://wa.me/" + adminPhoneNumber + "?text=" + encodeURIComponent(productDetails);
        }
    };
    xhr.open("GET", "get_user_details.php?username=" + userName, true);
    xhr.send();
}





  </script>
</body>
</html>

