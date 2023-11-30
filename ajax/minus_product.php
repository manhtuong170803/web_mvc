<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    $db = new Database();
    $fm = new Format();
    $id_cart = $_POST['id_cart'];
    // $stock = $_POST['stock'];
    //tìm cart hiện tại 
    $select_query = "SELECT * FROM `tbl_cart` WHERE `cartId` = $id_cart";
    $result_select = $db->select($select_query)->fetch_assoc();
    $quantity_update = $result_select['quantity'] + 1;
    $updateQuery = "UPDATE `tbl_cart` SET `quantity` = '$quantity_update' WHERE `tbl_cart`.`cartId` = $id_cart ;";
    $result = $db->Update($updateQuery);
    $total = $result_select['price'] * $quantity_update;

    session_start();
    $sId = session_id();
    $select_query_2 = "SELECT * FROM tbl_cart where sId = '$sId'";
    $result_select_2 = $db->select($select_query_2);

    if($result_select_2){
        $i = 0;
        $subtotal = 0;
        $subquantity = 0;
        //var_dump($result_select_2);
        while($result = $result_select_2->fetch_assoc() ){
            $i++;
            // var_dump($result['quantity']);
            $subtotal += $result['quantity'] * $result['price'];
            $subquantity += $result['quantity'];
        }

    }
    
    $data = array(
        'total' => $fm->format_currency($total)." "."VND",
        'quantity' => $quantity_update,
        'subtotal' => $fm->format_currency($subtotal)." "."VND",
        'subquantity' => $subquantity
    );



    $jsonString = json_encode($data);
    echo $jsonString;
     
    // if($result){
    //     echo $quantity_update;
    // }

?>