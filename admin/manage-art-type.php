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

        // Check if ArtType is used in tblartproduct
        $checkQuery = "SELECT COUNT(*) AS count FROM tblartproduct WHERE ArtType = $rid";
        $result = mysqli_query($con, $checkQuery);
        $row = mysqli_fetch_assoc($result);

        if ($row['count'] > 0) {
            echo "<script>alert('Cannot delete this Art Type because it is used in existing artworks.');</script>";
        } else {
            $sql = mysqli_query($con, "DELETE FROM tblarttype WHERE ID = $rid");
            if ($sql) {
                echo "<script>alert('Art Type deleted successfully.');</script>";
                echo "<script>window.location.href = 'manage-art-type.php';</script>";
            } else {
                echo "<script>alert('Error deleting Art Type.');</script>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manage Art Type | Art Gallery Management System</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
</head>
<body>
  <section id="container" class="">
    <?php include_once('includes/header.php');?>
    <?php include_once('includes/sidebar.php');?>

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-table"></i> Manage Art Type</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="fa fa-table"></i>Manage Art Type</li>
              <li><i class="fa fa-th-list"></i>Manage Art Type</li>
            </ol>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">Manage Art Type</header>
              <table class="table">
                <thead>
                  <tr>
                    <th>S.NO</th>
                    <th>Type of Art</th>
                    <th>Creation Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = mysqli_query($con, "SELECT * FROM tblarttype");
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($ret)) {
                  ?>
                  <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo $row['ArtType']; ?></td>
                    <td><?php echo $row['CreationDate']; ?></td>
                    <td>
                      <a href="edit-art-type-detail.php?editid=<?php echo $row['ID']; ?>" class="btn btn-success">Edit</a>
                      ||
                      <a href="manage-art-type.php?delid=<?php echo $row['ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Art Type?');">Delete</a>
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
