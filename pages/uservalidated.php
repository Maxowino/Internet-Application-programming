<?php

require "../load.php";

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
            // Display the user's details in a table
            ?>
            <!doctype html>
                            <html lang="en">
                            <head>
                                <meta charset="utf-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1">
                                <title>User Details</title>
                                
                                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
                            </head>
                            <body>
                                <div class="container mt-5">
                                    <h1>User Details</h1>
                                    <table class="table table-striped table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>First Name</strong></td>
                                                <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Last Name</strong></td>
                                                <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email</strong></td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
                            </body>
                            </html>
                            <?php
        } else {
            // If user not found
            ?>
            <div class='container mt-5'>
                <p class='alert alert-warning'>User not found.</p>
            </div>
            <?php
        }
    } catch (Exception $e) {
        // If there is an error
        ?>
        <div class='container mt-5'>
            <p class='alert alert-danger'>Error: <?php echo $e->getMessage(); ?></p>
        </div>
        <?php
    }
} else {
    // If no user ID is provided
    ?>
    <div class='container mt-5'>
        <p class='alert alert-warning'>No user ID provided.</p>
    </div>
    <?php
}
?>
