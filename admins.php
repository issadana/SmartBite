<?php  
    session_start();
    include('database/conn.php');

    function getAdminUsers($con) {
        $query = "SELECT * FROM `user` WHERE `role` = 'admin'";
        $result = mysqli_query($con, $query);
    
        $admins = array();
    
        if(mysqli_num_rows($result) > 0) {
            while($data = mysqli_fetch_assoc($result)) {
                $admins[] = $data;
            }
        }
    
        return $admins;
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
        <form action="admins_action.php" method="post">
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
                <input type="text" name="role" id="role" value="admin" readonly>

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
                <h2>Admins Information:</h2>
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

                            $adminUsers = getAdminUsers($con);

                            if (!empty($adminUsers)) {
                                foreach ($adminUsers as $admin) {
                                    echo "<tr class='clickable-row' data-id='{$admin['id']}' data-username='{$admin['username']}' data-email='{$admin['email']}' data-pass='{$admin['password']}' data-age='{$admin['age']}' data-gender='{$admin['gender']}'>";
                                    echo "<td>{$admin['id']}</td>";
                                    echo "<td>{$admin['username']}</td>";
                                    echo "<td>{$admin['email']}</td>";
                                    echo "<td>{$admin['password']}</td>";
                                    echo "<td>{$admin['age']}</td>";
                                    echo "<td>{$admin['gender']}</td>";
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
