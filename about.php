<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css\style.css">
    <link rel="stylesheet" href="Css/footer.css">
    
    <style>
        body{
            background: white;
        }
        
        /* Style for the image */
        #wallpaper-img {
            float: right;
            width: 50%;
            padding: 0px;
            box-sizing: border-box;
            background: white;
        }

        #wallpaper-img img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* Style for the paragraph */
        #about-paragraph {
            float: left;
            width: 50%;
            padding: 20px;
            padding-top: 50px;
            box-sizing: border-box;
            background-color: white;
            
        }

        #about-paragraph p {
            font-family: Arial, sans-serif;
            font-size: 25px;
            line-height: 1.5;
            color: black;
            margin: 0;
            padding: 0;
        }
    </style>
    
    
</head>
<body>
    <?php require("Userheader.php"); ?>
    <div id="wallpaper-img">
        <img src="Images\Icons\avocat.jpg">
    </div>
    <div id="about-paragraph">
        <p>
            At SmartBite, our mission is to empower you to make healthier food choices effortlessly.
            <br><br>
            We believe that a balanced diet is the cornerstone of a vibrant and fulfilling life.
            <br><br>
            Discover thousand of delicious and nutritious recipes, plan your meals with ease, track your daily intake and learn from expert nutritionists-all within a single, user-friendly app.
            <br><br>
            By using SmartBite, you will gain the tools and knowledge to boost your energy levels, manage your weight, and improve your overall well-being.
            <br><br>
            Our app is developed in collaboration with certified dietitians and nutrition experts, ensuring that you will have the opportunity to follow a diet plan well designed by our team .
            <br><br>
            We're here to assist you on your healthy eating journey.
            <br>Reach out to our support team anytime for assistance or feedback.
            <br><br>
            Stay in the loop about the latest features and healthy food by following us on social media. 
            </p>
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php require("footer.php"); ?>
</body>

</html>