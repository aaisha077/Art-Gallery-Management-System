<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['agmsaid']==0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $dimension = $_POST['dimension'];
    $orientation = $_POST['orientation'];
    $size = $_POST['size'];
    $artist = $_POST['artist'];
    $arttype = $_POST['arttype'];
    $artmed = $_POST['artmed'];
    $sprice = $_POST['sprice'];
    $description = $_POST['description'];
    $eid = $_GET['editid'];

    // Validate dimension format
    if (!preg_match("/^[0-9]+x[0-9]+(x[0-9]+)?$/", $dimension)) {
      echo "<script>alert('Dimensions must be in format like 24x36 or 24x36x2 (width x height x depth).');</script>";
    } elseif (!is_numeric($sprice) || $sprice <= 0) {
      echo "<script>alert('Selling price must be a positive number.');</script>";
    } else {
      $query = mysqli_query($con, "UPDATE tblartproduct SET Title='$title', Dimension='$dimension', Orientation='$orientation', Size='$size', Artist='$artist', ArtType='$arttype', ArtMedium='$artmed', SellingPricing='$sprice', Description='$description' WHERE ID='$eid'");
      if ($query) {
        echo "<script>alert('Art product has been updated.');</script>";
      } else {
        echo "<script>alert('Something Went Wrong. Please try again.');</script>";
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Art Product | Art Gallery Management System</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
</head>
<body>
  <section id="container">
    <?php include_once('includes/header.php');?>
    <?php include_once('includes/sidebar.php');?>

    <section id="main-content" style="color:#000">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text-o"></i> Edit Art Product</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Art Product</li>
              <li><i class="fa fa-file-text-o"></i>Edit Art Product</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
            <?php
              $cid = $_GET['editid'];
              $ret = mysqli_query($con, "SELECT tblarttype.ID as atid, tblarttype.ArtType as typename, tblartmedium.ID as amid, tblartmedium.ArtMedium as amname, tblartproduct.ID as apid, tblartist.ID as arid, tblartist.Name, tblartproduct.* FROM tblartproduct JOIN tblarttype ON tblarttype.ID=tblartproduct.ArtType JOIN tblartmedium ON tblartmedium.ID=tblartproduct.ArtMedium JOIN tblartist ON tblartist.ID=tblartproduct.Artist WHERE tblartproduct.ID='$cid'");
              while ($row = mysqli_fetch_array($ret)) {
            ?>
            <div class="col-lg-6">
              <section class="panel">
                <header class="panel-heading">Update Art Product Detail</header>
                <div class="panel-body">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                      <input class="form-control" name="title" type="text" required value="<?php echo $row['Title']; ?>" />
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Featured Image</label>
                    <div class="col-sm-10">
                      <img src="images/<?php echo $row['Image']; ?>" width="200" height="150">
                      <a href="changeimage.php?editid=<?php echo $row['apid']; ?>"> &nbsp; Edit Image</a>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Dimension</label>
                    <div class="col-sm-10">
                      <input class="form-control" name="dimension" type="text" required value="<?php echo $row['Dimension']; ?>" pattern="[0-9]+x[0-9]+(x[0-9]+)?" title="Enter dimensions in format like 24x36 or 24x36x2 (width x height x depth)">
                    </div>
                  </div>
                </div>
              </section>
            </div>

            <div class="col-lg-6">
              <section class="panel">
                <div class="panel-body">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Orientation</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="orientation" required>
                        <option value="<?php echo $row['Orientation']; ?>"><?php echo $row['Orientation']; ?></option>
                        <option value="Potrait">Potrait</option>
                        <option value="Landscape">Landscape</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Size</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="size" required>
                        <option value="<?php echo $row['Size']; ?>"><?php echo $row['Size']; ?></option>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Artist</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="artist" required>
                        <option value="<?php echo $row['arid']; ?>"><?php echo $row['Name']; ?></option>
                        <?php 
                        $query1 = mysqli_query($con, "SELECT * FROM tblartist");
                        while ($row1 = mysqli_fetch_array($query1)) {
                        ?>
                        <option value="<?php echo $row1['ID']; ?>"><?php echo $row1['Name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Art Type</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="arttype" required>
                        <option value="<?php echo $row['atid']; ?>"><?php echo $row['typename']; ?></option>
                        <?php 
                        $query2 = mysqli_query($con, "SELECT * FROM tblarttype");
                        while ($row2 = mysqli_fetch_array($query2)) {
                        ?>
                        <option value="<?php echo $row2['ID']; ?>"><?php echo $row2['ArtType']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Art Medium</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="artmed" required>
                        <option value="<?php echo $row['amid']; ?>"><?php echo $row['amname']; ?></option>
                        <?php 
                        $query3 = mysqli_query($con, "SELECT * FROM tblartmedium");
                        while ($row3 = mysqli_fetch_array($query3)) {
                        ?>
                        <option value="<?php echo $row3['ID']; ?>"><?php echo $row3['ArtMedium']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Selling Price</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <span class="input-group-addon">Rs.</span>
                        <input class="form-control" type="number" name="sprice" required min="1" step="0.01" value="<?php echo $row['SellingPricing']; ?>">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="description" rows="12" required><?php echo $row['Description']; ?></textarea>
                    </div>
                  </div>
                </div>
              </section>
            </div>
            <?php } ?>
            <p style="text-align: center;"> 
              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </p>
          </form>
        </div>
      </section>
    </section>
    <?php include_once('includes/footer.php'); ?>
  </section>

  <!-- Scripts -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="js/scripts.js"></script>
</body>
</html>
<?php } ?>
