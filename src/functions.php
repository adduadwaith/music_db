<?php

function check_login($con){
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // If not logged in, redirect to login page
        header("Location: ../sign_in/sign_in.html");
        exit();
    }
    // Check if session cookie is set
    if (!isset($_COOKIE['PHPSESSID'])) {
        // If session cookie is not set, redirect to login page
        header("Location: ../sign_in/sign_in.html");
        exit();
    }
    echo "Login success";
}