<?php
include('includes/dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Check Enquiry Status | Art Gallery</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Check Your Enquiry Status</h2>
  <form method="post" action="">
    <div class="form-group">
      <label>Enter Your Enquiry Number:</label>
      <input type="text" name="enquirynumber" class="form-control" required>
    </div>
    <button type="submit" name="check" class="btn btn-primary">Check Status</button>
  </form>

  <hr>

  <?php
  if (isset($_POST['check'])) {
    $enquirynumber = $_POST['enquirynumber'];
    $query = mysqli_query($con, "SELECT * FROM tblenquiry WHERE EnquiryNumber='$enquirynumber'");

    if (mysqli_num_rows($query) > 0) {
      $row = mysqli_fetch_array($query);
      echo "<h5>Message:</h5>";
      echo "<p>" . htmlentities($row['Message']) . "</p>";

      echo "<h5>Status:</h5>";
      echo "<p>" . ($row['Status'] ? htmlentities($row['Status']) : "Pending") . "</p>";

      if ($row['AdminRemark']) {
        echo "<h5>Admin Response:</h5>";
        echo "<p>" . htmlentities($row['AdminRemark']) . "</p>";
      } else {
        echo "<h5>Admin Response:</h5><p>No response yet.</p>";
      }
    } else {
      echo "<p style='color:red;'>No enquiry found with that number.</p>";
    }
  }
  ?>
</div>
</body>
</html>
