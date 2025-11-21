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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LEF CVMS Dashboard</title>
      <link rel="icon" type="image/x-icon" href="images/favicon_io/favicon.ico">


  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- Legacy icon support for header/search/profile -->
<link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet">
<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet">


  <!-- Keep old vendor/theme CSS for sidebar/header -->
  <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
  <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
  <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
  <link href="css/theme.css" rel="stylesheet" media="all">

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

    .dashboard-header h3 {
      font-weight: 600;
      margin: 0;
    }

    .card-stat {
      border: none;
      border-radius: 16px;
      padding: 25px;
      background: #fff;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-stat:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .card-stat .icon {
      font-size: 38px;
      margin-bottom: 15px;
      color: #fff;
      width: 70px;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 14px;
    }

    .bg-gradient-blue { background: linear-gradient(45deg, #007bff, #00c6ff); }
    .bg-gradient-orange { background: linear-gradient(45deg, #ff8800, #ffbb33); }
    .bg-gradient-green { background: linear-gradient(45deg, #00b09b, #96c93d); }
    .bg-gradient-purple { background: linear-gradient(45deg, #8e2de2, #4a00e0); }
    .bg-gradient-red { background: linear-gradient(45deg, #ff416c, #ff4b2b); }

    .card-stat h2 {
      font-size: 32px;
      font-weight: 700;
      margin: 0;
      color: #333;
    }

    .card-stat span {
      font-size: 15px;
      color: #777;
    }

    footer {
      text-align: center;
      margin-top: 40px;
      color: #888;
      font-size: 14px;
    }

    .page-container {
      background: #f4f6f9;
      min-height: 100vh;
    }

    .main-content {
      padding: 20px 0;
    }
  </style>
</head>

<body class="animsition">
  <div class="page-wrapper">

    <!-- SIDEBAR -->
    <?php include_once('includes/sidebar.php');?>

    <!-- PAGE CONTAINER -->
    <div class="page-container">

      <!-- HEADER (with user/logout menu) -->
      <?php include_once('includes/header.php');?>

      <!-- MAIN CONTENT -->
      <div class="main-content">
        <div class="container-fluid py-4">

          <!-- Dashboard Header -->
          <div class="dashboard-header">
            <h3><i class="fa-solid fa-chart-line me-2"></i>LEF Company Visitor Management System</h3>
            <img src="images/lef-logo.png" alt="LEF Logo" height="50">
          </div>

          <?php
          // Today's Visitors
          $query=mysqli_query($con,"SELECT ID FROM tblvisitor WHERE date(EnterDate)=CURDATE();");
          $count_today_visitors=mysqli_num_rows($query);

          // Yesterday's Visitors
          $query1=mysqli_query($con,"SELECT ID FROM tblvisitor WHERE date(EnterDate)=CURDATE()-1;");
          $count_yesterday_visitors=mysqli_num_rows($query1);

          // Last 7 Days
          $query2=mysqli_query($con,"SELECT ID FROM tblvisitor WHERE date(EnterDate)>=(DATE(NOW()) - INTERVAL 7 DAY);");
          $count_lastsevendays_visitors=mysqli_num_rows($query2);

          // Last 30 Days
          $query3=mysqli_query($con,"SELECT ID FROM tblvisitor WHERE date(EnterDate)>=(DATE(NOW()) - INTERVAL 30 DAY);");
          $count_lastthirdaydays_visitors=mysqli_num_rows($query3);

          // Total Visitors
          $query4=mysqli_query($con,"SELECT ID FROM tblvisitor");
          $count_total_visitors=mysqli_num_rows($query4);
          ?>

          <!-- Statistics Cards -->
          <div class="row g-4">
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card-stat text-center">
                <div class="icon bg-gradient-blue mx-auto"><i class="fa-solid fa-user-clock"></i></div>
                <h2><?php echo $count_today_visitors;?></h2>
                <span>Today's Visitors</span>
              </div>
            </div>

            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card-stat text-center">
                <div class="icon bg-gradient-orange mx-auto"><i class="fa-solid fa-user-minus"></i></div>
                <h2><?php echo $count_yesterday_visitors;?></h2>
                <span>Yesterday's Visitors</span>
              </div>
            </div>

            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card-stat text-center">
                <div class="icon bg-gradient-green mx-auto"><i class="fa-solid fa-calendar-week"></i></div>
                <h2><?php echo $count_lastsevendays_visitors;?></h2>
                <span>Last 7 Days Visitors</span>
              </div>
            </div>

            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card-stat text-center">
                <div class="icon bg-gradient-purple mx-auto"><i class="fa-solid fa-calendar-days"></i></div>
                <h2><?php echo $count_lastthirdaydays_visitors;?></h2>
                <span>Last 30 Days Visitors</span>
              </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
              <div class="card-stat text-center">
                <div class="icon bg-gradient-red mx-auto"><i class="fa-solid fa-users"></i></div>
                <h2><?php echo $count_total_visitors;?></h2>
                <span>Total Visitors Till Date</span>
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
