<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
  $contactno = $_POST['contactno'];
  $email = $_POST['email'];

  $query = mysqli_query($con, "SELECT ID FROM tbladmin WHERE Email='$email' AND MobileNumber='$contactno'");
  $ret = mysqli_fetch_array($query);

  if ($ret > 0) {
    $_SESSION['contactno'] = $contactno;
    $_SESSION['email'] = $email;
    header('location:resetpassword.php');
  } else {
    $msg = "Invalid details. Please try again.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LEF CVMS | Forgot Password</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome 6 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet">
<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="vendor/animsition/animsition.min.css" rel="stylesheet">
  <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">
  <link href="vendor/select2/select2.min.css" rel="stylesheet">
  <link href="css/theme.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
     background: linear-gradient(135deg, #0d6efd, #f1f1f1ff);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-box {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
      padding: 40px 35px;
      width: 100%;
      max-width: 420px;
    }
    .login-header {
      text-align: center;
      margin-bottom: 25px;
    }
    .login-header img {
      height: 55px;
      margin-bottom: 10px;
    }
    .login-header h4 {
      font-weight: 600;
      font-size: 22px;
      color: #333;
    }
    .form-control {
      border-radius: 10px;
      padding: 10px 14px;
    }
    .form-control:focus {
      border-color: #6610f2;
      box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.15);
    }
    .btn-primary {
     background: linear-gradient(135deg, #0d6efd, #f1f1f1ff);
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 10px 25px;
      width: 100%;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #6610f2, #0d6efd);
    }
    .alert-msg {
      text-align: center;
      font-weight: 500;
      color: #dc3545;
      margin-bottom: 10px;
    }
    .footer-link {
      text-align: center;
      margin-top: 15px;
    }
    .footer-link a {
      color: #6610f2;
      font-weight: 500;
      text-decoration: none;
    }
    .footer-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="login-box animsition">
    <div class="login-header">
      <img src="images/lef-logo.png" alt="LEF Logo">
      <h4>LEF-CVMS Password Recovery</h4>
      <p class="text-muted mb-0">Enter your registered email and mobile number</p>
    </div>

    <?php if($msg): ?>
      <div class="alert-msg"><?php echo htmlentities($msg); ?></div>
    <?php endif; ?>

    <form action="" method="post">
      <div class="mb-3">
        <label class="form-label"><i class="fa-solid fa-envelope me-1"></i>Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
      </div>
      <div class="mb-3">
        <label class="form-label"><i class="fa-solid fa-phone me-1"></i>Mobile Number</label>
        <input type="text" name="contactno" class="form-control" placeholder="Enter your phone number" required>
      </div>

      <button type="submit" name="submit" class="btn btn-primary">
        <i class="fa-solid fa-arrow-rotate-right me-1"></i> Reset Password
      </button>
    </form>

    <div class="footer-link mt-3">
      <a href="index.php"><i class="fa-solid fa-arrow-left me-1"></i> Back to Login</a>
    </div>
  </div>

  <!-- Scripts -->
  <script src="vendor/jquery-3.2.1.min.js"></script>
  <script src="vendor/bootstrap-4.1/popper.min.js"></script>
  <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
  <script src="vendor/animsition/animsition.min.js"></script>
  <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="vendor/select2/select2.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
