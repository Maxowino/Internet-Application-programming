<?php
session_start();

// Include database connection
require "../load.php"; // Adjust the path as necessary

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_code = $_POST['code'];

    // Check if the code matches the one sent
    if (isset($_SESSION['verification_code']) && $entered_code == $_SESSION['verification_code']) {
        $email = $_SESSION['email'];

        // Here, you would complete the user registration in the database
        echo "Registration successful! You can now log in.";
        // Unset session variables
        unset($_SESSION['verification_code']);
        unset($_SESSION['email']);
        
        // Optionally redirect to login page
        header('Location: login.php');
        exit();
    } else {
        $error_message = "Invalid verification code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="sign">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Verify Code</h2>
                <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
                <form method="POST" action="">
                    <!-- Verification code input -->
                    <div class="mb-4">
                        <label class="form-label" for="code">Verification Code</label>
                        <input type="text" id="code" class="form-control" name="code" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mb-4">Verify</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
