<?php

require "../load.php"; 
require '../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    // Generate a random verification code
    $verification_code = mt_rand(100000, 999999);
    $_SESSION['verification_code'] = $verification_code;
    $_SESSION['email'] = $email;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['password'] = $password; // Temporarily store the plain password (or hash it here if preferred)

    // Send verification email
    $mail = new PHPMailer(true);
    try {
        // Mail settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'app036965@gmail.com';
        $mail->Password = 'qrno xmit thwa pqbr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('application@gmail.com', 'Task App');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification Code';
        $mail->Body = "Your verification code is: <strong>$verification_code</strong>";

        $mail->send();
        header('Location: verify.php'); // Redirect to verification page
        exit();
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }
}

?>
