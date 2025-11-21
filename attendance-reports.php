<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['cvmsaid']==0)) {
  header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Attendance Reports - LEF CVMS</title>
  <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet">
  <link href="css/theme.css" rel="stylesheet">
</head>
<body class="animsition">
<div class="page-wrapper">
  <?php include_once('includes/sidebar.php'); ?>
  <div class="page-container">
    <?php include_once('includes/header.php'); ?>

    <div class="main-content">
      <div class="section__content section__content--p30">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header"><strong>Staff Attendance Report</strong></div>
            <div class="card-body">
              <form method="post" action="attendance-reports-details.php">
                <div class="form-group">
                  <label>From Date</label>
                  <input type="date" name="fromdate" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>To Date</label>
                  <input type="date" name="todate" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Generate Report</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<?php } ?>
