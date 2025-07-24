<?php
include('includes/dbconnection.php');

if ($con) {
    echo "✅ Database connection successful!";
} else {
    echo "❌ Failed to connect to the database.";
}
?>
