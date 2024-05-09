<?php
// Start session
session_start();

// Include database connection file
include 'db_connection.php';

// Define the $currentPage variable and set its initial value
$currentPage = basename($_SERVER['PHP_SELF']);


// Check if the category parameter is set
if(isset($_GET['category'])) {
    $category = $_GET['category'];

    // Determine the table based on the category
    $table = ($category === 'fertilizers') ? 'fertilizers' : 'pesticides';

    // Fetch products based on the category
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    // Check if there are rows in the result set
    if ($result && $result->num_rows > 0) {
        // Output product cards
        while ($row = $result->fetch_assoc()) {
            // Display each product as a card with a click event to fetch details
            echo '<div class="product" data-product-id="' . $row['product_id'] . '" data-category="' . $category . '">';
            echo '<img src="' . $row['image_url'] . '" alt="' . $row['product_name'] . '">';
            echo '<div class="product-content">';
            echo '<h3>' . $row['product_name'] . '</h3>';
            echo '<p>Weight: ' . $row['weight'] . '</p>';
            echo '<p>Price: Rs. <span class="price">' . $row['price'] . '</span></p>'; // Modified to include price span
            echo '</div>'; // Close product-content
            echo '</div>'; // Close product

            // Display the output text in a container
            echo '<div class="output-container" style="display:none">';
            echo '<div>';
            echo '<img src="' . $row['image_url'] . '" alt="' . $row['product_name'] . '" style="display: block; margin: 0 auto;">'; // Add image with centering styles
            echo '<p><strong>Product Name:</strong> ' . $row['product_name'] . '</p>';
            echo '<p><strong>Weight:</strong> ' . $row['weight'] . '</p>';
            echo '<p><strong>Price:</strong> Rs. <span class="price">' . $row['price'] . '</span>/-</p>'; // Modified to include price span
            echo '<p><strong>Description:</strong> ' . nl2br($row['description']) . '</p>';
            echo '<div class="quantity-container">';
            echo '<label for="quantity' . $row['product_id'] . '">Quantity:</label>';
            echo '<input type="number" id="quantity' . $row['product_id'] . '" class="quantity-input" value="1" min="1">';
            echo '</div>';
            echo '<div class="total-price" id="total-price' . $row['product_id'] . '">Total Price: <span class="total-price-value">' . $row['price'] . '</span></div>'; // Close the PHP block and concatenate the variable
            echo '</div>';
            echo' <p id="note" style="color: red;">Note :To Place Order after opening WhatsApp, press Ctrl+V to paste the product details.</p>';
            // Buy button
            echo '<button class="btn whatsapp" onclick="whatsappAdmin(' . $row['product_id'] . ', \'' . $category . '\')">WhatsApp</button>';

            echo '</div>';
        }
    } else {
        echo 'No products available for this category.';
    }
    exit(); // Stop further execution
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seed Products - FarmAssist</title>
<style>
/* General styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('./images/seeds.png');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    height: auto;
}

.active {
    font-weight: bold;
    color: #ffa500; /* Change color as needed */
}

.container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 20px;
}

header {
    color: white;
    padding: 20px 0;
    position: relative;
}

header h1 {
    margin: 0;
    font-size: 20px;
}

.profile {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: 20px;
    display: flex;
    align-items: center;
}

.profile img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-right: 10px;
}

.profile-details {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    color: white;
}

.profile-details a {
    color: white;
    text-decoration: none;
}

.profile-details a:hover {
    text-decoration: underline;
    color: #ffa500;
}

nav ul {
    list-style-type: none;
    margin-top: 20px;
    padding: 0;
    display: flex;
}

nav ul li {
    padding-right: 20px;
}

nav ul li a {
    text-decoration: none;
    color: white;
}

nav ul li a:hover {
    text-decoration: underline;
    color: #ffa500;
}

nav ul li a.active {
    color: #ffa500;
}

.main-content {
    padding: 20px 0;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}

