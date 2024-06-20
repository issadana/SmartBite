<?php 
    include('database/conn.php'); 
    session_start();
    error_reporting(0);
    
    $userid=$_SESSION['user_info']['id'];
    $query = "INSERT INTO `cart` (`user_id`,`date`) VALUES ('$userid',NOW())";
    mysqli_query($con, $query);
    $query1="SELECT * FROM `cart` WHERE `user_id`='$userid'";
    $result = mysqli_query($con, $query1);
    $row_num= mysqli_num_rows($result);
    if($row_num>0)
    {
        $data= mysqli_fetch_assoc($result);
        $_SESSION['cart_info']=$data;
        $cartid = $data['id'];

        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $age = $_POST['age'];
        $activities = $_POST['activities'];
        $intolerances = $_POST['intolerances'];
        $likes = $_POST['likes'];
        $dislikes = $_POST['dislikes'];
        $time=$_POST['time'];
        $plan = $_POST['plan'];

        $query2 = "INSERT INTO `customer_infos` (`customer_id`, `dietcart_id`, `weight`, `height`, `age`, `physical_activity`, `intolerances`, `likes`, `dislikes`,`plan_choice`, `time_plan`, `pending`) 
                VALUES ('$userid', '$cartid', '$weight', '$height', '$age', '$activities', '$intolerances', '$likes', '$dislikes','$plan', '$time','1')";
        mysqli_query($con, $query2);   
    }
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
                padding: 10px;
            }
            .form-group {
                margin: 10px;
            }
            label {
                display: block;
                margin-bottom: 5px;
            }
            input[type="text"], input[type="range"] {
                width: 200px;
                height: 40px;
            }
            .payment-option {
                display: flex;
                align-items: center;
            }
            .payment-option input[type="radio"] {
                margin-right: 10px;
            }
        </style>
    </head>
    <body>
        <?php require("Userheader.php");?>
        <h2>To Continue We Kindly Ask You To Complete Your Checkout Informations.</h2><br>

        <div style="display:flex;margin-left:20px;">
            

            <form action="more_information.php" method="post">
                <div style="width: 400px; height: 450px;float:left;">
                    <div class="form-group">
                        <label for="Name">Full Name</label>
                        <input required type="text" name="Name" id="Name">
                    
                        <label for="Email">Email Address</label>
                        <input required type="text" name="Email" id="Email">

                        <label for="Phone">Phone Number</label>
                        <input required type="text" name="Phone" id="Phone">

                        <label for="Date">Date Of Birth</label>
                        <input required type="Date" name="Date" id="Date" style="width: 200px;height: 40px;">

                        <label for="city">City</label>
                        <input required type="text" name="city" id="city">
                    </div>
                </div>
            <div style="width: 400px; height: 450px;float:left;">
                <div class="form-group">
                    <label for="Address">Address</label>
                    <input required type="text" name="Address" id="Address">
                    
                    <label for="zip">Zip Code</label>
                    <input required type="text" name="zip" id="zip">

                    <label for="CardNumber">Card Number</label>
                    <input required type="text" name="CardNumber" id="CardNumber">

                    <label for="Expiration">Expiration Date</label>
                    <input required type="Date" name="Expiration" id="Expiration" style="width: 200px;height: 40px;">

                    <label for="Code">Security Code</label>
                    <input required type="text" name="Code" id="Code">
                </div>
            </div>
            <center>
                <button type="submit" style="margin-right: 180px; width: 200px; height: 50px; background-color: rgb(0, 128, 74); color: white; font-size: 20px; border-radius: 15px;">Submit</button>
            </center>
            </form>
        
        </div>
</body>
</html>

