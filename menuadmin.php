<?php  
    session_start();
    include('database/conn.php');

    function getItems($con) {
        $query = "SELECT * FROM `items`";
        $result = mysqli_query($con, $query);

        $items = array();

        if ($result) {
            if(mysqli_num_rows($result) > 0) {
                while($data = mysqli_fetch_assoc($result)) {
                    $items[] = $data;
                }
            }
            mysqli_free_result($result);
        } else {
            echo "Error retrieving items: " . mysqli_error($con);
        }

        return $items;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="Css/footer.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        .clickable-row {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php require("Adminheader.php"); ?>

    <center>
    <div class="container">
        <form action="item_action.php" method="post" enctype="multipart/form-data">
            <div class="input-fields">
                <!-- Form Inputs -->
                <label for="id">ID</label>
                <input type="text" name="id" id="id" readonly> <!-- readonly means not editable -->

                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>
                
                <label for="category">Category</label>
                <select name="category" id="category" style="width: 300px;height: 40px;border-radius:15px;" required>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Dinner">Dinner</option>
                    <option value="Snack">Snack</option>
                    <option value="Shakes">Shakes</option>
                    <option value="Dessert">Dessert</option>
                </select><br><br>

                <label for="price">Price ($)</label>
                <input type="text" name="price" id="price" required>

                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*">
                <img id="image-preview" src="" alt="Image Preview" style="display:none;width:100px;height:100px;"/>

                <label for="calories">Calories</label>
                <input type="text" name="calories" id="calories" required>

                <label for="fats">Fats (g)</label>
                <input type="text" name="fats" id="fats" required>

                <label for="carbs">Carbs (g)</label>
                <input type="text" name="carbs" id="carbs" required>

                <label for="protein">Proteins (g)</label>
                <input type="text" name="protein" id="protein" required>

                <!-- Buttons -->
                <div class="button-group">
                    <input type="submit" class="btn" name="action" value="Edit">
                    <input type="submit" class="btn" name="action" value="Add">
                    <input type="submit" class="btn" name="action" value="Delete">
                </div>
                <div class="button-group">
                    <input type="submit" class="btn" name="action" value="Clear">
                </div>
            </div>
        </form>
        <div class="table-container">
            <h2>Items Information:</h2>
            <br>
            <!-- Table -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Calories</th>
                        <th>Fats</th>
                        <th>Carbs</th>
                        <th>Proteins</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $itemsList = getItems($con);

                        if (!empty($itemsList)) {
                            foreach ($itemsList as $item) {
                                echo "<tr class='clickable-row' data-id='{$item['id']}' data-name='{$item['name']}' data-category='{$item['category']}' data-price='{$item['price']}' data-calories='{$item['calories']}' data-fats='{$item['fats']}' data-carbs='{$item['carbs']}' data-protein='{$item['protein']}' data-image='{$item['image']}'>";
                                echo "<td>{$item['id']}</td>";
                                echo "<td>{$item['name']}</td>";
                                echo "<td>{$item['category']}</td>";
                                echo "<td>{$item['price']}</td>";
                                echo "<td>{$item['calories']}</td>";
                                echo "<td>{$item['fats']}</td>";
                                echo "<td>{$item['carbs']}</td>";
                                echo "<td>{$item['protein']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No records found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </center>

    <?php require("footer.php"); ?>

    <script>
        $(document).ready(function() {
            // Function to handle row click
            $(".clickable-row").click(function() {
                // Extract data attributes from the clicked row
                var id = $(this).data('id');
                var name = $(this).data('name');
                var category = $(this).data('category');
                var price = $(this).data('price');
                var calories = $(this).data('calories');
                var fats = $(this).data('fats');
                var carbs = $(this).data('carbs');
                var protein = $(this).data('protein');
                var imageUrl = $(this).data('image');

                // Set input field values with extracted data
                $("#id").val(id);
                $("#name").val(name);

                // Check category and set the dropdown accordingly
                $("#category").val(category.charAt(0).toUpperCase() + category.slice(1));

                $("#price").val(price);
                $("#calories").val(calories);
                $("#fats").val(fats);
                $("#carbs").val(carbs);
                $("#protein").val(protein);

                // Set the image src to display the image
                if (imageUrl) {
                    $("#image-preview").attr("src", imageUrl).show();
                } else {
                    $("#image-preview").hide();
                }
            });
        });
    </script>
</body>
</html>
