<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['agmsaid'] == 0)) {
    header('location:logout.php');
} else {
    $allowed_types = array(
        "Sculptures",
        "Prints",
        "Painting",
        "Pencil Sketches",
        "Digital Art",
        "Street Art",
        "Abstract Art",
        "Modern Art",
        "Pop",
        "Photography"
    );

    $eid = $_GET['editid'];
    $current_query = mysqli_query($con, "SELECT * FROM tblarttype WHERE ID='$eid'");
    $row = mysqli_fetch_array($current_query);
    $current_arttype = $row['ArtType'];

    if (isset($_POST['submit'])) {
        $arttype = trim($_POST['arttype']);

        if (!in_array($arttype, $allowed_types)) {
            echo "<script>alert('Please select a valid art type from the list.');</script>";
        } elseif ($arttype == $current_arttype) {
            echo "<script>alert('No changes made. The selected art type is already saved.');</script>";
        } else {
            // Check for duplicate art type (excluding the current one)
            $check_duplicate = mysqli_query($con, "SELECT * FROM tblarttype WHERE ArtType='$arttype' AND ID != '$eid'");
            if (mysqli_num_rows($check_duplicate) > 0) {
                echo "<script>alert('This art type already exists in the database.');</script>";
            } else {
                $query = mysqli_query($con, "UPDATE tblarttype SET ArtType='$arttype' WHERE ID='$eid'");
                if ($query) {
                    echo "<script>alert('Art type has been updated.');</script>";
                    echo "<script>window.location.href ='manage-art-type.php'</script>";
                } else {
                    echo "<script>alert('Something went wrong. Please try again.');</script>";
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Update Art Type | Art Gallery Management System</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/daterangepicker.css" rel="stylesheet" />
  <link href="css/bootstrap-datepicker.css" rel="stylesheet" />
  <link href="css/bootstrap-colorpicker.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
</head>
<body>
  <section id="container">
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Update Art Type Detail</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Update Art Type</li>
              <li><i class="fa fa-file-text-o"></i>Update Art Type Detail</li>
            </ol>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Update Art Type Detail
              </header>
              <div class="panel-body">
                <form class="form-horizontal" method="post" action="">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Art Type</label>
                    <div class="col-sm-10">
                      <select class="form-control" id="arttype" name="arttype" required>
                        <option value="">-- Select Art Type --</option>
                        <?php
                        foreach ($allowed_types as $type) {
                            $selected = ($current_arttype == $type) ? 'selected' : '';
                            echo "<option value=\"$type\" $selected>$type</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <div style="text-align: center;">
                      <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div>
        </div>
      </section>
    </section>

    <?php include_once('includes/footer.php'); ?>
  </section>

  <!-- JS Files -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js"></script>
  <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="js/bootstrap-switch.js"></script>
  <script src="js/jquery.tagsinput.js"></script>
  <script src="js/jquery.hotkeys.js"></script>
  <script src="js/bootstrap-wysiwyg.js"></script>
  <script src="js/bootstrap-wysiwyg-custom.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/bootstrap-colorpicker.js"></script>
  <script src="js/daterangepicker.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="assets/ckeditor/ckeditor.js"></script>
  <script src="js/form-component.js"></script>
  <script src="js/scripts.js"></script>
</body>
</html>
<?php } ?>
