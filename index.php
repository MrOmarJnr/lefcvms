<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $adminuser = $_POST['username'];
    $password = md5($_POST['password']);
    $query = mysqli_query($con, "SELECT ID FROM tbladmin WHERE UserName='$adminuser' && Password='$password'");
    $ret = mysqli_fetch_array($query);
    if ($ret > 0) {
        $_SESSION['cvmsaid'] = $ret['ID'];
        header('location:dashboard.php');
    } else {
        $msg = "Invalid Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEF CVMS Login</title>
    <link rel="icon" type="image/x-icon" href="images/favicon_io/favicon.ico">


    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet">
<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
         background: linear-gradient(135deg, #0d6efd, #f1f1f1ff);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 40px 30px;
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.7s ease;
        }

        .login-card img {
            width: 100px;
            display: block;
            margin: 0 auto 15px;
        }

        .login-card h4 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 25px;
            color: #333;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        .btn-login {
            background: #0d6efd;
            color: #fff;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #084298;
        }

        .forgot {
            text-align: right;
            display: block;
            margin-top: 10px;
            color: #0d6efd;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 15px;
            font-weight: 500;
        }

        footer {
            position: fixed;
            bottom: 10px;
            text-align: center;
            width: 100%;
            color: #fff;
            font-size: 14px;
        }

        @keyframes fadeInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>

<div class="login-card">
    <img src="images/lef-logo.png" alt="LEF Logo">

    <h4>LEF Company Visitor Management System</h4>

    <?php if ($msg) { echo '<div class="error-message">' . htmlentities($msg) . '</div>'; } ?>

    <form action="" method="post" name="login">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <button type="submit" name="login" class="btn btn-login w-100 mb-2">Sign In</button>
        <a href="forgot-password.php" class="forgot">Forgotten Password?</a>
    </form>
</div>

<footer>© <?php echo date('Y'); ?> LEF | All Rights Reserved</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
