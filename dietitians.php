<?php  
    session_start();
    include('database/conn.php');

    function getDietitiansUsers($con) {
        $query = "SELECT * FROM `user` WHERE `role` = 'dietitian'";
        $result = mysqli_query($con, $query);
    
        $dietitians = array();
    
        if(mysqli_num_rows($result) > 0) {
            while($data = mysqli_fetch_assoc($result)) {
                $dietitians[] = $data;
            }
        }
    
        return $dietitians;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css\style.css">
    <link rel="stylesheet" href="Css\footer.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <form action="dietitians_action.php" method="post">
            <div class="input-fields">
                <!-- Form Inputs -->
                <label for="id">ID</label>
                <input type="text" name="id" id="id" readonly> <!-- readonly means not editable -->

                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>

                <label for="email">Email</label>
                <input type="text" name="email" id="email" required>

                <label for="pass">Password</label>
                <input type="text" name="pass" id="pass" required>

                <label for="age">Age</label>
                <input type="text" name="age" id="age" required>

                <label for="gender">Gender</label>
                <select name="gender" id="gender" style="width: 310px;height: 40px;border-radius:15px;" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <br>
                <label for="role">Role</label>
                <input type="text" name="role" id="role" value="dietitian" readonly>

                <!-- Buttons -->
                <div class="button-group">
                    <input type="submit" class="btn" name="action" value="Edit">
                    <input type="submit" class="btn" name="action" value="Add">
                    <input type="submit" class="btn" name="action" value="Delete">
                    <input type="submit" class="btn" name="action" value="Clear">
                </div>
            </div>
        </form>
            <div class="table-container">
                <h2>Dietitians Information:</h2>
                <br>
                <!-- Table -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Age</th>
                            <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include('database/conn.php');

                            $dietitianUsers = getDietitiansUsers($con);

                            if (!empty($dietitianUsers)) {
                                foreach ($dietitianUsers as $dietitian) {
                                    echo "<tr class='clickable-row' data-id='{$dietitian['id']}' data-username='{$dietitian['username']}' data-email='{$dietitian['email']}' data-pass='{$dietitian['password']}' data-age='{$dietitian['age']}' data-gender='{$dietitian['gender']}'>";
                                    echo "<td>{$dietitian['id']}</td>";
                                    echo "<td>{$dietitian['username']}</td>";
                                    echo "<td>{$dietitian['email']}</td>";
                                    echo "<td>{$dietitian['password']}</td>";
                                    echo "<td>{$dietitian['age']}</td>";
                                    echo "<td>{$dietitian['gender']}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No records found</td></tr>";
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
            var username = $(this).data('username');
            var email = $(this).data('email');
            var pass = $(this).data('pass');
            var age = $(this).data('age');
            var gender = $(this).data('gender');

            // Set input field values with extracted data
            $("#id").val(id);
            $("#username").val(username);
            $("#email").val(email);
            $("#pass").val(pass);
            $("#age").val(age);
            $("#gender").val(gender);
        });
        
    });
</script>

</body>
</html>
