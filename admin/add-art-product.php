<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('includes/dbconnection.php');

if (!isset($_SESSION['agmsaid']) || strlen($_SESSION['agmsaid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    if (isset($_POST['submit'])) {
        $aid = $_SESSION['agmsaid'];
        $title = $_POST['title'];
        $dimension = $_POST['dimension'];
        $orientation = $_POST['orientation'];
        $size = $_POST['size'];
        $artist = $_POST['artist'];
        $arttype = $_POST['arttype'];
        $artmed = $_POST['artmed'];
        $sprice = $_POST['sprice'];
        $description = $_POST['description'];
        $refno = mt_rand(100000000, 999999999);

        // Validate Selling Price
        if (!is_numeric($sprice) || $sprice <= 0) {
            echo "<script>alert('Selling price must be a positive number.');</script>";
        } else {
            // Check for duplicate Title + Artist
            $check_duplicate = mysqli_query($con, "SELECT ID FROM tblartproduct WHERE Title = '$title' AND Artist = '$artist'");
            if (mysqli_num_rows($check_duplicate) > 0) {
                echo "<script>alert('An art product with the same title and artist already exists. Please use a different title or artist.');</script>";
            } else {
                // Featured Image
                $pic = $_FILES["images"]["name"];
                $extension = strtolower(pathinfo($pic, PATHINFO_EXTENSION));

                // Allowed extensions
                $allowed_extensions = array("jpg", "jpeg", "png");

                if (!in_array($extension, $allowed_extensions)) {
                    echo "<script>alert('Featured image has invalid format. Only JPG, JPEG, or PNG formats are allowed.');</script>";
                } else {
                    // Rename image
                    $pic_new_name = md5($pic) . time() . '.' . $extension;
                    move_uploaded_file($_FILES["images"]["tmp_name"], "images/" . $pic_new_name);

                    $query = mysqli_query($con, "INSERT INTO tblartproduct(Title, Dimension, Orientation, Size, Artist, ArtType, ArtMedium, SellingPricing, Description, Image, RefNum) 
                    VALUES('$title','$dimension','$orientation','$size','$artist','$arttype','$artmed','$sprice','$description','$pic_new_name','$refno')");

                    if ($query) {
                        echo "<script>alert('Art product details have been submitted.');</script>";
                        echo "<script>window.location.href ='add-art-product.php'</script>";
                    } else {
                        echo "<script>alert('Something went wrong. Please try again.');</script>";
                    }
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Art Product | Art Gallery Management System</title>
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
<section id="container" class="">
  <?php include_once('includes/header.php');?>
  <?php include_once('includes/sidebar.php');?>

  <section id="main-content" style="color:#000">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header"><i class="fa fa-file-text-o"></i>Add Art Product Detail</h3>
          <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
            <li><i class="icon_document_alt"></i>Art Product</li>
            <li><i class="fa fa-file-text-o"></i>Art Product Detail</li>
          </ol>
        </div>
      </div>
      <div class="row">      
        <form class="form-horizontal " method="post" action="" enctype="multipart/form-data">
          <div class="col-lg-6">
            <section class="panel">
              <header class="panel-heading">Add Art Product Detail</header>
              <div class="panel-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="title" name="title" type="text" required />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Featured Image</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="images" id="images" accept=".jpg, .jpeg, .png" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Dimension</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="dimension" name="dimension" type="text"
                      pattern="^\d{1,4}\s*x\s*\d{1,4}$"
                      title="Enter dimensions in format like 16x24 or 16 x 24 (only numbers allowed)"
                      required>
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
                    <select class="form-control" id="orientation" name="orientation" required>
                      <option value="">Choose orientation</option>
                      <option value="Potrait">Potrait</option>
                      <option value="Landscape">Landscape</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Size</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="size" name="size" required>
                      <option value="">Choose Size</option>
                      <option value="Small">Small</option>
                      <option value="Medium">Medium</option>
                      <option value="Large">Large</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Artist</label>
                  <div class="col-sm-10">
                    <select class="form-control m-bot15" name="artist" id="artist" required>
                      <option value="">Choose Artist</option>
                      <?php $query=mysqli_query($con,"select * from tblartist");
                      while($row=mysqli_fetch_array($query)) { ?>
                        <option value="<?php echo $row['ID'];?>"><?php echo $row['Name'];?></option>
                      <?php } ?> 
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Art Type</label>
                  <div class="col-sm-10">
                    <select class="form-control m-bot15" name="arttype" id="arttype" required>
                      <option value="">Choose Art Type</option>
                      <?php $query=mysqli_query($con,"select * from tblarttype");
                      while($row=mysqli_fetch_array($query)) { ?>
                        <option value="<?php echo $row['ID'];?>"><?php echo $row['ArtType'];?></option>
                      <?php } ?> 
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Art Medium</label>
                  <div class="col-sm-10">
                    <select class="form-control m-bot15" name="artmed" id="artmed" required>
                      <option value="">Choose Art Medium</option>
                      <?php $query=mysqli_query($con,"select * from tblartmedium");
                      while($row=mysqli_fetch_array($query)) { ?>
                        <option value="<?php echo $row['ID'];?>"><?php echo $row['ArtMedium'];?></option>
                      <?php } ?> 
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Selling Price</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <span class="input-group-addon">Rs.</span>
                      <input class="form-control" id="sprice" type="number" name="sprice" required min="1" step="0.01" title="Price must be a positive number">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Art Product Description</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="description" name="description" rows="12" required></textarea>
                  </div>
                </div>
              </div>
            </section>
          </div>
          <p style="text-align: center;"> 
            <button type="submit" name='submit' class="btn btn-primary">Submit</button>
          </p>
        </form>
      </div>
    </section>
  </section>
  <?php include_once('includes/footer.php'); ?>
</section>

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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const fileInput = document.getElementById('images');

    form.addEventListener('submit', function (e) {
        const file = fileInput.files[0];
        const maxSize = 8 * 1024 * 1024; // 8 MB

        if (file && file.size > maxSize) {
            e.preventDefault();
            alert("Image size exceeds 8 MB. Please choose a smaller file.");
        }
    });
});
</script>

</body>
</html>
<?php } ?>
