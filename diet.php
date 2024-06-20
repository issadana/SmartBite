<?php
    session_start();
    include('database/conn.php');
    require("Dietitianheader.php");

    // Retrieve token from GET request
    $token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

    // Check if the token is valid and exists in the session
    if (isset($_SESSION['user_sessions'][$token])) {
        $userid = $_SESSION['user_sessions'][$token]['userid'];
        $cartid = $_SESSION['user_sessions'][$token]['cartid'];
    } else {
        die("Invalid or expired session token.");
    }
    $_SESSION['done'] = $userid;
    $_SESSION['done2'] = $cartid;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Plan</title>
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="Css/footer.css">
    
    <style>
        /* Custom styles for layout */
        .container {
            display: flex;
            justify-content: space-between;
            padding: 50px;
        }
        .input-fields {
            flex: 1;
            margin-right: 20px;
        }
        .input-fields label, .input-fields input {
            display: block;
            margin-bottom: 10px;
            width: 200px; /* Adjust width of input fields */
        }
        .table-container {
            flex: 2; /* Increase width of table container */
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
            cursor: pointer; /* Add cursor pointer to indicate clickable rows */
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
        .hidden {
            display: none;
        }
    </style>

    <script>
        var previousPrice = 0;

        function insertName(name, category, price) {
            var inputs = document.querySelectorAll('.input-fields input:not([type="submit"])');
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].id === category.toLowerCase()) {
                    if (inputs[i].value !== '') {
                        updateTotalPrice(-previousPrice);
                    }
                    inputs[i].value = name;
                    previousPrice = parseFloat(price);
                    break;
                }
            }
            updateTotalPrice(price);
        }

        function updateTotalPrice(price) {
            var totalPriceInput = document.getElementById('totalPrice');
            var currentTotal = parseFloat(totalPriceInput.value) || 0;
            totalPriceInput.value = (currentTotal + parseFloat(price)).toFixed(2);
        }

        function clearFields() {
            var inputs = document.querySelectorAll('.input-fields input:not([type="submit"])');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = '';
            }
            document.getElementById('totalPrice').value = '';
            previousPrice = 0;
        }

        function submitForm() {
            var form = document.getElementById('priceForm');
            var userid = "<?php echo htmlspecialchars($userid, ENT_QUOTES, 'UTF-8'); ?>";
            console.log("userid is");
            console.log(userid);
            var cartid = "<?php echo htmlspecialchars($cartid, ENT_QUOTES, 'UTF-8'); ?>";
            var totalPrice = document.getElementById('totalPrice').value;

            // Create hidden inputs for userid and cartid
            var useridInput = document.createElement('input');
            useridInput.type = 'hidden';
            useridInput.name = 'userid';
            useridInput.value = userid;
            form.appendChild(useridInput);

            var cartidInput = document.createElement('input');
            cartidInput.type = 'hidden';
            cartidInput.name = 'cartid';
            cartidInput.value = cartid;
            form.appendChild(cartidInput);

            var totalPriceInput = document.createElement('input');
            totalPriceInput.type = 'hidden';
            totalPriceInput.name = 'totalPrice';
            totalPriceInput.value = totalPrice;
            form.appendChild(totalPriceInput);

            form.submit();
        }

    </script>
</head>
<body style="background-color:white;">
    <div class="container">
        <div class="input-fields">
            <form id="priceForm" method="post" action="userDetails.php">
                <label for="breakfast">Breakfast</label>
                <input type="text" name="breakfast" id="breakfast" readonly required>
                <label for="snack">Snack</label>
                <input type="text" name="snack" id="snack" readonly required>
                <label for="lunch">Lunch</label>
                <input type="text" name="lunch" id="lunch" readonly required>
                <label for="shakes">Shakes</label>
                <input type="text" name="shakes" id="shakes" readonly required>
                <label for="dinner">Dinner</label>
                <input type="text" name="dinner" id="dinner" readonly required><br>
                <label for="dessert">Desserts</label>
                <input type="text" name="dessert" id="dessert" readonly required><br>
                <label for="totalPrice">Total Price</label>
                <input type="text" id="totalPrice" name="totalPrice" readonly required>
                <label for="Day">Day</label>
                <input type="text" id="Day" name="Day" required>

                <button type="submit" class="btn" onclick="submitForm()">Submit</button>
                <a href="done.php" style="text-decoration: none;"> <button type="button" class="btn" onclick="done()">Done</button></a>
                <button class="btn" onclick="clearFields()">Clear</button>
            </form>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price ($)</th>
                        <th>Calories</th>
                        <th>Fats (g)</th>
                        <th>Carbs (g)</th>
                        <th>Protein (g)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $query = "SELECT DISTINCT `name`, `category`, `price`, `calories`, `fats`, `carbs`, `protein` FROM `items`";
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0) {
                        while($data = mysqli_fetch_assoc($result)) {
                            $name = htmlspecialchars($data['name']);
                            $category = htmlspecialchars($data['category']);
                            $price = $data['price'];
                            echo "<tr onclick=\"insertName('$name', '$category', '$price')\">";
                            echo "<td>$name</td>";
                            echo "<td>$category</td>";
                            echo "<td>{$data['price']}</td>";
                            echo "<td>{$data['calories']}</td>";
                            echo "<td>{$data['fats']}</td>";
                            echo "<td>{$data['carbs']}</td>";
                            echo "<td>{$data['protein']}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No items found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

<?php require("footer.php"); ?>

</body>
</html>
