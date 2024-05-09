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

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve user information
    $stmt = $conn->prepare("SELECT user_name, password FROM users WHERE user_name = ?");
    $stmt->bind_param("s", $username);

    // Execute the prepared statement
    $stmt->execute();

    // Store the result
    $stmt->store_result();

    // Check if the user exists in the database
    if ($stmt->num_rows >= 1) {
        // Bind the result variables
        $stmt->bind_result($db_username, $db_password);

        // Fetch the result
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $db_password)) {
            // Password is correct, set session variables
            $_SESSION['login_user'] = $username;

            // Redirect to welcome page
            header("location: ./agri.php");
            exit(); // Ensure that no further code is executed after redirection
        } else {
            // Password is incorrect
            $error = "Invalid username or password";
        }
    } else {
        // User does not exist
        $error = "Invalid username or password";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('./images/background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
            width: 400px;
            margin-top: 50px;
        }



        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-top: 0;
        }

        input[type="text"],
        input[type="password"] {
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

        .error-msg {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

        p {
            margin-top: 20px;
        }

        a {
            color: violet;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        a:hover {
            text-decoration: underline;
            color: purple; /* Changed color on hover to purple */
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="form-container">
            <h2></h2>
            <p>Welcome to Login Page.</p>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="submit" value="Login">
                <p class="error-msg"><?php echo $error; ?></p>
            </form>
            <p>Not registered yet? <a href="./register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
