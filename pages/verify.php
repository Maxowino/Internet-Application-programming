<?php
session_start();
require "../load.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_code = $_POST['code'];

    // Check if the verification code matches
    if (isset($_SESSION['verification_code']) && $entered_code == $_SESSION['verification_code']) {
        // Retrieve the data stored in the session
        $email = $_SESSION['email'];
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $password = $_SESSION['password'];

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $conn = new dbconnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
        try {
            $connection = $conn->getConnection();

            // Check if email already exists
            $stmt = $connection->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                echo "Email already exists!";
                exit();
            }

            // Insert new user
            $stmt = $connection->prepare("INSERT INTO user (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $email, $hashed_password]);

            // Unset session variables
            unset($_SESSION['verification_code']);
            unset($_SESSION['email']);
            unset($_SESSION['first_name']);
            unset($_SESSION['last_name']);
            unset($_SESSION['password']);

            // Show success popup and redirect to login page
            echo '<script>alert("User verified successfully! You will now be redirected to the login page.");</script>';
            echo '<script>window.location.href = "login.php";</script>';
            exit();
            
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
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
                        <!-- Display error message if verification fails -->
                        <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
                        <form id="verificationForm" method="POST" action="">
                            <div class="mb-4">
                                <label class="form-label" for="code">Verification Code</label>
                                <input type="text" id="code" class="form-control" name="code" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block mb-4" id="verifyButton">Verify</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JavaScript for form handling -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
