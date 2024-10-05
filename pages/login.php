<?php
session_start(); 
require "../load.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign-In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <style>
        .form-container {
            background-color: burlywood; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
        .eye-icon {
            cursor: pointer;
            color: black; 
        }
        .topnav {
            background-color: black;
            overflow: hidden;
        }
        .topnav a {
            color: azure;
            float: left;
            display: block;
            text-decoration: none;
            text-align: left;
            padding: 14px 16px;
        }
        .topnav a:hover {
            color: whitesmoke;
        }
        body {
            background-color: grey;
        }
       
        #loadingSpinner {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
           border-style: none;
           border-radius: 5px;
          
        }
    </style>
    <div class="topnav">
        <a href="../index.php">Home</a>
        <a href="../about.php">About</a>
        <a href="">Projects</a>
        <a href="">Contact</a>
    </div>
</head>
<body class="sign">
    <div class="container mt-5 form-container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Log In</h2>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error_message']; ?></div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <form id="loginForm" method="POST" action="validate.php">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email address</label>
                        <input type="email" id="email" class="form-control" name="email" required>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" class="form-control" name="password" required>
                            <span class="input-group-text eye-icon" id="togglePassword">
                                <i class="bi bi-eye-slash" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col d-flex justify-content-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                <label class="form-check-label" for="form2Example31"> Remember me </label>
                            </div>
                        </div>
                        <div class="col">
                            <span style="color:blue">Forgot Password</span>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mb-4">Log in</button>
                        <p>Not yet registered? <span id="registerText" style="color: blue; cursor: pointer; text-decoration:none;">Register</span></p>
                        <p>or Log-in with:</p>
                        <button type="button" class="btn btn-link btn-floating mx-1" style="color: black;">
                            <i class="bi bi-facebook"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-floating mx-1" style="color: black;">
                            <i class="bi bi-google"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-floating mx-1" style="color: black;">
                            <i class="bi bi-github"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="loadingSpinner" class="text-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });

       
        const loginForm = document.getElementById('loginForm');
        const loadingSpinner = document.getElementById('loadingSpinner');

        loginForm.addEventListener('submit', function () {
            loadingSpinner.style.display = 'block'; 
        });
    const registerText = document.getElementById('registerText');
    registerText.addEventListener('click', function() {
        window.location.href = 'signin.php'; 
    });
        
    </script>
</body>
</html>
