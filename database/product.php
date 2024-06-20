<?php
include('database/conn.php'); 

class Product
{
    public $con = null;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function getData($table = 'items')
    {
        $result = mysqli_query($this->con, "SELECT * FROM {$table}");
        $resultArray = array();
        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $item;
        }
        return $resultArray;
    }

    public function getProduct($item_category = null, $table = 'items')
    {
        if (isset($item_category)) {
            // Escaping the item category to prevent SQL injection
            $escaped_category = mysqli_real_escape_string($this->con, $item_category);
            
            $result = mysqli_query($this->con, "SELECT * FROM {$table} WHERE category='{$escaped_category}'");
            $resultArray = array();
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $item;
            }
            return $resultArray;
        }
    }
}

// Create a new instance of Product and pass the $con variable from conn.php
$product = new Product($con);
?>
