<?php
session_start(); // Start the session to use session variables
require "../load.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Email or password not filled in.";
        header("Location: login.php"); 
        exit();
    }

    $conn = new dbconnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
    $connection = $conn->getConnection();

    try {
        if (DBTYPE === 'PDO') {
            $stmt = $connection->prepare("SELECT id, first_name, last_name, email, password FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

        } elseif (DBTYPE === 'MySQLi') {
            $stmt = $connection->prepare("SELECT id, first_name, last_name, email, password FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        }

        if ($user) {
            // Check password
            if (password_verify($password, $user['password'])) {
                $_SESSION['success_message'] = "You have logged in successfully!";
                header("Location: uservalidated.php?id=" . $user['id']);
                exit();
            } else {
                $_SESSION['error_message'] = "Invalid email or password.";
                header("Location: login.php"); // Redirect back to login page
                exit();
            }
        } else {
            $_SESSION['error_message'] = "No user found with this email.";
            header("Location: login.php"); // Redirect back to login page
            exit();
        }

    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: login.php"); // Redirect back to login page
        exit();
    }
}
?>
