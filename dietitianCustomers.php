<?php
    require("Dietitianheader.php"); 
    include('database/conn.php'); 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="Css/footer.css">
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
    <div class="container">
        <div class="table-container">
            <h2>Customers Informations:</h2>
            <br>
            <!-- Table -->
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>Age</th>
                        <th>Activities</th>
                        <th>Intolerances</th>
                        <th>Likes</th>
                        <th>Dislikes</th>
                        <th>Time Plan</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    error_reporting(0);
                    session_start();
                    include('database/conn.php');

                    // Query to select pending customer info
                    $redirectToken = '';

                    // Check if there are pending customer info
                    $query = "SELECT * FROM `customer_infos` WHERE `pending`='1'";
                    $result = mysqli_query($con, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            $id = $data['customer_id'];
                            $cartid = $data['dietcart_id'];
                    
                            // Query to get username
                            $query2 = "SELECT `username` FROM `user` WHERE `id` = '$id'";
                            $result2 = mysqli_query($con, $query2);
                    
                            if (mysqli_num_rows($result2) > 0) {
                                while ($data2 = mysqli_fetch_assoc($result2)) {
                                    $name = $data2['username'];
                    
                                    // Generate a unique token for session storage
                                    $token = bin2hex(random_bytes(16));
                                    
                                    $_SESSION['user_sessions'][$token] = [
                                        'userid' => $id,
                                        'cartid' => $cartid
                                    ];
                    
                                    // Store the token in a variable for later use
                                    $redirectToken = $token;
                                    
                    
                                    echo "<tr>";
                                    echo "<td><a href='diet.php?token=$token'>$name</a></td>";
                                    echo "<td>{$data['weight']}</td>";
                                    echo "<td>{$data['height']}</td>";
                                    echo "<td>{$data['age']}</td>";
                                    echo "<td>{$data['physical_activity']}</td>";
                                    echo "<td>{$data['intolerances']}</td>";
                                    echo "<td>{$data['likes']}</td>";
                                    echo "<td>{$data['dislikes']}</td>";
                                    echo "<td>{$data['time_plan']}</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    } else {
                        echo "<tr><td colspan='9'>No records found</td></tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
