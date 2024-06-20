<?php
error_reporting(E_ALL); // Enable all errors for development. Change to a lower level or turn off in production.
include('database/conn.php'); 
session_start();

if (isset($_SESSION['user_info']) && isset($_POST['opinion'])) {
    $username = $_SESSION['user_info']['username'];
    $email = $_SESSION['user_info']['email'];
    $rating = $_POST['opinion'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO messages (`username`, `email`, `rating`) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $rating);

    if ($stmt->execute()) {
        $stmt->close();
        $_SESSION['message'] = "Rating Sent Successfully !";
        header("Location: rate.php");
        exit(); // Make sure to exit after redirect
    } else {
        $stmt->close();
        header("Location: rate.php?error=1");
        exit(); // Make sure to exit after redirect
    }
} else {
    header("Location: rate.php?error=2");
    exit(); // Redirect if session info or POST data is missing
}
?>
