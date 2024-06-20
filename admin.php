<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css\style.css">
    <link rel="stylesheet" href="Css\footer.css">
    <style>
        h1{
            border: 3px solid rgb(0, 128, 74);
            background: white;
        }
    </style>
</head>
<body>
    <?php require("Adminheader.php"); ?>
    
    <div class="first-img">
        <center>
        <h1>
            <?php echo "Welcome " . $_SESSION['user_info']['username']; ?>
    
        </h1></center>
        <img src="Images\Icons\leaf1.jpg">
    </div>

    <?php require("footer.php"); ?>
</body>
</html>