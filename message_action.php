<?php
    error_reporting(E_ALL); // Enable all errors for development. Change to a lower level or turn off in production.
    include('database/conn.php'); 
    session_start();

    if (isset($_SESSION['user_info']) && isset($_POST['contact'])) {
        $username = $_SESSION['user_info']['username'];
        $email = $_SESSION['user_info']['email'];
        $message = $_POST['contact'];

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $con->prepare("INSERT INTO messages (`username`, `email`, `message`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $message);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Message Sent Successfully!";
            $stmt->close();
            header("Location: contact.php");
            exit(); // Make sure to exit after redirect
        } else {
            $stmt->close();
            header("Location: contact.php?error=1");
            exit(); // Make sure to exit after redirect
        }
    } else {
        header("Location: contact.php?error=2");
        exit(); // Redirect if session info or POST data is missing
    }
?>
