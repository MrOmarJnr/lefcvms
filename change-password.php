<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['cvmsaid']==0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $adminid = $_SESSION['cvmsaid'];
    $cpassword = md5($_POST['currentpassword']);
    $newpassword = md5($_POST['newpassword']);
    $query = mysqli_query($con, "SELECT ID FROM tbladmin WHERE ID='$adminid' AND Password='$cpassword'");
    $row = mysqli_fetch_array($query);
    if ($row > 0) {
      mysqli_query($con, "UPDATE tbladmin SET Password='$newpassword' WHERE ID='$adminid'");
      $msg = "Your password has been changed successfully.";
    } else {
      $msg = "Your current password is incorrect.";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LEF CVMS | Change Password</title>

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

  <script type="text/javascript">
    function checkpass() {
      if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
        alert('New Password and Confirm Password fields do not match');
        document.changepassword.confirmpassword.focus();
        return false;
      }
      return true;
    }
  </script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f9;
    }
    .page-container { background: #f4f6f9; }
    .main-content { padding: 20px 0; }

    .dashboard-header {
     background: linear-gradient(135deg, #0d6efd, #f1f1f1ff);
      color: #fff;
      padding: 25px 30px;
      border-radius: 12px;
      margin-bottom: 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .dashboard-header h3 { font-weight: 600; margin: 0; }

    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.06);
    }
    .card-header {
      background-color: transparent;
      border-bottom: none;
      font-weight: 600;
      font-size: 18px;
      color: #333;
    }
    .form-control {
      border-radius: 10px;
      padding: 10px 14px;
    }
    .form-control:focus {
      border-color: #6610f2;
      box-shadow: 0 0 0 0.2rem rgba(102,16,242,0.15);
    }
    .btn-primary {
     background: linear-gradient(135deg, #0d6efd, #f1f1f1ff);
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 10px 25px;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #6610f2, #0d6efd);
    }
    .alert-msg {
      text-align: center;
      font-weight: 500;
      margin-bottom: 15px;
    }
    .alert-success { color: #198754; }
    .alert-danger { color: #dc3545; }
    footer {
      text-align: center;
      color: #777;
      font-size: 14px;
      margin-top: 40px;
    }
  </style>
</head>

<body class="animsition">
  <div class="page-wrapper">
    <!-- SIDEBAR -->
    <?php include_once('includes/sidebar.php');?>

    <!-- PAGE CONTAINER -->
    <div class="page-container">
      <!-- HEADER -->
      <?php include_once('includes/header.php');?>

      <!-- MAIN CONTENT -->
      <div class="main-content">
        <div class="container-fluid py-4">
          
          <!-- Page Header -->
          <div class="dashboard-header">
            <h3><i class="fa-solid fa-lock me-2"></i>Change Admin Password</h3>
            <img src="images/lef-logo.png" alt="LEF Logo" height="50">
          </div>

          <div class="row justify-content-center">
            <div class="col-lg-6">
              <div class="card p-3">
                <div class="card-header">
                  <i class="fa-solid fa-key me-2 text-primary"></i> Password Update Form
                </div>
                <div class="card-body">
                  <?php if($msg): ?>
                    <div class="alert-msg <?php echo (strpos($msg, 'wrong') !== false) ? 'alert-danger' : 'alert-success'; ?>">
                      <?php echo $msg; ?>
                    </div>
                  <?php endif; ?>

                  <form method="post" name="changepassword" onsubmit="return checkpass();">
                    <div class="mb-3">
                      <label for="currentpassword" class="form-label">Current Password</label>
                      <input type="password" id="currentpassword" name="currentpassword" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label for="newpassword" class="form-label">New Password</label>
                      <input type="password" id="newpassword" name="newpassword" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label for="confirmpassword" class="form-label">Confirm New Password</label>
                      <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" required>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="submit" class="btn btn-primary">
                        <i class="fa-solid fa-rotate me-1"></i> Change Password
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <footer>© <?php echo date('Y'); ?> LEF | All Rights Reserved</footer>
        </div>
      </div>
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
<?php } ?>
