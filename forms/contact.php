<?php
require_once 'DB.php';
$mysql = new mysql();

// Get the form values
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

try {
    $sql_cmd = "INSERT INTO contact_tb SET name='$name',email='$email', subject='$subject', message='$message', status=0;";
    $save_email = $mysql->query_change($sql_cmd);

    if ($save_email > 0) {
        // Display success message
        echo "OK";
    } else {
        echo "Sorry, there was a problem sending your message. Please try again";
    }
} catch (Exception $e) {
    // Display error message
    echo "Sorry, there was a problem sending your message. Please try again. $e";
}
