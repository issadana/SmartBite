<?php
include('database/conn.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Retrieve data from SESSION
$userid = $_SESSION["done"];
$cartid = $_SESSION["done2"];

$token = bin2hex(random_bytes(16));
                                    
$_SESSION['user_sessions'][$token] = [
    'userid' => $userid,
    'cartid' => $cartid
];

// Function to fetch item ID from database securely
function fetchItemId($con, $itemName) {
    $stmt = $con->prepare("SELECT id FROM items WHERE name = ?");
    if ($stmt === false) {
        die('Database prepare failed: ' . $con->error);
    }
    $stmt->bind_param("s", $itemName);
    if (!$stmt->execute()) {
        die('Execution failed: ' . $stmt->error);
    }
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    return $data['id'] ?? null;
}

// Function to insert user item into database
function insertUserItem($con, $userid, $itemId, $cartId, $day) {
    $stmt = $con->prepare("INSERT INTO user_items(user_id, item_id, cart_id, Day) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $userid, $itemId, $cartId, $day);
    if (!$stmt->execute()) {
        die('Error inserting item: ' . $stmt->error);
    }
    $stmt->close();
}

// Validate POST data and process
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize POST data
    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
    $cartid = filter_input(INPUT_POST, 'cartid', FILTER_SANITIZE_STRING);
    $totalPrice = filter_input(INPUT_POST, 'totalPrice', FILTER_SANITIZE_STRING);

    // Define required fields
    $requiredFields = ['breakfast', 'lunch', 'snack', 'shakes', 'dinner', 'dessert', 'Day'];

    // Check if all required fields are filled
    $dataComplete = true;
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $dataComplete = false;
            break;
        }
    }

    // If all required data is complete
    if ($userid && $cartid && $totalPrice && $dataComplete) {
        echo "User ID: " . htmlspecialchars($userid, ENT_QUOTES, 'UTF-8') . "<br>";
        echo "Cart ID: " . htmlspecialchars($cartid, ENT_QUOTES, 'UTF-8') . "<br>";
        echo "Total Price: " . htmlspecialchars($totalPrice, ENT_QUOTES, 'UTF-8') . "<br>";

        // Fetch and sanitize item names from POST
        $breakfast = $_POST['breakfast'];
        $lunch = $_POST['lunch'];
        $snack = $_POST['snack'];
        $shake = $_POST['shakes'];
        $dinner = $_POST['dinner'];
        $dessert = $_POST['dessert'];
        $Day = $_POST['Day'];

        // Check if the day already exists
        $query = "SELECT Day FROM user_items WHERE user_id = ? AND cart_id = ? AND Day = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("iis", $userid, $cartid, $Day);
        if (!$stmt->execute()) {
            die('Error checking day: ' . $stmt->error);
        }
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo "<script type='text/javascript'>
                alert('The day you are trying to insert already exists.');
                window.location.href = 'diet.php?token=$token';
            </script>";
            $stmt->close();
            exit;
        }
        $stmt->close();

        // Fetch item IDs from database
        $id1 = fetchItemId($con, $breakfast);
        $id2 = fetchItemId($con, $snack);
        $id3 = fetchItemId($con, $lunch);
        $id4 = fetchItemId($con, $shake);
        $id5 = fetchItemId($con, $dinner);
        $id6 = fetchItemId($con, $dessert);

        // Insert user items if IDs are valid
        if ($id1) insertUserItem($con, $userid, $id1, $cartid, $Day);
        if ($id2) insertUserItem($con, $userid, $id2, $cartid, $Day);
        if ($id3) insertUserItem($con, $userid, $id3, $cartid, $Day);
        if ($id4) insertUserItem($con, $userid, $id4, $cartid, $Day);
        if ($id5) insertUserItem($con, $userid, $id5, $cartid, $Day);
        if ($id6) insertUserItem($con, $userid, $id6, $cartid, $Day);

        // Fetch the current total price from the cart
        $stmt = $con->prepare("SELECT price FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userid);
        if (!$stmt->execute()) {
            die('Error fetching current total price: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        $currentPrice = 0;
        if ($row = $result->fetch_assoc()) {
            $currentPrice = $row['price'];
        }
        $stmt->close();
        // Calculate the new cumulative total price
        $newTotalPrice = $currentPrice + $totalPrice;

        // Update cart table securely
        $stmt = $con->prepare("UPDATE cart SET price = ? WHERE user_id = ?");
        $stmt->bind_param("di", $newTotalPrice, $userid);
        if (!$stmt->execute()) {
            die('Error updating cart: ' . $stmt->error);
        }
        $stmt->close();

        // Check if diet plan is completed based on time plan
        $query1 = "SELECT time_plan FROM customer_infos WHERE customer_id = ? AND id = (SELECT MAX(id) FROM customer_infos WHERE customer_id = ?)";
        $stmt = $con->prepare($query1);
        $stmt->bind_param("ii", $userid, $userid);
        if (!$stmt->execute()) {
            die('Error fetching time plan: ' . $stmt->error);
        }
        $result1 = $stmt->get_result();
        $data1 = $result1->fetch_assoc();
        $time = $data1['time_plan'];
        $stmt->close();

        // Query to count user items based on time plan
        $requiredCount = ($time == "Monthly") ? 180 : (($time == "Weekly") ? 42 : 0);
        $query2 = "SELECT COUNT(*) AS row_count FROM user_items WHERE user_id = ? AND cart_id = ?";
        $stmt = $con->prepare($query2);
        $stmt->bind_param("ii", $userid, $cartid);
        if (!$stmt->execute()) {
            die('Error counting user items: ' . $stmt->error);
        }
        $result2 = $stmt->get_result();
        $data2 = $result2->fetch_assoc();
        $count = $data2['row_count'];
        $stmt->close();

        // Update pending status based on count
        if ($count >= $requiredCount) {
            $query3 = "UPDATE customer_infos SET pending = 0 WHERE customer_id = ?";
            $stmt = $con->prepare($query3);
            $stmt->bind_param("i", $userid);
            if (!$stmt->execute()) {
                die('Error updating pending status: ' . $stmt->error);
            }
            $stmt->close();
            echo "<script type='text/javascript'>
                alert('Diet Plan has ended!');
                window.location.href = 'dietitianCustomers.php';
            </script>";
        }

        // Redirect to success page after processing
        echo "<script type='text/javascript'>
            alert('Information submitted successfully!');
            window.location.href = 'diet.php?token=$token';
        </script>";
    } else {
        echo "Invalid data received or not all fields are filled.";
        echo "<script type='text/javascript'>
            alert('Please fill in all the information.');
            window.location.href = 'diet.php?token=$token';
        </script>";
    }
} else {
    echo "No data received.";
}
?>