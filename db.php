
<?php
$conn = mysqli_connect("localhost", "root", "", "fitzone");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>