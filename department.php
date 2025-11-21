<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['cvmsaid']==0)) {
  header('location:logout.php');
} else {

  // Add Department
  if (isset($_POST['submit'])) {
    $deptname = $_POST['departmentname'];
    $query = mysqli_query($con, "INSERT INTO tbldepartments(departmentName) VALUE('$deptname')");
    if ($query) {
      echo "<script>alert('Department has been added');</script>";
      echo "<script>window.location.href = 'department.php'</script>";
    } else {
      echo "<script>alert('Something went wrong. Please try again');</script>";
      echo "<script>window.location.href = 'department.php'</script>";
    }
  }

  // Delete Department
  if (isset($_GET['catid'])) {
    $catid = intval($_GET['catid']);
    $sql = mysqli_query($con, "DELETE FROM tbldepartments WHERE id='$catid'");
    echo "<script>alert('Department deleted');</script>";
    echo "<script>window.location.href = 'department.php'</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LEF CVMS | Departments</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet">
<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet">

  <!-- Existing Template Styles -->
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
      background-color: #f4f6f9;
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
      box-shadow: 0 4px 20px rgba(0,0,0,0.06);
      margin-bottom: 30px;
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

    .btn-primary {
   background: linear-gradient(135deg, #0d6efd, #f1f1f1ff);
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 8px 20px;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #6610f2, #0d6efd);
    }

    .table {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .table thead {
   background: linear-gradient(135deg, #0d6efd, #f1f1f1ff);
      color: #fff;
      font-weight: 600;
    }

    .table tbody tr:hover {
      background-color: #f1f5ff;
    }

    .btn-danger {
      border-radius: 8px;
      padding: 5px 10px;
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
            <h3><i class="fa-solid fa-building me-2"></i>Manage Departments</h3>
            <img src="images/lef-logo.png" alt="LEF Logo" height="50">
          </div>

          <div class="row">
            <!-- Add Department Card -->
            <div class="col-lg-6 mx-auto">
              <div class="card">
                <div class="card-header">
                  <i class="fa-solid fa-plus-circle me-2 text-primary"></i> Add New Department
                </div>
                <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                      <label for="departmentname" class="form-label">Department Name</label>
                      <input type="text" id="departmentname" name="departmentname" class="form-control" placeholder="Enter department name" required>
                    </div>
                    <div class="text-center">
                      <button type="submit" name="submit" class="btn btn-primary"><i class="fa-solid fa-check-circle me-1"></i>Add Department</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Department List Table -->
          <div class="table-responsive mt-4">
            <table class="table table-striped align-middle text-center">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Department Name</th>
                  <th>Creation Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $ret = mysqli_query($con, "SELECT * FROM tbldepartments ORDER BY id DESC");
              $cnt = 1;
              while ($row = mysqli_fetch_array($ret)) {
              ?>
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo htmlentities($row['departmentName']);?></td>
                  <td><?php echo htmlentities($row['creationDate']);?></td>
                  <td>
                    <a href="department.php?catid=<?php echo $row['id'];?>" 
                       onclick="return confirm('Do you really want to delete this department?');" 
                       class="btn btn-danger btn-sm">
                      <i class="fa-solid fa-trash"></i> Delete
                    </a>
                  </td>
                </tr>
              <?php $cnt++; } ?>
              </tbody>
            </table>
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
