<?php
session_start();

if(isset($_SESSION['user_id']))
{
    unset($_SESSION['user_id']);
    session_unset();
    session_destroy();
}
if (isset($_COOKIE['PHPSESSID'])) {
    setcookie('PHPSESSID', '', time() - 3600, '/'); // Delete the cookie
}
header("Location:../sign_in/sign_in.html");
die;


?>