<?php
session_start();
require "../load.php";

$show_popup = false; // control popup 
$success_message = ""; // Initialize success message

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

        // Insert user  into the database
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

            // Set success message 
            $_SESSION['success_message'] = "User verified successfully!";
            $show_popup = true;

            
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        $error_message = "Invalid verification code. Please try again.";
    }
}

// Capture success message from session
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); 
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
        .popup {
            display: none;
            position: fixed;
            z-index: 999;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 2px solid #4CAF50;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
            border-radius: 10px;
        }

        .popup h4 {
            margin: 0;
            color: #4CAF50;
        }

        .popup p {
            margin-top: 10px;
            color: #333;
        }

        .popup button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        .popup button:hover {
            background-color: #45a049;
        }

        .backdrop {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }
    </style>
</head>
<body class="sign">
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
                        <button type="submit" class="btn btn-primary btn-block mb-4" id="verifyButton">Verify</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="backdrop"></div>
    <div id="popupMessage" class="popup" style="<?php echo $show_popup ? 'display:block;' : ''; ?>">
        <h4>Success!</h4>
        <p><?php echo $success_message; ?></p>
        <button onclick="closePopup()">OK</button>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to close the popup
        function closePopup() {
            document.getElementById('popupMessage').style.display = 'none';
            document.querySelector('.backdrop').style.display = 'none';
            // Redirect to login page
            window.location.href = "login.php";
        }

       
        window.addEventListener('load', function() {
            const popup = document.getElementById('popupMessage');
            const backdrop = document.querySelector('.backdrop');

            if (popup.style.display === 'block') {
                backdrop.style.display = 'block';
            }
        });
    </script>
</body>
</html>
