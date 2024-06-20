<?php
// Include the necessary PHP files
require_once("database/conn.php");
require_once("database/product.php");

// Create an instance of the Product class and pass the $con variable from conn.php
$product = new Product($con);

// Get the category from the query string
$category = $_GET['category'] ?? null;

// Fetch menu items based on the category
if ($category) {
    // Fetch menu items based on the category
    $menuItems = $product->getProduct($category);
} else {
    // If no category provided, return an empty response
    $menuItems = [];
}

// Generate HTML content for the menu items
$menuItemsHTML = '';
foreach ($menuItems as $menuItem) {
    // You can customize this HTML structure based on your needs
    $menuItemsHTML .= '<div class="menu-item">';
    $menuItemsHTML .= '<div class="item-image">';
    $menuItemsHTML .= '<img src="' . $menuItem['image'] . '" alt="' . $menuItem['name'] . '">';
    $menuItemsHTML .= '</div>';
    $menuItemsHTML .= '<div class="item-details">';
    $menuItemsHTML .= '<h3>' . $menuItem['name'] . '</h3>';
    $menuItemsHTML .= '<br>';
    $menuItemsHTML .= '<p>Calories: ' . $menuItem['calories'] . '</p>';
    $menuItemsHTML .= '<p>Carbs: ' . $menuItem['carbs'] . ' g</p>';
    $menuItemsHTML .= '<p>Protein: ' . $menuItem['protein'] . ' g</p>';
    $menuItemsHTML .= '<p>Fats: ' . $menuItem['fats'] . ' g</p>';
    $menuItemsHTML .= '</div>';
    $menuItemsHTML .= '</div>';
}

// Return the HTML content of the menu items
echo $menuItemsHTML;
?>
