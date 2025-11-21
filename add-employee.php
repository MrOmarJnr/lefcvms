<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['cvmsaid']==0)) {
  header('location:logout.php');
} else {

  // Add Employee
  if (isset($_POST['add_employee'])) {
    $ename = trim($_POST['employeename']);
    $dept  = trim($_POST['department']);
    if ($ename && $dept) {
      $check = mysqli_query($con, "SELECT ID FROM tblemployees WHERE EmployeeName='$ename' LIMIT 1");
      if (mysqli_num_rows($check) == 0) {
        mysqli_query($con, "INSERT INTO tblemployees(EmployeeName, Department) VALUES('$ename', '$dept')");
        $msg = "Employee '$ename' added successfully!";
      } else {
        $msg = "Employee already exists.";
      }
    }
  }

// ✅ Clock In
if (isset($_POST['clockin'])) {
  $empid = $_POST['employeeid'];
  $manual_in = $_POST['manual_in']; // user-specified time
  $emp = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tblemployees WHERE ID='$empid'"));
  $name = $emp['EmployeeName'];
  $dept = $emp['Department'];

  // If admin provided manual time, use it; otherwise, use current time
  $checkin = !empty($manual_in) ? date('Y-m-d H:i:s', strtotime($manual_in)) : date('Y-m-d H:i:s');

  mysqli_query($con, "INSERT INTO tblemployeeattendance(EmployeeName, Department, ClockIn, Status)
                      VALUES('$name', '$dept', '$checkin', 'IN')");
  $msg = "Clock-In recorded for $name at $checkin.";
}

// ✅ Clock Out
if (isset($_POST['clockout'])) {
  $empid = $_POST['employeeid'];
  $manual_out = $_POST['manual_out']; // user-specified time
  $emp = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tblemployees WHERE ID='$empid'"));
  $name = $emp['EmployeeName'];

  $check = mysqli_query($con, "SELECT ID FROM tblemployeeattendance
                               WHERE EmployeeName='$name' AND Status='IN'
                               ORDER BY ID DESC LIMIT 1");
  if (mysqli_num_rows($check) > 0) {
    $row = mysqli_fetch_assoc($check);
    $outid = $row['ID'];

    // If admin provided manual time, use it; otherwise, use current time
    $checkout = !empty($manual_out) ? date('Y-m-d H:i:s', strtotime($manual_out)) : date('Y-m-d H:i:s');

    mysqli_query($con, "UPDATE tblemployeeattendance 
                        SET ClockOut='$checkout', Status='OUT' 
                        WHERE ID='$outid'");
    $msg = "Clock-Out recorded for $name at $checkout.";
  } else {
    $msg = "No active Clock-In found for $name.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>LEF-CVMS | Employee Attendance</title>

  <!-- Fontfaces CSS-->
  <link href="css/font-face.css" rel="stylesheet" media="all">
  <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
  <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
  <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

  <!-- Bootstrap CSS-->
  <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

  <!-- Vendor CSS-->
  <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
  <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
  <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">

  <!-- Main CSS-->
  <link href="css/theme.css" rel="stylesheet" media="all">

  <style>
    .card-header {
      background: linear-gradient(135deg, #0d6efd, #6610f2);
      color: #fff;
      font-weight: 600;
      font-size: 18px;
    }
    .btn-grad {
      background: linear-gradient(135deg, #0d6efd, #6610f2);
      color: #fff !important;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      padding: 8px 16px;
    }
  </style>
</head>

<body class="animsition">
  <div class="page-wrapper">
    <?php include_once('includes/sidebar.php');?>

    <div class="page-container">
      <?php include_once('includes/header.php');?>

      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">

       
      <!-- Add Employee Section -->
            <div class="card mb-4">
              <div class="card-header">
                <i class="fa fa-user-plus"></i> Add Employee
              </div>
              <div class="card-body">
                <form method="post" class="form-horizontal">
                  <div class="row form-group">
                    <div class="col col-md-3">
                      <label class="form-control-label">Employee Name</label>
                    </div>
                    <div class="col-12 col-md-9">
                      <input type="text" name="employeename" class="form-control" required>
                    </div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-3">
                      <label class="form-control-label">Department</label>
                    </div>
                    <div class="col-12 col-md-9">
                      <input type="text" name="department" class="form-control" required>
                    </div>
                  </div>
                  <div class="card-footer text-center">
                    <button type="submit" name="add_employee" class="btn-grad">
                      <i class="fa fa-plus-circle"></i> Add Employee
                    </button>
                  </div>
                </form>
              </div>
            </div>
          

  

                  </div>
                </form>
              </div>
            </div>
            
        

     
            <?php include_once('includes/footer.php');?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="vendor/jquery-3.2.1.min.js"></script>
  <script src="vendor/animsition/animsition.min.js"></script>
  <script src="vendor/bootstrap-4.1/popper.min.js"></script>
  <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
  <script src="vendor/select2/select2.min.js"></script>
  <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="js/main.js"></script>

  <script>
    // Auto-fill department on employee selection
    document.getElementById('employeeid').addEventListener('change', function() {
      var dept = this.options[this.selectedIndex].getAttribute('data-dept');
      document.getElementById('department').value = dept || '';
    });
  </script>
</body>
</html>
<?php } ?>
