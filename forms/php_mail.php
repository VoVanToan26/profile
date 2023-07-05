<?php
phpinfo();

require '../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../assets/vendor/PHPMailer/src/SMTP.php';
require '../assets/vendor/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Get the form values
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

try {
    // Compose the email
    $to = 'vantoanvo26@gmail.com';
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    $body = $message;

    // Send the email using the system's sendmail command
    $success = mail($to, $subject, $body, $headers);

    if ($success) {
        // Display success message
        echo "OK";
    } else {
        // Display error message
        echo "Sorry, there was a problem sending your message. Please try again.";
    }
} catch (Exception $e) {
    // Display error message
    echo "Sorry, there was a problem sending your message. Please try again. $e";
}
