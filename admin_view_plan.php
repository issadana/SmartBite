<?php 
    include('database/conn.php');
    session_start(); 

    // Function to fetch and display customers users
    function displayCarts($con) {
        $query = "SELECT * FROM `cart` ";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0) {
            while($data = mysqli_fetch_assoc($result)) {
                $_SESSION['carts'] = $data; // Set user data in session
                
                echo "<tr>";
                echo "<td>{$data['id']}</td>";
                echo "<td>{$data['user_id']}</td>";
                echo "<td>{$data['item_id']}</td>";
                echo "<td>{$data['price']}</td>";
                echo "<td>{$data['date']}</td>";
                echo "<td>{$data['checkout']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
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
            <h2>Customers Diet Carts: </h2>
            <br>
            <!-- Table -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Item ID</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Checkout</th>
                    </tr>
                </thead>
                <tbody>
                    <?php displayCarts($con); ?>
                </tbody>
            </table>
        </div>
    </center>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php require("footer.php"); ?>
</body>
</html>