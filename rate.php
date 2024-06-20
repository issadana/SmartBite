<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css\style.css">
	<link rel="stylesheet" href="Css\footer.css">
	<link rel="stylesheet" href="Css\rate.css">
	<title>Document</title>
	<script>
        function showMessage(message) {
            alert(message);
        }
    </script>
	<style>
		body {
			background-image: url('Images/Icons/leaf1.jpg');
			background-size: cover; /* Ensures the image covers the entire background */
			background-position: center; /* Centers the background image */
		}

		.field.input {
			background-color: transparent; /* Sets the background color of the textarea to transparent */
			border: 1px solid #ccc; /* Optional: Add a border for visual distinction */
			resize: vertical; /* Allows vertical resizing of the textarea */
		}
	</style>

</head>
<body>
    <?php require("Userheader.php"); ?>
	<center>
		<div class="rate" style="max-width:600px">
		<br>
			<h1><i style="text-decoration: underline;">Rate Us </i></h1>
			<br>
			<!-- id="ratingForm" for targeting in JavaScript. -->
			<form action="rate_action.php" method="post">
				<textarea required class="field input" name="opinion" cols="30" rows="5" placeholder="Your opinion..."></textarea>
				
				<button type="submit" class="btn">Submit</button>
				
			</form>
		</div>
	</center>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	
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

