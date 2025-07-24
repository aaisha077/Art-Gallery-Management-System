<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['agmsaid']==0)) {
  header('location:logout.php');
} else {
    // Define allowed art types
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

    if(isset($_POST['submit'])) {
        $arttype = trim($_POST['arttype']);
        
        // Validate the input against allowed types
        if (!in_array($arttype, $allowed_types)) {
            echo "<script>alert('Please select a valid art type from the list.');</script>";
        } else {
            // Check if type already exists
            $check_query = mysqli_query($con, "SELECT * FROM tblarttype WHERE ArtType = '$arttype'");
            if(mysqli_num_rows($check_query) > 0) {
                echo "<script>alert('This art type already exists in the database.');</script>";
            } else {
                $query = mysqli_query($con, "INSERT INTO tblarttype(ArtType) VALUES('$arttype')");
                if ($query) {
                    echo "<script>alert('Art type has been added.');</script>";
                    echo "<script>window.location.href ='manage-art-type.php'</script>";
                } else {
                    echo "<script>alert('Something Went Wrong. Please try again.');</script>";
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Add Art Type | Art Gallery Management System</title>
  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/daterangepicker.css" rel="stylesheet" />
  <link href="css/bootstrap-datepicker.css" rel="stylesheet" />
  <link href="css/bootstrap-colorpicker.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">
    <!--header start-->
    <?php include_once('includes/header.php');?>
    <!--header end-->

    <!--sidebar start-->
    <?php include_once('includes/sidebar.php');?>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Add Art Type</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Art Type</li>
              <li><i class="fa fa-file-text-o"></i>Add Art Type</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Add Art Type
              </header>
              <div class="panel-body">
                <form class="form-horizontal" method="post" action="">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Art Type</label>
                    <div class="col-sm-10">
                      <select class="form-control" id="arttype" name="arttype" required>
                        <option value="">-- Select Art Type --</option>
                        <option value="Sculptures">Sculptures</option>
                        <option value="Prints">Prints</option>
                        <option value="Painting">Painting</option>
                        <option value="Pencil Sketches">Pencil Sketches</option>
                        <option value="Digital Art">Digital Art</option>
                        <option value="Street Art">Street Art</option>
                        <option value="Abstract Art">Abstract Art</option>
                        <option value="Modern Art">Modern Art</option>
                        <option value="Pop">Pop</option>
                        <option value="Photography">Photography</option>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div style="text-align: center;">
                      <button type="submit" name='submit' class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div>
        </div>
      </section>
    </section>
    <?php include_once('includes/footer.php');?>
  </section>
  <!-- container section end -->
  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- jquery ui -->
  <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
  <!--custom checkbox & radio-->
  <script type="text/javascript" src="js/ga.js"></script>
  <!--custom switch-->
  <script src="js/bootstrap-switch.js"></script>
  <!--custom tagsinput-->
  <script src="js/jquery.tagsinput.js"></script>
  <!-- bootstrap-wysiwyg -->
  <script src="js/jquery.hotkeys.js"></script>
  <script src="js/bootstrap-wysiwyg.js"></script>
  <script src="js/bootstrap-wysiwyg-custom.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/bootstrap-colorpicker.js"></script>
  <script src="js/daterangepicker.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <!-- ck editor -->
  <script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
  <!-- custom form component script for this page-->
  <script src="js/form-component.js"></script>
  <!-- custome script for all page -->
  <script src="js/scripts.js"></script>
</body>
</html>
<?php } ?>