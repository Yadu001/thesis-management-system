<?php
$conn = mysqli_connect('localhost', 'root', '', 'universitythesis') or die("Connection error" . "" . mysqli_connec_error());
session_start();
session_unset();
session_destroy();
header("location: ./index.php");
?>