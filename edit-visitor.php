<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['cvmsaid']==0)) {
  header('location:logout.php');
} else {

$vid = intval($_GET['id']); // visitor ID

if(isset($_POST['update'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobilenumber'];
    $address = $_POST['address'];
    $whomtomeet = $_POST['whomtomeet'];
    $department = $_POST['department'];
    $reason = $_POST['reasontomeet'];

    $query = mysqli_query($con, "UPDATE tblvisitor SET 
        FullName='$fullname',
        Email='$email',
        MobileNumber='$mobile',
        Address='$address',
        WhomtoMeet='$whomtomeet',
        Deptartment='$department',
        ReasontoMeet='$reason'
        WHERE ID='$vid'");

    if ($query) {
        $msg = "Visitor details updated successfully.";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'manage-newvisitors.php';
                }, 1000);
            </script>";


    } else {
        $msg = "Something went wrong. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Visitor - LEF CVMS</title>
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
                        <div class="card-header"><strong>Edit Visitor Information</strong></div>
                        <div class="card-body card-block">
                            <p style="color:green; text-align:center;">
                                <?php echo $msg; ?>
                            </p>

                            <?php
                            $ret = mysqli_query($con, "SELECT * FROM tblvisitor WHERE ID='$vid'");
                            $row = mysqli_fetch_array($ret);
                            ?>

                            <form method="post">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="fullname" value="<?php echo $row['FullName']; ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?php echo $row['Email']; ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="text" name="mobilenumber" value="<?php echo $row['MobileNumber']; ?>" class="form-control" maxlength="10" required>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="address" class="form-control" required><?php echo $row['Address']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Whom to Meet</label>
                                    <input type="text" name="whomtomeet" value="<?php echo $row['WhomtoMeet']; ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Department</label>
                                    <select name="department" class="form-control" required>
                                        <option value="<?php echo $row['Deptartment']; ?>"><?php echo $row['Deptartment']; ?></option>
                                        <?php
                                        $dept = mysqli_query($con, "SELECT departmentName FROM tbldepartments ORDER BY departmentName");
                                        while($d = mysqli_fetch_array($dept)) {
                                            echo '<option value="'.$d['departmentName'].'">'.$d['departmentName'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Reason to Meet</label>
                                    <input type="text" name="reasontomeet" value="<?php echo $row['ReasontoMeet']; ?>" class="form-control" required>
                                </div>

                                <button type="submit" name="update" class="btn btn-primary">Update Visitor</button>
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