.card {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 20px;
    margin: 25px;
    width: 400px;
    height: 300px;
    margin-top: 50px;
    background-color: #fff;
    display: inline-block;
    vertical-align: top;
    justify-content: center;
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.card img {
    height: 250px;
    width: 300px;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    margin: 20px;
    width: 250px;
    height: 350px; /* Adjust height for uniform size */
    background-color: #f9f9f9;
    display: inline-block;
    vertical-align: top;
    justify-content: center;
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.product:hover {
    transform: scale(1.05);
}

.product img {
    width: 70%; /* Ensure image fills the container */
    height: 150px; /* Maintain aspect ratio */
    margin-left: 30px;
    /* Add transition effect */
}

.output-container {
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 20px;
    padding: 20px;
    display: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.output-container img {
    display: block;
    margin: 0 auto;
    width: 400px;
    height: auto;
}

.output-container p {
    margin-bottom: 10px;
}

.output-container p strong {
    font-weight: bold;
}

.output-container p:last-child {
    margin-bottom: 0;
}

/* Style for quantity input */
.quantity-container {
    margin-top: 10px;
}

.quantity-container label {
    font-weight: bold;
    margin-right: 5px;
}

.quantity-input {
    width: 60px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Style for total price */
.total-price {
    margin-top: 10px;
    font-weight: bold;
    color: #ff7f00;
    font-size:25px;
    margin-top:20px;
}

.product-title {
    font-size: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ffa500;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #ff7f00;
}

/* Style for Add to Cart and Buy buttons */
.btn{
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width:200px;
    margin-left:530px;
}

.btn.buy:hover {
    background-color: green; /* Darker green */
    color:white;
}

</style>
</head>
<body>
<header>
    <div class="container">
    
        <div class="profile">
            <img src="./images/profile.jpg" alt="Profile Image">
            <div class="profile-details">
                <!-- Include login/logout link based on session -->
                <?php
                if (isset($_SESSION['login_user'])) {
                    echo '<span class="profile-name">' . $_SESSION['login_user'] . '</span>';
                    echo '<a href="./login.php">Logout</a>';
                } else {
                    echo '<a href="./login.php">Login</a>';
                }
                ?>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="./agri.php" <?php if(basename($_SERVER['PHP_SELF']) == 'agri.php') echo 'class="active"'; ?>>Home</a></li>
                <li><a href="./seeds.php" <?php if(basename($_SERVER['PHP_SELF']) == 'seeds.php') echo 'class="active"'; ?>>Seeds</a></li>
                <li><a href="./protection.php" <?php if(basename($_SERVER['PHP_SELF']) == 'protection.php') echo 'class="active"'; ?>>Protection</a></li>
                <li><a href="./crop_practices.php"<?php if ($currentPage == 'crop_practices.php') echo 'class="active"'; ?>>Crop Practices</a></li>
                <li><a href="./myorders.php"<?php if ($currentPage == 'myorders.php') echo 'class="active"'; ?>>MyOrders</a></li>
                <li><a href="./contact.php"<?php if ($currentPage == 'contact.php') echo 'class="active"'; ?>>Contact Us</a></li>
            </ul>
        </nav>
    </div>
</header>
<section class="main-content">
    <div class="container">
        <div class="card" id="fertilizers">
            <img src="./images/fertilizers.jpg" alt="Fertilizers Image">
            <div class="product-title">Fertilizers</div>
        </div>
        <div class="card" id="pesticides">
            <img src="./images/pesticides.jpg" alt="Pesticides Image">
            <div class="product-title">Pesticides</div>
        </div>
        <div id="product-list"></div>
        <!-- Add product-details container here -->
        <div class="product-details-container"></div>
    </div>
</section>

<script>
document.getElementById("fertilizers").addEventListener("click", function() {
    fetchProducts('fertilizers');
    // Hide category cards
    document.getElementById("fertilizers").style.display = "none";
    document.getElementById("pesticides").style.display = "none";
});

document.getElementById("pesticides").addEventListener("click", function() {
    fetchProducts('pesticides');
    // Hide category cards
    document.getElementById("fertilizers").style.display = "none";
    document.getElementById("pesticides").style.display = "none";
});

function fetchProducts(category) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("product-list").innerHTML = this.responseText;
            assignProductClickListeners(); // Assign click listeners to product cards
        }
    };
    xhttp.open("GET", "protection.php?category=" + category, true);
    xhttp.send();
}

function assignProductClickListeners() {
    var products = document.querySelectorAll(".product");
    products.forEach(function(product) {
        product.addEventListener("click", function() {
            // Hide all product cards
            products.forEach(function(prod) {
                prod.style.display = "none";
            });

            // Show the corresponding output container
            var outputContainer = this.nextElementSibling;
            outputContainer.style.display = "block";

            // Extract price value and parse it as float
            var priceString = outputContainer.querySelector(".price").textContent;
            var price = parseFloat(priceString.split('.')[1]); // Assuming price format is "Rs.660/-"

            // Add event listener to quantity input
            var productId = this.dataset.productId;
            var quantityInput = outputContainer.querySelector("#quantity" + productId);
            quantityInput.addEventListener("input", function() {
                var quantity = parseInt(this.value);
                var totalPrice = price * quantity;
                outputContainer.querySelector("#total-price" + productId + " .total-price-value").textContent = "Rs." + totalPrice.toFixed(2) + "/-";
            });
        });
    });
}
function whatsappAdmin(productId, productType) {
    // Replace 'admin_whatsapp_number' with the actual admin WhatsApp number
    var adminPhoneNumber = "+918919933106"; // Add the country code with a plus sign

    // Retrieve product details and quantity
    var productDetailsContainer = document.querySelector('.product[data-product-id="' + productId + '"] + .output-container');
    var productName = productDetailsContainer.querySelector('p:nth-child(2)').innerText.replace("Product Name: ", "").trim();
    var weight = productDetailsContainer.querySelector('p:nth-child(3)').innerText.replace("Weight: ", "").trim();
    var totalPrice = productDetailsContainer.querySelector('.total-price-value').innerText.trim(); // Get total price from the total-price element
    var quantity = productDetailsContainer.querySelector('.quantity-input').value.trim(); // Get the selected quantity

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
        "Product ID: " + productId + "\n" +
        "Product Type: " + productType + "\n\n"+
        "User Details:\n" +
        "User ID: " + userId + "\n" +
        "Username: " + userName + "\n" +
        "Email: " + userEmail;

    // Copy product details to clipboard
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
    window.location.href = "https://wa.me/" + "+918919933106" + "?text=" + encodeURIComponent(productDetails);

}
    };
    xhr.open("GET", "get_user_details.php?username=" + userName, true);
    xhr.send();
}



</script>

</body>
</html>
