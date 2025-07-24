<?php
$con = mysqli_connect("localhost", "root", "root", "agmsdb"); // password changed from "" to "root"
if (mysqli_connect_errno()) {
    echo "Connection Fail: " . mysqli_connect_error();
}
?>
