<?php
session_start();

if(isset($_SESSION['user_id']))
{
    unset($_SESSION['user_id']);
}
header("Location:../sign_in/sign_in.html");
die;


?>