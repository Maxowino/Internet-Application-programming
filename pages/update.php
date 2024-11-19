<?php
// Load database connection and constants
require "../load.php";

// Check if user ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid User ID!";
    exit();
}

$user_id = $_GET['id'];

// Initialize database connection
$conn = new dbconnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
$connection = $conn->getConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    try {
        if (DBTYPE === 'PDO') {
            $stmt = $connection->prepare("UPDATE user SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
            $stmt->execute([$first_name, $last_name, $email, $user_id]);
        } elseif (DBTYPE === 'MySQLi') {
            $stmt = $connection->prepare("UPDATE user SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
            $stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
            $stmt->execute();
        }

        $_SESSION['success_message'] = "User details updated successfully!";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// Fetch current user details
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

    if (!$user) {
        echo "User not found!";
        exit();
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .form-control {
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            text-align:center;
            margin-right: 200px;
        }

        .success-message {
            border: 2px solid #28a745;
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin: 20px auto;
            text-align: center;
            width: 50%; /* Adjust width to match the pop-up */
            transition: opacity 2s ease-in-out; /* Optional: for fade-out effect */
        }

        h1 {
            margin-bottom: 20px;
        }
    </style>

    <script>
        window.onload = function () {
            const message = document.getElementById('success-message');
            if (message) {
                setTimeout(() => {
                    message.style.opacity = '0';  // Fade out the message
                }, 2000);  // Wait 2 seconds before starting fade-out
                setTimeout(() => {
                    message.remove();  // Remove it completely after 4 seconds
                }, 4000);
            }
        };
    </script>

</head>
<body>
<div class="container mt-5">
    <h1 style="text-align: center; color:blue;">Update User Details</h1>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message" id="success-message">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']);
            ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" 
                   value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" 
                   value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
       <div class="text-center" >
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="uservalidated.php?id=<?php echo $user_id; ?>" class="btn btn-secondary">Back</a>
       </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
