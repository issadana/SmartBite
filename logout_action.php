<?php
    include('database/conn.php'); 
    session_start();
    // Assuming $con is your database connection variable
    $userid = $_SESSION['user_info']['id'];
    // Check if user is logged in
    $query = "SELECT `id` FROM `user` WHERE `login_status` = 1";
    $result = mysqli_query($con, $query);
    if (!$result || mysqli_num_rows($result) == 0) {
        header("Location: logout_action.php?error=1");
        exit(); // Added exit() to stop further execution after redirection
    }

    $update_query = "UPDATE `user` SET `login_status` = '0' WHERE `id` = '$userid'";
    mysqli_query($con, $update_query);

    // Unset and destroy session
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session

    // Redirect to login page
    header("Location: login.php");
    exit(); // Added exit() after redirection
?>
