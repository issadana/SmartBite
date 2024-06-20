<?php
    include('database/conn.php');
    $username=$_POST['username']; //function post takes the name of the element 
    $email=$_POST['email'];
    $pass=$_POST['password'];
    $age=$_POST['age'];

    $query="INSERT INTO `user`(`username`, `email`, `password`, `age`,`role`,`login_status`) VALUES ('$username','$email','$pass','$age','user','0')";
    mysqli_query($con,$query); 

    header("location: login.php"); 
    
?>