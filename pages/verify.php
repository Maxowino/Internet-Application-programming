<?php
session_start();

require "../load.php"; 

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_code = $_POST['code'];

    // Check if the code matches the one sent
    if (isset($_SESSION['verification_code']) && $entered_code == $_SESSION['verification_code']) {
        $email = $_SESSION['email'];
        
        // Unset session variables
        unset($_SESSION['verification_code']);
        unset($_SESSION['email']);
        
        // Redirect to login page
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
    <style>
        /* Loading Indicator Styles */
        #loadingIndicator {
            display: none; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 1050; 
            justify-content: center;
            align-items: center;
        }
        #loadingIndicator .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>
<body class="sign">
    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="d-flex">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Verify Code</h2>
                <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
                <form id="verificationForm" method="POST" action="">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

   
    <script>
        // Show loading indicator when the verification form is submitted
        document.getElementById('verificationForm').addEventListener('submit', function() {
            document.getElementById('loadingIndicator').style.display = 'flex';
        });
    </script>
</body>
</html>
