<?php
require "../load.php";

session_start();

// Check if user ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Initialize database connection
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
            // Display the user details
            ?>
            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>User Details</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    .success-message {
                        border: 2px solid #28a745;
                        background-color: #d4edda;
                        color: #155724;
                        padding: 10px;
                        border-radius: 5px;
                        margin: 20px auto;
                        text-align: center;
                        width: 50%;
                        transition: opacity 2s ease-in-out;
                    }
                </style>
                <?php if (isset($_SESSION['success_message'])): ?>
                    <script>
                        window.onload = function () {
                            const message = document.getElementById('success-message');
                            if (message) {
                                setTimeout(() => {
                                    message.style.opacity = '0';
                                }, 2000);
                                setTimeout(() => {
                                    message.remove();
                                }, 4000);
                            }
                        };
                    </script>
                <?php endif; ?>
            </head>
            <body>
            <div class="container mt-5">
                <h1 class="text-center">User Details</h1>
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="success-message" id="success-message">
                        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>
                <table class="table table-striped table-bordered mt-4">
                    <thead class="table-dark">
                        <tr>
                            <th>Field</th>
                            <th>Details</th>
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
                <div class="text-center mt-4">
                    <a href="update.php?id=<?php echo $user_id; ?>" class="btn btn-primary">Update</a>
                    <a href="login.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
            </body>
            </html>
            <?php
        } else {
            echo '<div class="container mt-5"><p class="alert alert-warning">User not found.</p></div>';
        }
    } catch (Exception $e) {
        echo '<div class="container mt-5"><p class="alert alert-danger">Error: ' . $e->getMessage() . '</p></div>';
    }
} else {
    echo '<div class="container mt-5"><p class="alert alert-warning">No user ID provided.</p></div>';
}
?>
