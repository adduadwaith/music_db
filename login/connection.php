<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "signup_db";

// Attempt to connect to the database
if (!$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname,3306)) {
    die("Failed to connect");
}
?>
