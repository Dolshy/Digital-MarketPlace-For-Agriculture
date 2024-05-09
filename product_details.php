<?php
// Include database connection file
include './db_connection.php';

// Check if product_id parameter is set
if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product details from the database based on the selected product_id
    $sql = "SELECT * FROM seed_details WHERE product_id = $product_id";
    $result = $conn->query($sql);

    // Check if there are rows in the result set
    if ($result && $result->num_rows > 0) {
        // Fetch the first row since product_id should be unique
        $row = $result->fetch_assoc();

        // Encode product details along with the available quantity as JSON and output
        $productDetails = array(
            'product_id' => $row['product_id'],
            'seed_id' => $row['seed_id'],
            'product_name' => $row['product_name'],
            'weight' => $row['weight'],
            'price' => $row['price'],
            'product_type' => $row['product_type'],
            'description' => $row['description'],
            'quantity_available' => $row['quantity_available'], // Include available quantity
            'image_url' => $row['image_url']
        );

        echo json_encode($productDetails);
    } else {
        // If no product found, return an empty JSON object
        echo json_encode((object)[]); // Return an empty JSON object
    }
}
?>
