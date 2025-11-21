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

// ✅ Bulk Clock-Out
if (isset($_POST['bulk_clockout'])) {
  $ids = $_POST['selected_ids'] ?? [];
  $time = $_POST['bulk_clockout_time'];
  $clockout = !empty($time) ? date('Y-m-d H:i:s', strtotime($time)) : date('Y-m-d H:i:s');

  if (!empty($ids)) {
    $idlist = implode(',', array_map('intval', $ids));
    $sql = "UPDATE tblemployeeattendance
            SET ClockOut='$clockout', Status='OUT'
            WHERE ID IN ($idlist)";
    if (mysqli_query($con, $sql)) {
      $msg = "✅ Selected employees clocked out successfully at $clockout.";
    } else {
      $msg = "❌ Error updating records.";
    }
  } else {
    $msg = "⚠️ Please select at least one employee to clock out.";
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

            <?php if($msg){ echo '<div class="alert alert-info text-center">'.$msg.'</div>'; } ?>

          

            <!-- Clock In / Out -->
            <div class="card mb-4">
              <div class="card-header">
                <i class="fa fa-user-clock"></i> Employee Attendance
              </div>
              <div class="card-body">
                <form method="post" class="form-horizontal">
                  <div class="row form-group">
                    <div class="col col-md-3">
                      <label class="form-control-label">Employee</label>
                    </div>
                    <div class="col-12 col-md-9">
                      <select name="employeeid" id="employeeid" class="form-control" required>
                        <option value="">Select Employee</option>
                        <?php
                        $ret = mysqli_query($con, "SELECT * FROM tblemployees ORDER BY EmployeeName ASC");
                        while($row = mysqli_fetch_array($ret)) {
                          echo '<option value="'.$row['ID'].'" data-dept="'.$row['Department'].'">'.$row['EmployeeName'].'</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-3">
                      <label class="form-control-label">Department</label>
                    </div>
                    <div class="col-12 col-md-9">
                      <input type="text" id="department" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="card-footer text-center">
                    <button type="submit" name="clockin" class="btn-grad mr-2"><i class="fa fa-sign-in"></i> Clock In</button>
                    <button type="submit" name="clockout" class="btn-grad"><i class="fa fa-sign-out"></i> Clock Out</button>

                    <div class="row form-group mt-3">
  <div class="col col-md-3">
    <label class="form-control-label">Manual Clock-In</label>
  </div>
  <div class="col-12 col-md-9">
    <input type="datetime-local" name="manual_in" class="form-control" placeholder="Optional manual time">
  </div>
</div>

<div class="row form-group">
  <div class="col col-md-3">
    <label class="form-control-label">Manual Clock-Out</label>
  </div>
  <div class="col-12 col-md-9">
    <input type="datetime-local" name="manual_out" class="form-control" placeholder="Optional manual time">
  </div>
</div>

                  </div>
                </form>
              </div>
            </div>
                   <!-- Today's Attendance -->
            <div class="card">
              <div class="card-header">
                <i class="fa fa-list"></i> Today's Attendance
              </div>
              <div class="card-body table-responsive">
                <table class="table table-borderless table-striped table-earning">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Employee</th>
                      <th>Department</th>
                      <th>Clock In</th>
                      <th>Clock Out</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $today = date('Y-m-d');
                    $ret = mysqli_query($con, "SELECT * FROM tblemployeeattendance WHERE DATE(ClockIn)='$today' ORDER BY ID DESC");
                    $cnt=1;
                    while($row=mysqli_fetch_array($ret)){ ?>
                      <tr>
                        <td><?php echo $cnt++; ?></td>
                        <td><?php echo htmlentities($row['EmployeeName']); ?></td>
                        <td><?php echo htmlentities($row['Department']); ?></td>
                        <td><?php echo htmlentities($row['ClockIn']); ?></td>
                        <td><?php echo htmlentities($row['ClockOut']); ?></td>
                        <td>
                          <?php if($row['Status']=='IN'){ ?>
                            <span class="badge badge-success">IN</span>
                          <?php } else { ?>
                            <span class="badge badge-secondary">OUT</span>
                          <?php } ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>

           

            <!-- Bulk Clock-Out -->
<div class="card mt-4">
  <div class="card-header">
    <i class="fa fa-users"></i> Bulk Clock-Out
  </div>
  <div class="card-body">
    <form method="post">
      <div class="form-group">
        <label><strong>Clock-Out Time:</strong></label>
        <input type="datetime-local" name="bulk_clockout_time"
               class="form-control" value="<?php echo date('Y-m-d\TH:i'); ?>">
        <small class="form-text text-muted">Leave blank to use current time.</small>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th><input type="checkbox" id="selectAll"></th>
              <th>Employee</th>
              <th>Department</th>
              <th>Clock In</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $today = date('Y-m-d');
            $ret = mysqli_query($con,
              "SELECT * FROM tblemployeeattendance
               WHERE DATE(ClockIn)='$today'
               AND (ClockOut IS NULL OR ClockOut='0000-00-00 00:00:00')
               ORDER BY ClockIn ASC");
            $count = 0;
            while($row = mysqli_fetch_array($ret)) {
              $count++;
              echo "
                <tr>
                  <td><input type='checkbox' name='selected_ids[]' value='{$row['ID']}'></td>
                  <td>{$row['EmployeeName']}</td>
                  <td>{$row['Department']}</td>
                  <td>{$row['ClockIn']}</td>
                </tr>";
            }
            if ($count == 0) {
              echo "<tr><td colspan='4' class='text-center text-muted'>No active employees to clock out.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <div class="text-center mt-3">
        <button type="submit" name="bulk_clockout" class="btn-grad">
          <i class="fa fa-sign-out-alt"></i> Clock Out Selected
        </button>
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
  <script>
  // Select/Deselect all checkboxes
  document.getElementById('selectAll')?.addEventListener('change', function() {
    let boxes = document.querySelectorAll("input[name='selected_ids[]']");
    boxes.forEach(b => b.checked = this.checked);
  });
</script>

</body>
</html>
<?php } ?>
