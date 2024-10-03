<?php

require "../load.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        echo "Email or password not filled in.";
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

        // Debugging user data
        if ($user) {
            echo "User found: " . print_r($user, true); // Debugging
        } else {
            echo "No user found with this email.";
            exit();
        }

        // Check password
        if (password_verify($password, $user['password'])) {
            echo "Password verified successfully"; // Debugging
            header("Location: uservalidated.php?id=" . $user['id']);
            exit();
        } else {
            echo "Password entered: " . $password . "<br>";
            echo "Stored hash: " . $user['password'] . "<br>";
            echo "Invalid email or password.";
        }

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
