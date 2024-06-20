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
    <?php require("Userheader.php"); ?>
    <!-- Welcome message and category icon -->
    <center>
        <div class="welcome-message">
            <h1>Welcome!</h1>
            <h2>Explore our delicious menu offerings categorized by Breakfast, Snack, Dinner, Lunch, Dessert, and Shakes.</h2>
            <br>
            <img src="Images\Icons\mind.jpg" alt="Category Icon">
            <br>
        </div>
    </center>
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
             <!-- Pie Chart Container -->
            <div class="pie-chart-container hidden">
                <!-- Pie Chart -->
                <div class="pie-chart">
                    <div class="slice slice-carbs" style="transform: rotate(<?php echo ($menuItem['carbs'] / ($menuItem['carbs'] + $menuItem['protein'] + $menuItem['fats'])) * 360; ?>deg);">
                        <span class="name">Carbs</span>
                        <span class="percentage"><?php echo round(($menuItem['carbs'] / ($menuItem['carbs'] + $menuItem['protein'] + $menuItem['fats'])) * 100); ?>%</span>
                    </div>
                    <div class="slice slice-protein" style="transform: rotate(<?php echo ($menuItem['protein'] / ($menuItem['carbs'] + $menuItem['protein'] + $menuItem['fats'])) * 360; ?>deg);">
                        <span class="name">Protein</span>
                        <span class="percentage"><?php echo round(($menuItem['protein'] / ($menuItem['carbs'] + $menuItem['protein'] + $menuItem['fats'])) * 100); ?>%</span>
                    </div>
                    <div class="slice slice-fats" style="transform: rotate(<?php echo ($menuItem['fats'] / ($menuItem['carbs'] + $menuItem['protein'] + $menuItem['fats'])) * 360; ?>deg);">
                        <span class="name">Fats</span>
                        <span class="percentage"><?php echo round(($menuItem['fats'] / ($menuItem['carbs'] + $menuItem['protein'] + $menuItem['fats'])) * 100); ?>%</span>
                    </div>
                </div>
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

        
        function togglePieChart(menuItem) {
            var pieChart = menuItem.nextElementSibling.querySelector('.pie-chart');
            pieChart.classList.toggle('hidden');
        }
    </script>

</body>
</html>
