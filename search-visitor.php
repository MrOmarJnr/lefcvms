<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['cvmsaid'] == 0)) {
  header('location:logout.php');
} else {

  // Delete visitor
  if (isset($_GET['vid'])) {
    $vid = intval($_GET['vid']);
    mysqli_query($con, "DELETE FROM tblvisitor WHERE ID='$vid'");
    echo "<script>alert('Visitor record deleted');</script>";
    echo "<script>window.location.href = 'manage-newvisitors.php'</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>LEF-CVMS | Visitor Search</title>

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
  <link href="vendor/select2/select2.min.css" rel="stylesheet">
  <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">
  <link href="css/theme.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f6f9;
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
    .dashboard-header h3 { font-weight: 600; margin: 0; }

    .table-container {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      padding: 20px 25px;
    }
    table {
      border-radius: 10px;
      overflow: hidden;
    }
    table th {
      background: #6610f2;
      color: #fff;
      text-align: center;
      font-weight: 600;
    }
    table td {
      vertical-align: middle;
      text-align: center;
    }
    .no-results {
      text-align: center;
      font-weight: 500;
      color: #999;
      padding: 20px;
    }
    .action-icons a {
      text-decoration: none;
      margin: 0 5px;
    }
    .action-icons .fa-file {
      color: #0d6efd;
    }
    .action-icons .fa-trash {
      color: #dc3545;
    }
    footer {
      text-align: center;
      margin-top: 40px;
      color: #777;
      font-size: 14px;
    }
  </style>
</head>

<body class="animsition">
  <div class="page-wrapper">
    <?php include_once('includes/sidebar.php'); ?>

    <div class="page-container">
      <?php include_once('includes/header.php'); ?>

      <div class="main-content">
        <div class="container-fluid py-4">

          <!-- Page Header -->
          <div class="dashboard-header">
            <h3><i class="fa-solid fa-magnifying-glass me-2"></i> Search Visitor Records</h3>
            <img src="images/lef-logo.png" alt="LEF Logo" height="50">
          </div>

          <?php if (isset($_POST['search'])) { 
            $sdata = $_POST['searchdata']; ?>
            
            <div class="table-container">
              <h5 class="text-center mb-3 text-primary">
                Showing results for "<strong><?php echo htmlentities($sdata); ?></strong>"
              </h5>
              <hr>

              <div class="table-responsive">
                <table class="table table-striped align-middle">
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
                    $ret = mysqli_query($con, "SELECT * FROM tblvisitor WHERE FullName LIKE '$sdata%' OR MobileNumber LIKE '$sdata%'");
                    $num = mysqli_num_rows($ret);
                    if ($num > 0) {
                      $cnt = 1;
                      while ($row = mysqli_fetch_array($ret)) {
                    ?>
                      <tr>
                        <td><?php echo $cnt++; ?></td>
                        <td><?php echo htmlentities($row['FullName']); ?></td>
                        <td><?php echo htmlentities($row['MobileNumber']); ?></td>
                        <td><?php echo htmlentities($row['Email']); ?></td>
                        <td class="action-icons">
                          <a href="visitor-detail.php?editid=<?php echo $row['ID']; ?>" title="View Details">
                            <i class="fa fa-file fa-lg"></i>
                          </a>
                          <a href="manage-newvisitors.php?vid=<?php echo $row['ID']; ?>" onclick="return confirm('Do you really want to delete this record?');" title="Delete">
                            <i class="fa fa-trash fa-lg"></i>
                          </a>
                        </td>
                      </tr>
                    <?php } } else { ?>
                      <tr>
                        <td colspan="5" class="no-results">No record found for your search</td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php } else { ?>
            <div class="alert alert-info text-center mt-5">
              <i class="fa-solid fa-info-circle me-2"></i> Please enter a keyword to search visitors.
            </div>
          <?php } ?>

          <footer>© <?php echo date('Y'); ?> LEF | All Rights Reserved</footer>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="vendor/jquery-3.2.1.min.js"></script>
  <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
  <script src="vendor/animsition/animsition.min.js"></script>
  <script src="vendor/select2/select2.min.js"></script>
  <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
<?php } ?>
