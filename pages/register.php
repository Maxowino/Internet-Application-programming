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
    $_SESSION['verification_code'] = $verification_code; // Store it 
    $_SESSION['email'] = $email; 

    // Send verification email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();                                        // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                 // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                             // Enable SMTP authentication
        $mail->Username   = 'app036965@gmail.com';        // SMTP username
        $mail->Password   = 'qrno xmit thwa pqbr';              // Use your App Password here
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port       = 587;                              // TCP port to connect to

        // Recipients
        $mail->setFrom('application@gmail.com', 'Task App'); 
        $mail->addAddress($email);                            

        // Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Email Verification Code';
        $mail->Body    = "Your verification code is: <strong>$verification_code</strong>";
        $mail->AltBody = "Your verification code is: $verification_code"; 
        
        $mail->SMTPDebug = 0;  
        $mail->send();// Send the email

        //hashing password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $conn = new dbconnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);

        try {
            $connection = $conn->getConnection();

            // Check if email already exists
            $stmt = $connection->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                echo "Email already exists!";
                exit();
            }

            // Insert new user
            $stmt = $connection->prepare("INSERT INTO user (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $email, $hashed_password]);

            header('Location: verify.php'); // Redirect to verification page
            exit();
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }
}
?>
