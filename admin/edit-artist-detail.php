<?php
// Turn on full error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('includes/dbconnection.php');

if (!isset($_SESSION['agmsaid']) || strlen($_SESSION['agmsaid']) == 0) {
  header('location:logout.php');
  exit();
} else {

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $mobnum = trim($_POST['mobnum']);
    $email = trim($_POST['email']);
    $edudetails = trim($_POST['edudetails']);
    $eid = $_GET['editid'];

    // Server-side validation
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        echo "<script>alert('Invalid name. Only letters and spaces are allowed.');</script>";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobnum)) {
        echo "<script>alert('Invalid mobile number. It must be exactly 10 digits.');</script>";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
        echo "<script>alert('Invalid email. Only Gmail addresses are allowed.');</script>";
    } else {
        $query = mysqli_query($con, "UPDATE tblartist SET Name='$name', MobileNumber='$mobnum', Email='$email', Education='$edudetails' WHERE ID='$eid'");
        if ($query) {
            echo "<script>alert('Artist details have been updated.');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Update Artist | Art Gallery Management System</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body>
<section id="container" class="">
  <?php include_once('includes/header.php'); ?>
  <?php include_once('includes/sidebar.php'); ?>

  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header"><i class="fa fa-file-text-o"></i>Update Artist Detail</h3>
          <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
            <li><i class="icon_document_alt"></i>Artist</li>
            <li><i class="fa fa-file-text-o"></i>Artist Detail</li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading">Update Artist Detail</header>
            <div class="panel-body">
              <form class="form-horizontal" method="post" action="">
                <?php
                $cid = $_GET['editid'];
                $ret = mysqli_query($con, "SELECT * FROM tblartist WHERE ID='$cid'");
                while ($row = mysqli_fetch_array($ret)) {
                ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="name" name="name" type="text" required pattern="[A-Za-z\s]+" value="<?php echo $row['Name']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Mobile Number</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="mobnum" name="mobnum" maxlength="10" required pattern="[0-9]{10}" value="<?php echo $row['MobileNumber']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="email" name="email" type="email" required pattern="[a-zA-Z0-9._%+-]+@gmail\.com" value="<?php echo $row['Email']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Education Details</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="edudetails" required><?php echo $row['Education']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Profile Pic</label>
                  <div class="col-sm-10">
                    <img src="images/<?php echo $row['Profilepic']; ?>" width="200" height="150">
                    <a href="changepropic.php?imageid=<?php echo $row['ID']; ?>" class="btn btn-success">Edit Image</a>
                  </div>
                </div>
                <?php } ?>
                <p style="text-align: center;"><button type="submit" name="submit" class="btn btn-primary">Update</button></p>
              </form>
            </div>
          </section>
        </div>
      </div>
    </section>
  </section>
  <?php include_once('includes/footer.php'); ?>
</section>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="js/scripts.js"></script>
</body>
</html>

<?php } ?>
