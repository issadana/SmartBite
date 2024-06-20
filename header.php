<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<header>
        <div class="logo">
          <img
            id="header-img"
            src="Images/Icons/LOGO.jpg"
            alt="smartbite logo"
          >
          
        <a href="index.php">SmartBite</a></div>
        </div>

        <div id="nav-bar">
        <ul>
            <?php 
            // Start session
            session_start();
            // Check if user is logged in
            if(isset($_SESSION['user_info'])) {
                // Check user role and display appropriate links
                if($_SESSION['user_info']['role'] == "admin" && $_SESSION['user_info']['login_status'] == "1") {
                  require("Adminheader.php"); 
                } else if($_SESSION['user_info']['role'] == "dietitian" && $_SESSION['user_info']['login_status'] == "1") {
                  require("Dietitianheader.php"); 
                }else if($_SESSION['user_info']['role'] == "user" && $_SESSION['user_info']['login_status'] == "1") {
                  require("Userheader.php"); 
                }
            }else {
              // If user is not logged in, display login link
              echo '<li><a class="nav-link" href="login.php">LOGIN</a></li>';
              echo '<li><a class="nav-link" href="checkMenu.php">MENU</a></li>';
              echo '<li><a class="nav-link" href="register.php">SIGN UP</a></li>';
            }
          
            ?>
        </ul>
    </div>

</header>
</body>
</html>

