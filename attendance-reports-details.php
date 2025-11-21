<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['cvmsaid']==0)) {
  header('location:logout.php');
} else {
  $fdate=$_POST['fromdate'];
  $tdate=$_POST['todate'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Attendance Report Details</title>
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
            <div class="card-header">
              <strong>Attendance Report from <?php echo $fdate;?> to <?php echo $tdate;?></strong>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_query($con,"SELECT * FROM tblemployeeattendance WHERE DATE(ClockIn) BETWEEN '$fdate' AND '$tdate' ORDER BY ClockIn ASC");
                $cnt=1;
                while($row=mysqli_fetch_array($query)){
                ?>
                  <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php echo $row['EmployeeName'];?></td>
                    <td><?php echo $row['Department'];?></td>
                    <td><?php echo $row['ClockIn'];?></td>
                    <td><?php echo $row['ClockOut'];?></td>
                    <td><?php echo $row['Status'];?></td>
                  </tr>
                <?php $cnt++; } ?>
                </tbody>
              </table>
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
