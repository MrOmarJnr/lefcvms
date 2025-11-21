<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['cvmsaid']==0)) {
  header('location:logout.php');
} else {

  // Delete visitor
  if (isset($_GET['vid'])) {
    $vid = intval($_GET['vid']);
    $sql = mysqli_query($con, "DELETE FROM tblvisitor WHERE id='$vid'");
    echo "<script>alert('Visitor deleted successfully');</script>";
    echo "<script>window.location.href = 'manage-newvisitors.php'</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LEF CVMS | Manage Visitors</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet">
<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet">

  <!-- Template Styles -->
  <link href="vendor/animsition/animsition.min.css" rel="stylesheet">
  <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">
  <link href="vendor/select2/select2.min.css" rel="stylesheet">
  <link href="css/theme.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f6f9;
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
      box-shadow: 0 4px 20px rgba(0,0,0,0.06);
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
    .action-icons i {
      font-size: 18px;
      margin: 0 6px;
      cursor: pointer;
      transition: transform 0.2s ease;
    }
    .action-icons i:hover {
      transform: scale(1.2);
    }
    .fa-trash {
      color: #dc3545;
    }
    .fa-file {
      color: #0d6efd;
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
            <h3><i class="fa-solid fa-users me-2"></i>Manage Visitors</h3>
            <img src="images/lef-logo.png" alt="LEF Logo" height="50">
          </div>

          <!-- Visitors Table -->
          <div class="card p-3">
            <div class="card-header border-0 bg-transparent d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="fa-solid fa-table me-2 text-primary"></i>Visitor List</h5>
              <a href="visitors-form.php" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-user-plus me-1"></i> Add Visitor
              </a>
            </div>

            <div class="table-responsive mt-3">
              <table class="table align-middle table-striped text-center">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $ret = mysqli_query($con, "SELECT * FROM tblvisitor ORDER BY ID DESC");
                $cnt = 1;
                while ($row = mysqli_fetch_array($ret)) {
                ?>
                  <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo htmlentities($row['FullName']); ?></td>
                    <td><?php echo htmlentities($row['MobileNumber']); ?></td>
                    <td><?php echo htmlentities($row['Email']); ?></td>
                    <td class="action-icons">
                      <a href="visitor-detail.php?editid=<?php echo $row['ID']; ?>" title="View Full Details">
                        <i class="fa-solid fa-file-lines"></i>
                      </a>
                      <a href="edit-visitor.php?id=<?php echo $row['ID'];?>" title="Edit Visitor Info">
                        <i class="fa fa-edit" style="color:blue;"></i>
                      </a> |
                      <a href="manage-newvisitors.php?vid=<?php echo $row['ID']; ?>"
                         onclick="return confirm('Do you really want to delete this visitor?');"
                         title="Delete Visitor">
                        <i class="fa-solid fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php $cnt++; } ?>
                </tbody>
              </table>
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
