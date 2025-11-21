<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['cvmsaid']==0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $adminid = $_SESSION['cvmsaid'];
    $AName = $_POST['adminname'];
    $mobno = $_POST['mobilenumber'];
    $email = $_POST['email'];

    $query = mysqli_query($con, "UPDATE tbladmin SET AdminName='$AName', MobileNumber='$mobno', Email='$email' WHERE ID='$adminid'");
    if ($query) {
      $msg = "Admin profile has been updated successfully.";
    } else {
      $msg = "Something went wrong. Please try again.";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LEF CVMS | Admin Profile</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome 6 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet">
<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet">

  <!-- Keep vendor CSS -->
  <link href="vendor/animsition/animsition.min.css" rel="stylesheet">
  <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">
  <link href="vendor/select2/select2.min.css" rel="stylesheet">
  <link href="css/theme.css" rel="stylesheet">

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
      font-size: 15px;
      text-align: center;
      color: #0d6efd;
      font-weight: 500;
      margin-bottom: 15px;
    }
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

          <!-- Header -->
          <div class="dashboard-header">
            <h3><i class="fa-solid fa-user-gear me-2"></i>Admin Profile</h3>
            <img src="images/lef-logo.png" alt="LEF Logo" height="50">
          </div>

          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="card p-3">
                <div class="card-header">
                  <i class="fa-solid fa-user-pen me-2 text-primary"></i> Update Admin Details
                </div>
                <div class="card-body">
                  <?php if ($msg) echo '<div class="alert-msg">'.$msg.'</div>'; ?>

                  <?php
                  $adminid = $_SESSION['cvmsaid'];
                  $ret = mysqli_query($con,"SELECT * FROM tbladmin WHERE ID='$adminid'");
                  while ($row = mysqli_fetch_array($ret)) {
                  ?>
                  <form method="post">
                    <div class="mb-3">
                      <label for="adminname" class="form-label">Admin Name</label>
                      <input type="text" id="adminname" name="adminname" value="<?php echo $row['AdminName'];?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                      <label for="email" class="form-label">Email Address</label>
                      <input type="email" id="email" name="email" value="<?php echo $row['Email'];?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                      <label for="mobilenumber" class="form-label">Phone Number</label>
                      <input type="text" id="mobilenumber" name="mobilenumber" value="<?php echo $row['MobileNumber'];?>" maxlength="10" class="form-control" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input type="text" id="username" name="username" value="<?php echo $row['UserName'];?>" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Registration Date</label>
                      <input type="text" id="adminregdate" name="adminregdate" value="<?php echo $row['AdminRegdate'];?>" class="form-control" readonly>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="submit" class="btn btn-primary">
                        <i class="fa-solid fa-check-circle me-1"></i> Update Profile
                      </button>
                    </div>
                  </form>
                  <?php } ?>
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
