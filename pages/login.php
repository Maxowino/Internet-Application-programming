<?php
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
            background-color: grey; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
        .eye-icon {
            cursor: pointer;
            color: black; 
        }
        .topnav{
        background-color: black;
        overflow: hidden;
        tab-size: 20%;

            }
            .topnav a{
                color:azure;
                float: left;
                display: block;
                text-decoration: none;
                text-align: left;
                padding: 14px 16px;
            }
            .topnav a:hover{
                color: whitesmoke;

            }
            .topnav-right{
                float: right;
                text-align: right;

            }
            body{
                background-color: azure;
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
                <form method="POST" action="validate.php">
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
                            <a href="#!">Forgot password?</a>
                        </div>
                    </div>
                    <!-- Register buttons and icons -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mb-4">Log in</button>
                        <p>Not yet registered? <a href="signin.php">Register</a></p>
                        <p>or Log-in with:</p>
                        <button type="button" class="btn btn-link btn-floating mx-1">
                            <i class="bi bi-facebook"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-floating mx-1">
                            <i class="bi bi-google"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-floating mx-1">
                            <i class="bi bi-github"></i>
                        </button>
                    </div>
                </form>
            </div>
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
    </script>
</body>
</html>
