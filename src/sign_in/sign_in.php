<?php

use LDAP\Result;

session_start();
include("../connection.php");

if($_SERVER['REQUEST_METHOD']=="POST")
{
    //SOMETHING WAS POSTED
    $email=$_POST['email'];
    $password=$_POST['password'];
    //$password=md5($password);


    if(!empty($email)&& !empty($password))
    {
        //read from the database
        
        $query="select * from users where email='$email' and password='$password' limit 1";
        
        $result=mysqli_query($conn,$query);

        if($result)
        {

            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                
                if($user_data['password']=== $password)
                {
                    // Set session variables
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;

                    // Optionally set a cookie to store the session ID (PHP does this automatically with session_start)
                    // but you can customize it:
                    setcookie("PHPSESSID", session_id(), time() + (86400), "/"); // 86400 = 1 day
                    // Set a cookie to store user ID for 1 day
                    setcookie("user_id", $user_data['id'], time() + (86400), "/"); // 86400 = 1 day
                    setcookie("user_name", $user_data['firstname'], time() + (86400), "/"); // 86400 = 1 day

                    header('Location:../homepage/homepage.php');
                    die;
                }
            }

        }
        //echo $email;
        //echo $password;
        echo "wrong email or password"; 
      
    }
    else{
        echo "please enter some valid information"; 
    }
}

?>


