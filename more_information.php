<?php
    include('database/conn.php'); 
    error_reporting(0);
    session_start();
    $userid=$_SESSION['cart_info']['user_id'];
    //echo($userid);
    $cartid = $_SESSION['cart_info']['id'];
    //echo($cartid);
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $Phone = $_POST['Phone'];
    $dob = $_POST['Date'];
    $City = $_POST['city'];
    $CardNumber= $_POST['CardNumber'];
    $Expiration = $_POST['Expiration'];
    $Code = $_POST['Code'];
    $zipCode=$_POST['zip'];
    $query = "INSERT INTO payment(`cart_id`,`user_id`,`user_email`,`user_username`,`phone`,`dob`,`zip_code`,`city`,`address`,`card_nb`,`exp_year`,`security_code`) VALUES ('$cartid', '$userid', '$Email', '$Name', '$Phone','$dob', '$zipCode', '$City', '$Address', $CardNumber, '$Expiration', '$Code')";
    mysqli_query($con, $query);

    //update set checkout=1 => Payment done
    $query="UPDATE `cart` SET `checkout` = '1' WHERE `user_id` ='$userid' AND `id` = '$cartid'";
    mysqli_query($con,$query);
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="Css/style.css">
        <link rel="stylesheet" href="Css/footer.css">
        <title>Document</title>

        <style>
            body {
                background-image: url("Images/Icons/leaf1.jpg");
                background-repeat: no-repeat;
                background-size: cover;
            }
            h2{
                padding-top: 25px;
                padding-left: 20px;
            }
        </style>
    </head>
    <body>
        <?php require("Userheader.php");?>
        
        <h2>Thank you for choosing us.</h2>
        <h2> Your Diet Plan will be ready within 3 days.</h2><br>
</body>
</html>


