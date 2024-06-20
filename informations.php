<?php
    include('database/conn.php');
    error_reporting(0); 
    session_start();

    $userid=$_SESSION['user']['id'];
    //echo"$userid";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>informations</title>
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="Css/footer.css">

    <style>
        body {
            background-image: url("Images/Icons/leaf1.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
        h2{
            padding: 8px;
        }
        .form-group {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="range"] {
            width: 200px;
            height: 40px;
        }
    </style>
</head>
<body>
    <?php require("Userheader.php");?>
    <div style="margin-left:20px;">
        <h2>Please fill out this page to proceed</h2><br>

        <form action="information_action.php" method="post">
            <div class="form-group">
                <label for="weight">Weight</label>
                <input required type="text" name="weight" id="weight">
            
                <label for="height">Height</label>
                <input required type="text" name="height" id="height">
            
                <label for="age">Age</label>
                <input required type="text" name="age" id="age">
            
                <label for="activities">Activities</label>
                <input required type="range" name="activities" id="activities">
            
                <label for="intolerances">Intolerances</label>
                <input required type="text" name="intolerances" id="intolerances">
            
                <label for="likes">Likes</label>
                <input required type="text" name="likes" id="likes">
            
                <label for="dislikes">Dislikes</label>
                <input required type="text" name="dislikes" id="dislikes">
            
                <label for="time">Time plan</label>
                <select required name="time" id="time" style="width: 200px;height: 40px;border-radius:15px;">
                    <option value="Monthly">Monthly</option>
                    <option value="Weekly">Weekly</option>
                </select>
            
                <label for="plan">Diet plan</label>
                <select required name="plan" id="plan" style="width: 200px;height: 40px;border-radius:15px;">
                    <option value="Gain Weight">Gain Weight</option>
                    <option value="Maintain Weight">Maintain Weight</option>
                    <option value="Loose Weight">Loose Weight</option>
                </select>
            </div>

            <input type="submit" value="Next" style="cursor: pointer;margin-bottom:30px;float:right; width:200px; height:40px;background-color:rgb(0, 128, 74);color:white;font-size: 18px">
        </form>
    </div><br><br><br>

    
</body>
</html>
