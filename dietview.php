<?php
include('database/conn.php');

// Check if the request is an AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Query to fetch data based on the selected user ID
    $query = "SELECT * FROM `user_items` WHERE `user_id`='$userId'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$data['user_id']}</td>";
            echo "<td>{$data['item_id']}</td>";
            echo "<td>{$data['cart_id']}</td>";
            echo "<td>{$data['Day']}</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No records found</td></tr>";
    }
    exit;
}

// Include the header only for non-AJAX requests
require("Dietitianheader.php");
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
    </style>
</head>
<body>
    <div class="container">
        <div class="table-container">
            <h2>Customers Review Diet Plans:</h2>
            <br>
            <!-- Dropdown List -->
            <label for="userDropdown">Select User:</label>
            <select id="userDropdown" name="userDropdown" style="margin-left= 10px; padding: 10px; font-size: 16px; border: 2px solid #4CAF50; border-radius: 5px; background-color: #f1f1f1; color: #333;">
                <option value="">Select User</option>
                <?php
                // Query to fetch customer_ids from customer_infos where pending=1
                $query_users = "SELECT `customer_id` FROM `customer_infos` WHERE `pending`='1'";
                $result_users = mysqli_query($con, $query_users);

                // Check if query was successful
                if ($result_users && mysqli_num_rows($result_users) > 0) {
                    while ($row = mysqli_fetch_assoc($result_users)) {
                        $userId = $row['customer_id'];

                        // Query to fetch username from user table using customer_id
                        $query_username = "SELECT `username` FROM `user` WHERE `id`='$userId'";
                        $result_username = mysqli_query($con, $query_username);

                        if ($result_username && mysqli_num_rows($result_username) > 0) {
                            $username_data = mysqli_fetch_assoc($result_username);
                            $username = $username_data['username'];

                            echo "<option value='$userId'>$username</option>";
                        } else {
                            echo "<option value='$userId'>User ID $userId (No username found)</option>";
                        }
                    }
                } else {
                    echo "<option value=''>No users found</option>";
                }
                ?>
            </select>
            <br><br>
            <!-- Table -->
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Item ID</th>
                        <th>Cart ID</th>
                        <th>Day</th>
                    </tr>
                </thead>
                <tbody id="userData">
                    <tr><td colspan='4'>Select a user to view data</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('userDropdown').addEventListener('change', function() {
            var userId = this.value;
            if (userId === '') {
                document.getElementById('userData').innerHTML = '<tr><td colspan="4">Select a user to view data</td></tr>';
                return;
            }
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('userData').innerHTML = xhr.responseText;
                }
            };
            xhr.send('userId=' + userId);
        });
    </script>
</body>
</html>
