<?php 
    include('database/conn.php');
    session_start(); 

    // Function to fetch and display customers users
    function displayCustomersUsers($con) {
        $query = "SELECT * FROM `user` WHERE `role` = 'user'";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0) {
            while($data = mysqli_fetch_assoc($result)) {
                $_SESSION['customers'] = $data; // Set user data in session
                
                echo "<tr>";
                echo "<td>{$data['id']}</td>";
                echo "<td>{$data['username']}</td>";
                echo "<td>{$data['email']}</td>";
                echo "<td>{$data['password']}</td>";
                echo "<td>{$data['age']}</td>";
                echo "<td>{$data['role']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }
    }

    // Function to fetch and display customers users
    function displayCustomersMessages($con) {
        $query = "SELECT * FROM `messages`";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0) {
            while($data = mysqli_fetch_assoc($result)) {
                $_SESSION['customers'] = $data; // Set user data in session
                
                echo "<tr>";
                echo "<td>{$data['id']}</td>";
                echo "<td>{$data['username']}</td>";
                echo "<td>{$data['email']}</td>";
                echo "<td>{$data['message']}</td>";
                echo "<td>{$data['rating']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }
    }
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
        /* Custom styles for layout */
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        .input-fields, .table-container {
            flex: 1;
            margin: 0 20px;
        }
        .input-fields label, .input-fields input {
            display: block;
            margin-bottom: 10px;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000; /* Outer border */
        }
        .table-container th, .table-container td {
            border: 1px solid #000; /* Inner border */
            padding: 8px;
            text-align: left;
        }
        .table-container th {
            background-color: #f2f2f2;
        }
        .btn {
            display: block;
            margin: 10px 10px;
            padding: 6px;
            background-color: rgb(0, 128, 74);
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
    
</head>
<body>
    <?php require("Adminheader.php"); ?>
    <center>
    <div class="container">
        <div class="table-container">
            <h2>Customers Informations: </h2>
            <br>
            <!-- Table -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Age</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php displayCustomersUsers($con); ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <h2>Customers Messages & Ratings: </h2>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php displayCustomersMessages($con); ?>
                </tbody>
            </table>
        </div>
    </div>
    </center>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php require("footer.php"); ?>
</body>
</html>