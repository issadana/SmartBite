<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="Css/footer.css">
</head>
<body>
    
</body>
</html>
<?php
    include('database/conn.php');
    require("header.php");
    error_reporting(0);
    session_start();
    $userid = $_SESSION['user']['id'];

    $query = "SELECT * FROM user_items WHERE user_id = $userid ORDER BY cart_id";

    $result = mysqli_query($con, $query);

    $items_by_day = array();

    // Fetch all items and group them by day
    while ($data = mysqli_fetch_assoc($result)) {
        $id = $data['item_id'];
        $day = $data['Day'];
        $cartid=$data['cart_id'];

        
    
        $query2 = "SELECT name FROM items WHERE id = $id";
        $result2 = mysqli_query($con, $query2);
        $data2 = mysqli_fetch_assoc($result2);
        $name = $data2['name'];

        if (!isset($items_by_day[$day])) {
            $items_by_day[$day] = array();
        }
        $items_by_day[$day][] = $name;
    }

    // Sort the array by day keys
    ksort($items_by_day);

    // Print the items grouped by day with space between each day
    foreach ($items_by_day as $day => $items) {
        echo "<div style='margin-bottom: 20px;margin-left:20px;'>";
        echo "$day:<br>";
        foreach ($items as $item) {
            echo "- $item<br>";
            //echo"total price=:"
        }
        echo "</div>";
    }
    require("footer.php");
?>
