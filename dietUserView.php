<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* style.css */
        .day-table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .day-table th {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: left;
            font-size: 1.2em;
        }

        .day-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .day-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .day-table tr:nth-child(odd) {
            background-color: #fff;
        }

        .day-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .message {
            text-align: center;
            margin: 20px;
            font-size: 1.2em;
            color: red;
        }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="Css/footer.css">
</head>
<body>
    <?php require("Userheader.php"); ?>

    <h1>Your Items</h1>

    <?php
    include('database/conn.php');
    error_reporting(0);
    session_start();
    $userid = $_SESSION['user_info']['id'];

    $query = "SELECT * FROM user_items WHERE user_id = $userid ORDER BY cart_id";

    $result = mysqli_query($con, $query);

    $items_by_day = array();

    // Fetch all items and group them by day
    while ($data = mysqli_fetch_assoc($result)) {
        $id = $data['item_id'];
        $day = $data['Day'];
        $cartid = $data['cart_id'];

        $query2 = "SELECT name FROM items WHERE id = $id";
        $result2 = mysqli_query($con, $query2);
        $data2 = mysqli_fetch_assoc($result2);
        $name = $data2['name'];

        if (!isset($items_by_day[$day])) {
            $items_by_day[$day] = array();
        }
        $items_by_day[$day][] = $name;
    }

    // Check if there are no items
    if (empty($items_by_day)) {
        echo "<div class='message'>Your plan isn't ready yet! Please come back later.</div>";
    } else {
        // Sort the array by day keys
        ksort($items_by_day);

        // Print the items grouped by day in tables
        foreach ($items_by_day as $day => $items) {
            echo "<table class='day-table'>";
            echo "<thead><tr><th>Day $day</th></tr></thead>";
            echo "<tbody>";
            foreach ($items as $item) {
                echo "<tr><td>$item</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
    }

    require("footer.php");
    ?>
</body>
</html>
