<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="Css/footer.css">
</head>
<body style="background-color:white;">
<?php
        session_start();
        // Make sure to include the database connection file
        include('database/conn.php'); 
        require("Userheader.php");
    ?>
    <div style="display:flex;">
        <div>
            <img src="Images/Icons/bmi-chart2.jpg" style="height: 450px;width:650px;margin-top:20px;">
        </div>
        <center>
            <div style="width:600px;height:300px;float:left;padding-left:100px;">
                <form method="post">
                    <input required style="width:400px; margin-top:100px;" type="text" name="weight" placeholder="Enter your weight(kg)"><br>
                    <input required style="width:400px;" type="text" name="height" placeholder="Enter your height(m)"><br><br>
                    <input style="width:100px; border-type:null;background-color:rgb(0, 128, 74);color:white;cursor:pointer" type="submit"><br><br>
                    <h2 style="font-family: Arial, Times, serif;">Your Result</h2><br>
                </form>
                <div style="width:400px; height:50px;background-color:rgb(0, 128, 74);padding-top:10px;">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $weight = isset($_POST["weight"]) ? (float)$_POST["weight"] : 0;
                        $height = isset($_POST["height"]) ? (float)$_POST["height"] : 0;
                    
                        // Perform the BMI calculation
                        $result = $weight / ($height * $height);
                    
                        if ($result < 18.5) {
                            echo "<h2 style='font-family: Arial; color:white;'> Underweight!</h2>";
                        } elseif ($result >= 18.5 && $result <= 24.9) {
                            echo "<h2 style='font-family: Arial; color:white;'>Normal Weight</h2>";
                        } elseif ($result >= 25 && $result <= 29.9) {
                            echo "<h2 style='font-family: Arial; color:white;'> Overweight!</h2>";
                        } elseif ($result >= 30 && $result <= 34.9) {
                            echo "<h2 style='font-family: Arial; color:white;'> Obese!</h2>";
                        } elseif ($result >= 35 && $result <= 39.9) {
                            echo "<h2 style='font-family: Arial; color:white;'> Extremely Obese!</h2>";
                        }
                    }
                    ?>
                </div><br>
                <a href="informations.php"><button style="border-radius: 15px;background-color:rgb(0, 128, 74);;color:white;">Start your journey</button></a>
            </div>
        </center>
    </div><br><br><br>
    <?php require("footer.php"); ?>
</body>
</html>
