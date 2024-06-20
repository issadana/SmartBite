<?php
    error_reporting(0);
    include('database/conn.php'); 
    session_start();

    $email=$_POST['email']; 
    $pass=$_POST['password'];


    $query="SELECT * FROM `user` WHERE `email` LIKE '$email' AND `password` LIKE '$pass'";
    $result = mysqli_query($con,$query);
    $row_num= mysqli_num_rows($result);

    if($row_num>0)
    {
        $data= mysqli_fetch_assoc($result);
        $_SESSION['user_info']=$data;
        $userid = $data['id'];
        $username=$data['username'];

        $query1 = "UPDATE `user` SET `login_status`='1' WHERE `id`='$userid'";
        mysqli_query($con,$query1);

        if($data['role']== "user")
        {
            header("location:user.php");
            exit();
        }elseif($data['role']== "admin"){
            header("location:admin.php");
            exit();
        }else{
            header("location:dietitian.php");
            exit();
        }
    }else{
        header("location:login.php?error=1");
    }

?>