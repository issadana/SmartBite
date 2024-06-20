<?php
    include('database/conn.php');
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];
    
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? null;
        $category = $_POST['category'] ?? null;
        $price = $_POST['price'] ?? null;
        $calories = $_POST['calories'] ?? null;
        $fats = $_POST['fats'] ?? null;
        $carbs = $_POST['carbs'] ?? null;
        $protein = $_POST['protein'] ?? null;
    
        // Check if the image field is set and handle the file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image = $_FILES['image']['name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $uploadDir = 'uploads/'; // Ensure this directory exists and is writable
            $uploadFile = $uploadDir . basename($image);
            
            // Move the uploaded file to the desired directory
            if (move_uploaded_file($imageTmpName, $uploadFile)) {
                // File successfully uploaded
            } else {
                // Handle the error
                echo "Error uploading the file.";
            }
        } else {
            $image = null; // No file uploaded
        }
        switch ($action) {
            case 'Edit':
                $category = strtolower($category);
                handleEdit($con, $id, $name, $category, $price, $calories, $fats, $carbs, $protein);
                header("Location: menuadmin.php");
                exit();
                break;
            case 'Add':
                if (!itemExists($con, $name)) {
                    handleAdd($con, $name, $category, $price, $calories, $fats, $carbs, $protein, $image);
                } else {
                    $_SESSION['error'] = "Item with this name already exists.";
                }
                header("Location: menuadmin.php");
                exit();
                break;
            case 'Delete':
                if (!empty($id)) {
                    handleDelete($con, $id);
                } else {
                    $_SESSION['error'] = "ID is required to delete.";
                }
                header("Location: menuadmin.php");
                exit();
                break;
            case 'Clear':
                handleClear($id, $name, $category, $price, $calories, $fats, $carbs, $protein);
                header("Location: menuadmin.php");
                break;
            default:
                $_SESSION['error'] = "Invalid action";
        }
    }

        function itemExists($con, $name) {
            $query = "SELECT * FROM `items` WHERE `name` = '$name' ";
            $result = mysqli_query($con, $query);
            return mysqli_num_rows($result) > 0;
        }

        function handleDelete($con, $id) {
            $query = "DELETE FROM `items` WHERE `id`='$id'";
            if (mysqli_query($con, $query)) {
                $_SESSION['message'] = "Record deleted successfully";
            } else {
                $_SESSION['error'] = "Error deleting record: " . mysqli_error($con);
            }
        }
    
        function handleClear(&$id, &$name, &$category, &$price, &$calories, &$fats, &$carbs, &$protein) {
            $id = $name = $category = $price = $calories = $fats = $carbs = $protein =null;
        }
    
        function handleEdit($con, $id, $name, $category, $price, $calories, $fats, $carbs, $protein) {
            $query = "UPDATE `items` SET `name`='$name', `category`='$category', `price`='$price', `calories`='$calories', `fats`='$fats', `carbs`='$carbs', `protein`='$protein' WHERE `id`='$id'";
            if (mysqli_query($con, $query)) {
                $_SESSION['message'] = "Record edited successfully";
            } else {
                $_SESSION['error'] = "Error updating record: " . mysqli_error($con);
            }
        }

        function handleAdd($con, $name, $category, $price, $calories, $fats, $carbs, $protein, $image) {
            // Sanitize user inputs
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $category = strtolower(mysqli_real_escape_string($con, $_POST['category']));
            $price = mysqli_real_escape_string($con, $_POST['price']);
            $calories = mysqli_real_escape_string($con, $_POST['calories']);
            $fats = mysqli_real_escape_string($con, $_POST['fats']);
            $carbs = mysqli_real_escape_string($con, $_POST['carbs']);
            $protein = mysqli_real_escape_string($con, $_POST['protein']);
            $image_name = mysqli_real_escape_string($con, $_FILES['image']['name']); // Get the filename of the uploaded image
        
            // Log input values
            error_log("Name: $name, Category: $category, Price: $price, Calories: $calories, Fats: $fats, Carbs: $carbs, Protein: $protein, Image Name: $image_name");
        
            // File upload handling
            $target_dir = "Images/" . $category . "/";
            
            // Ensure the category directory exists
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    echo "Failed to create directory: $target_dir";
                    error_log("Failed to create directory: $target_dir");
                    return;
                }
            }
        
            // Generate unique filename to prevent overwriting existing files
            $image_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $image_basename = basename($_FILES["image"]["name"], "." . $image_extension);
            $image_timestamp = time();
            $image_unique_name = $image_basename . "_" . $image_timestamp . "." . $image_extension;
        
            $target_file = $target_dir . $image_unique_name;
        
            // Log target file path
            error_log("Target file path: $target_file");
        
            if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
                error_log("File upload error: " . $_FILES["image"]["error"]);
                echo "Error uploading file";
                return;
            }
        
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // File upload successful, proceed with database insertion
                $image_path = str_replace('\\', '/', $target_file); // Convert backslashes to slashes for database storage
        
                $query = "INSERT INTO `items`(`name`, `category`, `price`, `image`, `calories`, `fats`, `carbs`, `protein`) 
                          VALUES ('$name', '$category', '$price', '$image_path', '$calories', '$fats', '$carbs', '$protein')";
                error_log("SQL Query: " . $query);
                $result = mysqli_query($con, $query);
        
                // Check if the query was successful
                if ($result) {
                    echo "Item added successfully";
                    error_log("Item added successfully: $name, $category");
                    header("Location: menuadmin.php");
                    exit; // stop further execution
                } else {
                    echo "Failed to add item. Error: " . mysqli_error($con);
                    error_log("Failed to add item. Error: " . mysqli_error($con));
                }
            } else {
                echo "Error uploading file";
                error_log("Error uploading file: " . $_FILES["image"]["error"]);
            }
        }
?>