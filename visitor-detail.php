<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['cvmsaid']==0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $eid = $_GET['editid'];
    $remark = $_POST['remark'];

    $query = mysqli_query($con, "UPDATE tblvisitor SET remark='$remark', outtime=NOW() WHERE ID='$eid'");

    if ($query) {
      $msg = "Visitor remark has been updated successfully.";
    } else {
      $msg = "Something went wrong. Please try again.";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LEF-CVMS | Visitor Details</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
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
    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      overflow: hidden;
    }
    .card-header {
      background: #6610f2;
      color: #fff;
      font-weight: 600;
      font-size: 18px;
    }
    table th {
      width: 25%;
      background: #f8f9fa;
      font-weight: 600;
      color: #333;
    }
    table td {
      color: #555;
      vertical-align: middle;
    }
    textarea {
      border-radius: 10px;
      resize: none;
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

          <!-- Header -->
          <div class="dashboard-header">
            <h3><i class="fa-solid fa-id-card me-2"></i>Visitor Details</h3>
            <img src="images/lef-logo.png" alt="LEF Logo" height="50">
          </div>

          <?php if($msg): ?>
            <div class="alert alert-info text-center"><?php echo htmlentities($msg); ?></div>
          <?php endif; ?>

          <?php
          $eid = $_GET['editid'];
          $ret = mysqli_query($con, "SELECT * FROM tblvisitor WHERE ID='$eid'");
          while ($row = mysqli_fetch_array($ret)) {
          ?>
          <div class="card">
            <div class="card-header">
              Visitor Information
            </div>
            <div class="card-body p-4">
              <table class="table table-bordered align-middle">
                <tr>
                  <th>Full Name</th>
                  <td><?php echo htmlentities($row['FullName']); ?></td>
                  <th>Email</th>
                  <td><?php echo htmlentities($row['Email']); ?></td>
                </tr>
                <tr>
                  <th>Mobile Number</th>
                  <td><?php echo htmlentities($row['MobileNumber']); ?></td>
                  <th>Address</th>
                  <td><?php echo htmlentities($row['Address']); ?></td>
                </tr>
                <tr>
                  <th>Whom to Meet</th>
                  <td><?php echo htmlentities($row['WhomtoMeet']); ?></td>
                  <th>Department</th>
                  <td><?php echo htmlentities($row['Deptartment']); ?></td>
                </tr>
                <tr>
                  <th>Reason to Meet</th>
                  <td><?php echo htmlentities($row['ReasontoMeet']); ?></td>
                  <th>Entry Time</th>
                  <td><?php echo htmlentities($row['EnterDate']); ?></td>
                </tr>

                <?php if($row['remark'] == "") { ?>
                <form method="post">
                  <tr>
                    <th>Outing Remark</th>
                    <td colspan="3">
                      <textarea name="remark" rows="4" class="form-control" placeholder="Enter visitor remark..." required></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-center">
                      <button type="submit" name="submit" class="btn btn-primary">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Update Remark
                      </button>
                    </td>
                  </tr>
                </form>
                <?php } else { ?>
                <tr>
                  <th>Outing Remark</th>
                  <td><?php echo htmlentities($row['remark']); ?></td>
                  <th>Out Time</th>
                  <td><?php echo htmlentities($row['outtime']); ?></td>
                </tr>
                <?php } ?>
              </table>
            </div>
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
