<?php
    include('database/conn.php'); 
    session_start();
    $userid =$_SESSION["done"];
    $cartid =$_SESSION["done2"];
    
    //echo"$userid";
    //echo"$cartid";

    $query1= "SELECT time_plan FROM customer_infos WHERE customer_id = $userid AND id = (SELECT MAX(id) FROM customer_infos WHERE customer_id = $userid)";
    $result=mysqli_query($con,$query1);
    $row_num= mysqli_num_rows($result);
    $data= mysqli_fetch_assoc($result);
    $_SESSION['user_state']=$data;
    $time = $data['time_plan'];    
    echo"$time";

    $query2="SELECT COUNT(*) as row_count FROM user_items WHERE user_id = $userid AND cart_id = $cartid ;";
    $result2=mysqli_query($con,$query2);
    $data= mysqli_fetch_assoc($result2);
    $_SESSION['user_state']=$data;
    $count=$data['row_count'];
    echo"$count";

    if($time=="Monthly"){

        //echo"$count";
        if($count<180){
            echo"$count";
                    echo "<script type='text/javascript'>
                       alert('The diet plan isnt done yet !');
                       window.location.href = 'dietitianCustomers.php';
                     </script>";
                exit;
            
        }else{
            echo"$userid";
            $query="UPDATE customer_infos SET pending = 0 WHERE customer_id = $userid";
            $result=mysqli_query($con,$query);
            echo"<script>window.location.href = 'dietitianCustomers.php';</script>";
        }

    }elseif($time="Weekly"){
        if($count<42){     
            echo"$count";    
            echo "<script type='text/javascript'>
                    alert('The diet plan isnt done yet !');
                    window.location.href = 'dietitianCustomers.php';
                  </script>";
            exit;
        }
        else{
            echo"$userid";
          
                echo "$userid"; // Debugging output to ensure $userid is correct
                
                $query = "UPDATE customer_infos SET pending = 0 WHERE customer_id = $userid";
                $result = mysqli_query($con, $query);
                
                if (!$result) {
                    // Output MySQL error
                    echo "Error: " . mysqli_error($con);
                } else {
                    echo "Record updated successfully";
                    
                     echo "<script>window.location.href = 'dietitianCustomers.php';</script>";
                }
            
            
           // echo"<script>window.location.href = 'dietitianCustomers.php';</script>";
        }
    }
    
    $query="UPDATE customer_infos SET pending = 0 WHERE customer_id = $userid";
    $result=mysqli_query($con,$query);
    //header("Location:dietitian.php");
?>