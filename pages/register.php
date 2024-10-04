<?php
// Load the database connection and constants
require "../load.php"; 
require '../vendor/autoload.php'; // Include PHPMailer's autoloader

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

    // Hash the password
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

        // Generate a random verification code
        $verification_code = mt_rand(100000, 999999);
        $_SESSION['verification_code'] = $verification_code; // Store it in session
        $_SESSION['email'] = $email; // Store email for later use

        // Send verification email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();                                        // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                 // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                             // Enable SMTP authentication
            $mail->Username   = 'mxwellowino27@gmail.com';        // SMTP username
            $mail->Password   = 'your-app-password';              // Use your App Password here
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
            $mail->Port       = 587;                              // TCP port to connect to

            // Recipients
            $mail->setFrom('mxwellowino27@gmail.com', 'Your Name'); // Update sender name as appropriate
            $mail->addAddress($email);                            // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Email Verification Code';
            $mail->Body    = "Your verification code is: <strong>$verification_code</strong>";
            $mail->AltBody = "Your verification code is: $verification_code"; // For non-HTML mail clients
            
            $mail->SMTPDebug = 2;  // Set to 0 to disable debugging, or 2 for verbose output
            $mail->send();                                        // Send the email
            header('Location: verify.php');                       // Redirect to verification page
            exit();
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
