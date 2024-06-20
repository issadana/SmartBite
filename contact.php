<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script>
        function showMessage(message) {
            alert(message);
        }
    </script>
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="Css/footer.css">
    <style>
        .container {
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            background: white;
        }
        .left-section {
            flex: 0 0 auto; /* This ensures the left section doesn't grow or shrink */
        }

        .right-section {
            flex: 1; /* This allows the right section to grow and fill remaining space */
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        h1 {
            margin-right: 300px;
        }
        label {
            margin-right: 20px;
            text-align: center;
        }
        .btn{
            width: 150px;
            margin-left: 280px;
        }
        textarea {
            margin-top: 90px;
            padding: 20px;
            width: 700px; /* Set a specific width for the textarea */
        }
        .button-label {
            display: flex;
            flex-direction: column;
            text-align: center;
        }
    </style>
    
</head>
<body>
    <?php require("Userheader.php"); ?>
    
    <div class="container">
        <div class="left-section">
            <img src="Images/Icons/take care of yourself.jpeg" alt="Take care of yourself">
        </div>
        
        <div class="right-section">
            <h1><i style="text-decoration: underline;">Contact Us</i></h1>
            <form action="message_action.php" method="post">
                <textarea required class="field input" name="contact" cols="20" rows="5" placeholder="Enter your question here..."></textarea>
                <br>
                <div class="button-label">
                    <label>+96170806571</label>
                    <label>BEIRUT, LEBANON</label>
                    <label>info@smartbite.lb</label>
                    <br>
                    <button type="submit" class="btn">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <br><br>
    
    <?php require("footer.php"); ?>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<script type="text/javascript">',
             'showMessage("', $_SESSION['message'], '");',
             '</script>';
        unset($_SESSION['message']); // Clear the message after displaying it
    }
    ?>
</body>
</html>
