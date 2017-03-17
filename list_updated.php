<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drag_drop";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$update_order = isset($_POST['update_order']) ? $_POST['update_order'] : false;
$item_delete = isset($_POST['item_delete']) ? $_POST['item_delete'] : false;
$orignal_order = isset($_POST['update_orignal']) ? $_POST['update_orignal'] : false;

if ($update_order) {
    $category_to = $_POST['category_to'];
    $category_from = $_POST['category_from'];
    $item_id = $_POST['item_id'];
    $order_list = isset($_POST['list_order']) ? $_POST['list_order'] : "";
    $items_ids = explode(",", $order_list);
    $order_no = 0;
    $json_return = array();
    // category change
    if ($category_to != $category_from) {
        $update_item = "UPDATE items SET category_id= $category_to where id=$item_id ";
        mysqli_query($conn, $update_item);
        $json_return['message_change'] = "Your Category has been changed";
    }
    foreach ($items_ids as $items_id) {
        //update items order
        $update_item = "UPDATE items SET list_order= $order_no  where id=$items_id ";
       mysqli_query($conn, $update_item);
        $order_no++;
    }
    $json_return['status'] = true;
    $json_return['message'] = "Your order has been updated.";
    echo json_encode($json_return);
} elseif ($item_delete) {
    $item_id = $_POST['item_id'];
    //delete items
    $delete_item = "DELETE FROM `items` WHERE  `id` = $item_id";
    mysqli_query($conn, $delete_item);
    $json_return = array();
    $json_return['status'] = true;
    $json_return['message'] = "Your item has been deleted.";
    echo json_encode($json_return);
} elseif ($orignal_order) {
    $total_effected = 0;
    $get_query = "";
    $items_query = "select * from items";
    $result = mysqli_query($conn, $items_query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_object($result)) {

            $origin_query = "UPDATE items SET list_order= $row->orignal_order,category_id= $row->old_cate where id=$row->id ";
//            if ($total_effected == 0)
//                $get_query = $origin_query;
            $effect = mysqli_query($conn, $origin_query);
//            $total_effected +=1;
        }
    }

    $json_return = array();
    $json_return['status'] = true;
    $json_return['message'] = "Your items have been reset to orignal order ." ;
    echo json_encode($json_return);
}



