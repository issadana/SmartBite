<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css\style.css">
    <link rel="stylesheet" href="Css\footer.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

</head>

<body>
    <?php require("header.php"); ?>
    <center>
        <div style="max-width:600px" class="container">
            <div class="box">
                <br>
                <h1>Login</h1>
                <br>
                <form action="login_action.php" method="post">
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" required>
                        <i class="bx bx-envelope"></i>
                    </div>
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                        <i class="bx bx-lock-alt"></i>
                        <?php
                         if(isset($_GET['error']))
                         {
                             $i = $_GET['error'];
                             ?>
                             <script>
                                alert("Please check Username and Password");
                             </script>
                             <?php
                         }
                         ?>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login" required>
                    </div>
                    <div class="links">
                        Don't have account? <a href="register.php">Sign Up Now</a>
                    </div>

                </form>
            </div>    
        </div>
    </center>

    
</body>
<?php require("footer.php"); ?>
</html>