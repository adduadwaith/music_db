<?php
session_start();
include("../connection.php");
include("../functions.php");

check_login($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sangita - Music Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="../logout/logout.php">logout</a>
This is homepage
</body>
</html>
