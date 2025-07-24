<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/dbconnection.php');

if (strlen($_SESSION['agmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);

        // Check if the artist is used in tblartproduct
        $checkQuery = "SELECT COUNT(*) AS count FROM tblartproduct WHERE Artist = $rid";
        $result = mysqli_query($con, $checkQuery);
        $row = mysqli_fetch_assoc($result);

        if ($row['count'] > 0) {
            echo "<script>alert('Cannot delete this artist because they are associated with existing artworks.');</script>";
        } else {
            $sql = mysqli_query($con, "DELETE FROM tblartist WHERE ID = $rid");
            if ($sql) {
                echo "<script>alert('Artist deleted successfully.');</script>";
                echo "<script>window.location.href = 'manage-artist.php';</script>";
            } else {
                echo "<script>alert('Error deleting artist.');</script>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manage Artist | Art Gallery Management System</title>
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
            <h3 class="page-header"><i class="fa fa-table"></i> Manage Artist</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Artist</li>
              <li><i class="fa fa-th-list"></i>Manage Artist</li>
            </ol>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">Manage Artist</header>
              <table class="table">
                <thead>
                  <tr>
                    <th>S.NO</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Registration Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = mysqli_query($con, "SELECT * FROM tblartist");
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($ret)) {
                  ?>
                  <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['MobileNumber']; ?></td>
                    <td><?php echo $row['CreationDate']; ?></td>
                    <td>
                      <a href="edit-artist-detail.php?editid=<?php echo $row['ID']; ?>" class="btn btn-success">Edit</a>
                      ||
                      <a href="manage-artist.php?delid=<?php echo $row['ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this artist?');">Delete</a>
                    </td>
                  </tr>
                  <?php $cnt++; } ?>
                </tbody>
              </table>
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
  <script src="js/jquery.nicescroll.js"></script>
  <script src="js/scripts.js"></script>
</body>
</html>
<?php } ?>
