<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['cvmsaid']==0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $cvmsaid = $_SESSION['cvmsaid'];
    $fullname = $_POST['fullname'];
    $mobnumber = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $add = $_POST['address'];
    $whomtomeet = $_POST['whomtomeet'];
    $department = $_POST['department'];
    $reasontomeet = $_POST['reasontomeet'];

    $query = mysqli_query($con, "INSERT INTO tblvisitor (FullName, Email, MobileNumber, Address, WhomtoMeet, Deptartment, ReasontoMeet)
                                VALUES ('$fullname', '$email', '$mobnumber', '$add', '$whomtomeet', '$department', '$reasontomeet')");
    if ($query) {
      echo "<script>alert('Visitor details added successfully');</script>";
      echo "<script>window.location.href = 'visitors-form.php'</script>";
    } else {
      echo "<script>alert('Something went wrong. Please try again');</script>";
      echo "<script>window.location.href = 'visitors-form.php'</script>";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LEF CVMS | Add Visitor</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet">
<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet">

  <!-- Keep Template Styles -->
  <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
  <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
  <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
  <link href="css/theme.css" rel="stylesheet" media="all">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f9;
    }

    .page-container {
      background: #f4f6f9;
    }

    .main-content {
      padding: 20px 0;
    }

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

    .dashboard-header h3 {
      font-weight: 600;
      margin: 0;
    }

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

    .form-control, select, textarea {
      border-radius: 10px;
      padding: 10px 14px;
      border: 1px solid #ccc;
      transition: border-color 0.3s ease;
    }

    .form-control:focus, select:focus, textarea:focus {
      border-color: #6610f2;
      box-shadow: 0 0 0 0.2rem rgba(102,16,242,0.15);
    }

    .btn-primary {
   background: linear-gradient(135deg, #0d6efd, #f1f1f1ff);
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 10px 20px;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #6610f2, #0d6efd);
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
            <h3><i class="fa-solid fa-user-plus me-2"></i>Add New Visitor</h3>
            <img src="images/lef-logo.png" alt="LEF Logo" height="50">
          </div>

          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="card p-3">
                <div class="card-header">
                  <i class="fa-solid fa-user me-2 text-primary"></i> Visitor Details Form
                </div>
                <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                      <label for="fullname" class="form-label">Full Name</label>
                      <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter full name" required>
                    </div>

                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" required>
                    </div>

                    <div class="mb-3">
                      <label for="mobilenumber" class="form-label">Mobile Number</label>
                      <input type="text" id="mobilenumber" name="mobilenumber" maxlength="10" class="form-control" placeholder="Enter mobile number" required>
                    </div>

                    <div class="mb-3">
                      <label for="address" class="form-label">Address</label>
                      <textarea name="address" id="address" rows="4" class="form-control" placeholder="Enter visitor address" required></textarea>
                    </div>

                    <div class="mb-3">
                      <label for="whomtomeet" class="form-label">Whom to Meet</label>
                      <input type="text" id="whomtomeet" name="whomtomeet" class="form-control" placeholder="Enter name of person to meet" required>
                    </div>

                    <div class="mb-3">
                      <label for="department" class="form-label">Department</label>
                      <select name="department" id="department" class="form-control" required>
                        <option value="">Select Department</option>
                        <?php
                        $ret = mysqli_query($con, "SELECT * FROM tbldepartments ORDER BY departmentName");
                        while ($row = mysqli_fetch_array($ret)) {
                          echo '<option value="'.htmlentities($row['departmentName']).'">'.htmlentities($row['departmentName']).'</option>';
                        }
                        ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label for="reasontomeet" class="form-label">Reason to Meet</label>
                      <input type="text" id="reasontomeet" name="reasontomeet" class="form-control" placeholder="Reason for visit" required>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="submit" class="btn btn-primary">
                        <i class="fa-solid fa-check-circle me-1"></i> Submit Visitor
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
