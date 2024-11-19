<?php
require "../load.php";
session_start();

// Database connection
$conn = new dbconnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
$connection = $conn->getConnection();

try {
    if (DBTYPE === 'PDO') {
        $stmt = $connection->prepare("SELECT id, first_name, last_name, email FROM user");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$users) {
            $users = []; // Ensure $users is always an array
        }
    } elseif (DBTYPE === 'MySQLi') {
        $stmt = $connection->prepare("SELECT id, first_name, last_name, email FROM user");
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $users = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("MySQLi prepare failed: " . $connection->error);
        }
    }
} catch (Exception $e) {
    die("Error fetching users: " . $e->getMessage());
}

// Handle delete 
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    try {
        if (DBTYPE === 'PDO') {
            $stmt = $connection->prepare("DELETE FROM user WHERE id = ?");
            $stmt->execute([$delete_id]);
        } elseif (DBTYPE === 'MySQLi') {
            $stmt = $connection->prepare("DELETE FROM user WHERE id = ?");
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();
        }

        $_SESSION['success_message'] = "User deleted successfully!";
        header("Location: adminpage.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error deleting user: " . $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .success-message, .error-message {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            margin: 20px auto;
        }

        .success-message {
            border: 2px solid #28a745;
            background-color: #d4edda;
            color: #155724;
        }

        .error-message {
            border: 2px solid #dc3545;
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Admin Page</h1>

    <!-- Success/Failure Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="error-message">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <!-- Users Table -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <a href="update.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="adminpage.php?delete_id=<?php echo htmlspecialchars($user['id']); ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No users found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="adminlogin.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
