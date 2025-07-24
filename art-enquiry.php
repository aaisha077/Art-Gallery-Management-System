<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

if (isset($_POST['send'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $mobilenumber = $_POST['mobnum'];
    $message = $_POST['message'];
    $enquirynumber = mt_rand(100000000, 999999999);
    $eid = isset($_GET['eid']) ? $_GET['eid'] : 0;

    if (!preg_match("/^[A-Za-z ]{8,}$/", $fullname)) {
        echo "<script>alert('Full Name must be at least 8 characters long and contain only letters and spaces.');</script>";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\\.com$/", $email)) {
        echo "<script>alert('Only valid Gmail addresses are allowed (e.g., yourname@gmail.com).');</script>";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobilenumber)) {
        echo "<script>alert('Mobile number must be exactly 10 digits and contain only numbers.');</script>";
    } else {
        $query1 = mysqli_query($con, "INSERT INTO tblenquiry(Artpdid, FullName, Email, MobileNumber, Message, EnquiryNumber) 
        VALUES ('$eid', '$fullname', '$email', '$mobilenumber', '$message', '$enquirynumber')");

        if ($query1) {
            echo "<script>alert('Your enquiry was successfully sent. Your Enquiry number is $enquirynumber');</script>";
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Something went wrong while sending your enquiry.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">
   <head>
      <title>Art Gallery Management System | Art Enquiry</title>
      <script>
         addEventListener("load", function () {
         	setTimeout(hideURLbar, 0);
         }, false);
         function hideURLbar() {
         	window.scrollTo(0, 1);
         }
      </script>
      <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
      <link href="css/fontawesome-all.min.css" rel="stylesheet" type="text/css" media="all">
      <link rel="stylesheet" href="css/shop.css" type="text/css" />
      <link href="css/style.css" rel='stylesheet' type='text/css' media="all">
      <link href="//fonts.googleapis.com/css?family=Sunflower:500,700" rel="stylesheet">
      <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
   </head>
   <body>
      <?php include_once('includes/header.php');?>
      <div class="inner_page-banner one-img"></div>
      <div class="using-border py-3">
         <div class="inner_breadcrumb  ml-4">
            <ul class="short_ls">
               <li>
                  <a href="index.php">Home</a>
                  <span>/ /</span>
               </li>
               <li>Enquiry</li>
            </ul>
         </div>
      </div>
      <section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
         <div class="container py-lg-5 py-md-4 py-sm-4 py-3">
            <h3 class="title text-center mb-lg-5 mb-md-4 mb-sm-4 mb-3">Enquiry</h3>
            <div class="contact-list-grid">
               <form action="#" method="post">
                  <div class=" agile-wls-contact-mid">
                     <div class="form-group contact-forms">
                       <input class="form-control" type="text" name="fullname" required pattern="[A-Za-z ]{8,}" title="Name must be at least 8 letters long and only contain alphabets and spaces." placeholder="Name"/>
                     </div>
                     <div class="form-group contact-forms">
                        <input class="form-control" type="email" name="email" required pattern="[a-zA-Z0-9._%+-]+@gmail\.com$" title="Only Gmail addresses are allowed (e.g., yourname@gmail.com)" placeholder="Email"/>
                     </div>
                     <div class="form-group contact-forms">
                        <input class="form-control" type="text" name="mobnum" maxlength="10" pattern="[0-9]{10}" title="Mobile number must be exactly 10 digits" placeholder="Mobile Number" required/>
                     </div>
                     <div class="form-group contact-forms">
                       <textarea class="form-control" name="message" placeholder="Message" required rows="4"></textarea>
                     </div>
                     <button type="submit" class="btn btn-block sent-butnn" name="send">Send</button>
                  </div>
               </form>
            </div>
         </div>
      </section>
      <?php include_once('includes/footer.php');?>
      <script src='js/jquery-2.2.3.min.js'></script>
      <script src="js/minicart.js"></script>
      <script>
         toys.render();
         toys.cart.on('toys_checkout', function (evt) {
         	var items, len, i;
         	if (this.subtotal() > 0) {
         		items = this.items();
         		for (i = 0, len = items.length; i < len; i++) {}
         	}
         });
      </script>
      <script src="js/move-top.js"></script>
      <script src="js/easing.js"></script>
      <script>
         jQuery(document).ready(function ($) {
         	$(".scroll").click(function (event) {
         		event.preventDefault();
         		$('html,body').animate({
         			scrollTop: $(this.hash).offset().top
         		}, 900);
         	});
         });
      </script>
      <script>
         $(document).ready(function () {
         	var defaults = {
         		containerID: 'toTop',
         		containerHoverID: 'toTopHover',
         		scrollSpeed: 1200,
         		easingType: 'linear'
         	};
         	$().UItoTop({
         		easingType: 'easeOutQuart'
         	});
         });
      </script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>