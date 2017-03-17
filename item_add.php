<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drag_drop";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//my php starts here 
include ('functions.php');
$add_cate = isset($_POST['add_cate']) ? $_POST['add_cate'] : false;
$add_item = isset($_POST['add_item']) ? $_POST['add_item'] : false;
if (isset($_POST['submit'])) {
    $cat_name = $_POST['cname'];
    $created_at = date('Y-m-d H:i:s');
    $modified_at = date('Y-m-d H:i:s');
if($add_cate){
    $insert_category = "INSERT INTO `categories`(`name`, `created_at`, `modified_at`) VALUES ('$cat_name','$created_at','$modified_at')";
    $inserted = insertQuery($insert_category);
    
    $json_return['cate_id'] =  mysqli_insert_id($conn);    
    
     $json_return['status'] = true;
    $json_return['message'] = "Your category has been added.";
    echo json_encode($json_return);
}}
if (isset($_POST['submitI'])) {

    $item_name = $_POST['iname'];
    $cat_id = $_POST['cat_id'];
    
    
    
    $q = "select max(`list_order`) as orderz FROM `items` where `category_id` = '$cat_id'";
   $new = selectQuery($q);
   
   foreach($new as $new) {
       $orderz = $new['orderz'];
   }


            
    $created_at = date('Y-m-d H:i:s');
    $modified_at = date('Y-m-d H:i:s');
    $order = $orderz+1;
    
    if($add_item){

    $insert_item = "INSERT INTO `items`(`name`, `created_at`, `modified_at`, `category_id`, `list_order`,`orignal_order`,`old_cate`) VALUES ('$item_name','$created_at','$modified_at','$cat_id','$order','$order','$cat_id')";
    $insertedI = insertQuery($insert_item);
    
    
   
   
 $json_return['last_id'] =  mysqli_insert_id($conn);


 $json_return['status'] = true;

    $json_return['message'] = "Your item has been added.";
    echo json_encode($json_return);
    }
};
$select_category = "SELECT * FROM `categories` ";
$selects = selectQuery($select_category);
$select_item = "SELECT * FROM `items` ORDER BY `category_id` , list_order ASC";
$selects_item = selectQuery($select_item);

?>        