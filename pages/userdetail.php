<?php
// Load the database connection and constants
require "load.php";

// Get the user ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];
} else {
    echo "Invalid User ID!";
    exit();
}

// Use connection to get  user data
$conn = new dbconnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
$connection = $conn->getConnection();

try {
    if (DBTYPE === 'PDO') {
        
        $stmt = $connection->prepare("SELECT first_name, last_name, email FROM user WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif (DBTYPE === 'MySQLi') {
        
        $stmt = $connection->prepare("SELECT first_name, last_name, email FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    }

    // Check if user data was found
    if ($user) {
        // Display the user's details
        echo "<h1>User Details</h1>";
        echo "<p><strong>First Name:</strong> " . htmlspecialchars($user['first_name']) . "</p>";
        echo "<p><strong>Last Name:</strong> " . htmlspecialchars($user['last_name']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
    } else {
        echo "User not found.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
