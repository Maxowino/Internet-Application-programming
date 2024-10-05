<?php

?>
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign-Up and Display</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-container {
            background-color: burlywood; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 10 10 10px rgba(0, 0, 0, 0.1); 
        }
        .eye-icon {
            cursor: pointer;
            color: black; 
        }
        body{
            background-color: azure;
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
                background-color: grey;
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
                <h2 class="text-center">Sign-Up Form</h2>
                <form id="signupForm" method="POST" action="register.php">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
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
                    <div class="text-center">
                        <p>Already have an account?<span id="loginText" style="color: blue; cursor: pointer; text-decoration:none;">Login</span></p>
                        <button type="submit" class="btn btn-primary">Sign Up</button>
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
        const loginTextText = document.getElementById('loginText');
    loginText.addEventListener('click', function() {
        window.location.href = 'login.php'; 
    });
        
    </script>
</body>
</html>
        
            <?
    
            