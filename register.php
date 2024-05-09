<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Include database connection
include('./db_connection.php');

// Initialize variables
$error = "";
$registration_success_message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];

    // Check if the username already exists
    $stmt_check = $conn->prepare("SELECT user_name FROM users WHERE user_name = ?");
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // Username already exists, show error message
        $error = "Username already exists. Please choose a different username.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO users (user_name, password, email, phonenumber) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $phone_number);

        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful, set success message
            $registration_success_message = "Registration successful!";
        } else {
            // Registration failed
            $error = "Registration failed. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }

    // Close statement and connection
    $stmt_check->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image:url('./images/background.jpg');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
        }

        .container {
            width: 400px;
            background-color: #fff;
            padding: 30px;
            margin-top:50px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .container h2 {
            margin-top: 0;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-msg{
            color: red;
            margin-top: 10px;
            text-align: center;
        }
        .success-msg {
            color: #4caf50;
            margin-top: 10px;
            text-align: center;
        }

        p {
            margin-top: 20px;
        }

        a {
            color: violet; /* Changed color to violet */
            text-decoration: none;
            transition: color 0.3s ease; /* Added transition for smooth color change */
        }

        a:hover {
            text-decoration: underline;
            color: purple; /* Changed color on hover to purple */
        }
        

    </style>
</head>
<body>
    <div class="container">
        <h2></h2>
        <p>Welcome to  Registration Page.</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" id="password" placeholder="Password" required><br>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required><br>
            <input type="text" name="phone" placeholder="Phone Number" pattern="[6-9]{1}[0-9]{9}" title="Please enter a valid 10-digit phone number starting with 6,7,8, or 9" required><br>
            <input type="submit" value="Register">
            <p class="error-msg"><?php echo $error; ?></p>
            <p class="success-msg"><?php echo $registration_success_message; ?></p>
        </form>
        <p>Already registered? <a href="./login.php">Login here</a></p>
    </div>
</body>
</html>
