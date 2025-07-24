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
    $name = trim($_POST['name']);
    $mobnum = trim($_POST['mobnum']);
    $email = trim($_POST['email']);
    $edudetails = trim($_POST['edudetails']);
    $img = $_FILES["images"]["name"];
    $extension = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    $allowed_extensions = array("jpg", "jpeg", "png");

    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        echo "<script>alert('Invalid name. Only alphabets and spaces are allowed.');</script>";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobnum)) {
        echo "<script>alert('Invalid mobile number. It should be exactly 10 digits.');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@gmail.com')) {
        echo "<script>alert('Please enter a valid Gmail address.');</script>";
    } elseif (!in_array($extension, $allowed_extensions)) {
        echo "<script>alert('Invalid image format. Only JPG, JPEG, and PNG are allowed.');</script>";
    } else {
        // Check if artist already exists
        $check_query = mysqli_query($con, "SELECT ID FROM tblartist WHERE Name = '$name' AND Email = '$email'");
        if (mysqli_num_rows($check_query) > 0) {
            echo "<script>alert('This artist already exists.');</script>";
        } else {
            // Proceed with insert
            $proimg = md5($img) . '.' . $extension;
            move_uploaded_file($_FILES["images"]["tmp_name"], "images/" . $proimg);

            $query = mysqli_query($con, "INSERT INTO tblartist(Name, MobileNumber, Email, Education, Profilepic) 
                VALUES('$name', '$mobnum', '$email', '$edudetails', '$proimg')");

            if ($query) {
                echo "<script>alert('Artist details have been added.');</script>";
                echo "<script>window.location.href ='manage-artist.php'</script>";
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
    <title>Add Artist | Art Gallery Management System</title>
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
                    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Add Artist Detail</h3>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
                        <li><i class="icon_document_alt"></i>Artist</li>
                        <li><i class="fa fa-file-text-o"></i>Add Artist Detail</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">Add Artist Detail</header>
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="name" name="name" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Mobile Number</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="mobnum" name="mobnum" type="text" pattern="[0-9]{10}" maxlength="10" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="email" name="email" type="email" required placeholder="example@gmail.com">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Education Details</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="edudetails" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="images" id="images" accept=".jpg, .jpeg, .png" required>
                                    </div>
                                </div>
                                <p style="text-align: center;">
                                    <button type="submit" name='submit' class="btn btn-primary">Submit</button>
                                </p>
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
