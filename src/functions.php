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
    //echo "Login success";
}

function get_login_info($con)
{
    if (isset($_SESSION['email'])) {
        $id = $_SESSION['email'];
        // Prepared statement to prevent SQL injection
        $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }
}

function get_user_data($user_id, $con){
    $query = "SELECT * FROM users WHERE id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}