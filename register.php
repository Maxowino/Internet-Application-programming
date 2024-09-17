<?php
// Load the database connection and constants
require "load.php";


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

    

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $conn = new dbconnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);

    try {
        
        $connection = $conn->getConnection();

        if (DBTYPE === 'PDO') {
            
            $stmt = $connection->prepare("INSERT INTO user (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $email, $hashed_password]);
            // $user_id = $connection->lastInsertId();

        } elseif (DBTYPE === 'MySQLi') {
            
            $stmt = $connection->prepare("INSERT INTO user (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);
            $stmt->execute();

            
            $user_id = $connection->insert_id;
        }

        
        header("Location: userdetail.php?id=" . $user_id);
        exit();

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
