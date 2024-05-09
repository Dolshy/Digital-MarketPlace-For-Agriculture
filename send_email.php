<?php
// Retrieve form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $subject = $_POST['subject'];

    // Recipient email address
    $to = "dolshypenumaka2003@gmail.com"; // Change this to your email address

    // Set the "From" header
    $headers = "From: " . $email . "\r\n";

    // Add additional headers as needed
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain; charset=utf-8\r\n";

    // Attempt to send the email
    if (mail($to, $subject, $message, $headers)) {
        echo "Email Sent";
    } else {
        echo "Email sending failed";
    }
}
?>
