<?php
// Include database connection file
include './db_connection.php';

// Check if the username parameter is set
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Prepare and execute the database query to fetch user details
    $sql = "SELECT user_id, email FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
        // Check if any rows are returned
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Prepare the user details as JSON response
            $userDetails = array(
                'user_id' => $row['user_id'],
                'email' => $row['email']
            );
            echo json_encode($userDetails); // Return user details as JSON response
        } else {
            // No user details found
            echo json_encode(array('error' => 'User details not found'));
        }
    } else {
        // Error executing the query
        echo json_encode(array('error' => 'Error executing the query'));
    }
} else {
    // Username parameter not provided, check session variables if needed
    echo json_encode(array('error' => 'Username parameter not provided'));
}
?>
