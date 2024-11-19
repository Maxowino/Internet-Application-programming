<?php
session_start();


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: adminlogin.php");
    exit();
}

require "../load.php"; 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Create a database connection
    $conn = new dbconnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
    $connection = $conn->getConnection();

    try {
        // Delete the user from the database
        if (DBTYPE === 'PDO') {
            $stmt = $connection->prepare("DELETE FROM user WHERE id = ?");
            $stmt->execute([$user_id]);
        } elseif (DBTYPE === 'MySQLi') {
            $stmt = $connection->prepare("DELETE FROM user WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
        }

        $_SESSION['success_message'] = "User deleted successfully.";
        header("Location: adminpage.php");
        exit();
    } catch (Exception $e) {
        //  error
        $_SESSION['error_message'] = "Error deleting user: " . $e->getMessage();
        header("Location: adminpage.php");
        exit();
    }
} else {
    // If user ID is not valid
    $_SESSION['error_message'] = "Invalid user ID.";
    header("Location: adminpage.php");
    exit();
}
