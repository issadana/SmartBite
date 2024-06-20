<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="Css/footer.css">
    <link rel="stylesheet" href="Css/menu.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <?php
        session_start();
        include('database/conn.php'); // Make sure to include the database connection file


        // Ensure the user ID is set in the session
        if (isset($_SESSION['user_info']['id'])) {
            $id = $_SESSION['user_info']['id'];

            // Query to fetch the user role based on the ID
            $query = "SELECT `role` FROM `user` WHERE `id`='$id'";
            $result = mysqli_query($con, $query);

            // Check if any results are returned
            if ($result && mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);

                // Check the user's role and include the corresponding header file
                if ($data['role'] == "admin") {
                    require("Adminheader.php");
                } else {
                    require("Dietitianheader.php");
                }
            } else {
                echo "No user found with the provided ID.";
            }
        } else {
            echo "User ID is not set in the session.";
        }
    ?>
    <!-- Category dropdown -->
    <div class="category-dropdown">
        <button class="dropdown-toggle" onclick="toggleDropdown()">Categories<i class='bx bx-chevron-down'></i></button>
        <div class="dropdown-content" id="categoryLinks">
            <a href="#" onclick="getMenuItems('Breakfast')">Breakfast</a>
            <a href="#" onclick="getMenuItems('Lunch')">Lunch</a>
            <a href="#" onclick="getMenuItems('Dinner')">Dinner</a>
            <a href="#" onclick="getMenuItems('Snack')">Snack</a>
            <a href="#" onclick="getMenuItems('Dessert')">Dessert</a>
            <a href="#" onclick="getMenuItems('Shakes')">Shakes</a>
        </div>
    </div>

    <!-- Container for displaying menu items -->
    <div id="menuItemsContainer">
        <!-- The menu items will be loaded here dynamically -->
        <?php
        // Include the necessary PHP files
        require_once("database/conn.php");
        require_once("database/product.php");

        // Create an instance of the Product class and pass the $con variable from conn.php
        $product = new Product($con);

        // Fetch all menu items initially
        $menuItems = $product->getData();

        // Display all menu items
        foreach ($menuItems as $menuItem) {
        ?>
        <!-- Container for menu item -->
        <div class="menu-item" >
            <div class="item-image" onclick="togglePieChart(this)">
                <img src="<?php echo $menuItem['image']; ?>" alt="<?php echo $menuItem['name']; ?>">
            </div>
            <div class="item-details">
                <h3><?php echo $menuItem['name']; ?></h3>
                <br>
                <p>Calories: <?php echo $menuItem['calories']; ?></p>
                <p>Carbs: <?php echo $menuItem['carbs']; ?> g</p>
                <p>Protein: <?php echo $menuItem['protein']; ?> g</p>
                <p>Fats: <?php echo $menuItem['fats']; ?> g</p>
            
            </div>
        </div>
        <?php
        }
        ?>
    </div>

    <?php require("footer.php"); ?>

    <script>
        function toggleDropdown() {
            var dropdownContent = document.getElementById("categoryLinks");
            dropdownContent.classList.toggle("show");
        }

        function getMenuItems(category) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("menuItemsContainer").innerHTML = this.responseText;
                    // Close the dropdown after loading menu items
                    toggleDropdown();
                }
            };
            xhttp.open("GET", "get_menu_items.php?category=" + category, true);
            xhttp.send();
        }
    </script>

</body>
</html>
