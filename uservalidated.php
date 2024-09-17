<?php
// Load the database connection
require "load.php";

// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Connect to the database
    $conn = new dbconnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
    $connection = $conn->getConnection();

    try {
        if (DBTYPE === 'PDO') {
            // Fetch user details using PDO
            $stmt = $connection->prepare("SELECT first_name, last_name, email FROM user WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif (DBTYPE === 'MySQLi') {
            // Fetch user details using MySQLi
            $stmt = $connection->prepare("SELECT first_name, last_name, email FROM user WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        }

        if ($user) {
            // Display the user's details
            echo "<h2>Welcome, " . htmlspecialchars($user['first_name']) . "!</h2>";
            echo "<p>First Name: " . htmlspecialchars($user['first_name']) . "</p>";
            echo "<p>Last Name: " . htmlspecialchars($user['last_name']) . "</p>";
            echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";
        } else {
            echo "User not found.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No user ID provided.";
}
?>
