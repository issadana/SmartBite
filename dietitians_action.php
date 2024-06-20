<?php
    include('database/conn.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $age = $_POST['age'];
            $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

            // Check if any required fields are empty
            if (empty($username) || empty($email) || empty($pass) || empty($age) || empty($gender)) {
                $_SESSION['error'] = "Please fill out all fields.";
            } else {
                switch ($action) {
                    case 'Edit':
                        handleEdit($con, $id, $username, $email, $pass, $age, $gender);
                        header("Location: dietitians.php");
                        exit();
                        break;
                    case 'Add':
                        if (!dietitianExists($con, $email)) {
                            handleAdd($con, $username, $email, $pass, $age, $gender);
                        } else {
                            $_SESSION['error'] = "Dietitian with this email already exists.";
                        }
                        header("Location: dietitians.php");
                        exit();
                        break;
                    case 'Delete':
                        if (!empty($id)) {
                            handleDelete($con, $id);
                        } else {
                            $_SESSION['error'] = "ID is required to delete.";
                        }
                        header("Location: dietitians.php");
                        exit();
                        break;
                    case 'Clear':
                        handleClear($id, $username, $email, $pass, $age, $gender);
                        header("Location: dietitians.php");
                        break;
                    default:
                        $_SESSION['error'] = "Invalid action";
                }
            }
        } else {
            $_SESSION['error'] = "Action parameter not set.";
        }
    }

    function dietitianExists($con, $email) {
        $query = "SELECT * FROM `user` WHERE `email` = '$email' AND `role` = 'dietitian'";
        $result = mysqli_query($con, $query);
        return mysqli_num_rows($result) > 0;
    }

    function handleEdit($con, $id, $username, $email, $pass, $age, $gender) {
        $query = "UPDATE `user` SET `username`='$username', `email`='$email', `password`='$pass', `age`='$age', `gender`='$gender' WHERE `id`='$id'";
        if (mysqli_query($con, $query)) {
            $_SESSION['message'] = "Record edited successfully";
        } else {
            $_SESSION['error'] = "Error updating record: " . mysqli_error($con);
        }
    }

    function handleAdd($con, $username, $email, $pass, $age, $gender) {
        $query = "INSERT INTO `user` (`id`, `username`, `email`, `password`, `age`, `role`, `login_status`, `gender`) VALUES (NULL, '$username', '$email', '$pass', '$age', 'dietitian', '0', '$gender')";
        if (mysqli_query($con, $query)) {
            $_SESSION['message'] = "New record created successfully";
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($con);
        }
    }

    function handleDelete($con, $id) {
        $query = "DELETE FROM `user` WHERE `id`='$id'";
        if (mysqli_query($con, $query)) {
            $_SESSION['message'] = "Record deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting record: " . mysqli_error($con);
        }
    }

    function handleClear(&$id, &$username, &$email, &$pass, &$age, &$gender) {
        $id = $username = $email = $pass = $age = $gender = null;
    }
?>
