<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    $db = new Database();
    $fm = new Format();


    $id_cart = $_POST['id_cart'];
    $query = "DELETE FROM tbl_cart WHERE cartId = $id_cart";
    $result = $db->delete($query);
    $result != false;
    if($result){
        $result = true;
        session_start();
        $sId = session_id();
        $select_query_2 = "SELECT * FROM tbl_cart where sId = '$sId'";
        $result_select_2 = $db->select($select_query_2);
    
        if($result_select_2){
            $i = 0;
            $subtotal = 0;
            $subquantity = 0;
            $vat = 0;
            $gtotal = 0;
            while($result = $result_select_2->fetch_assoc() ){
                $i++;
                $subtotal += $result['quantity'] * $result['price'];
                $subquantity += $result['quantity'];
                $vat = $subtotal * 0.1;
                $gtotal = $subtotal + $vat;
            }
    
        }
        $data = array(
            'result' => 'success',
            'subtotal' => $fm->format_currency($subtotal)." "."VND",
            'subquantity' => $subquantity,
            'subtotal_2' => $fm->format_currency($subtotal)." "."VND",
            'gtotal'=> $fm->format_currency($gtotal)." "."VND"
    
        );
    }else{
        $result = false;
        $data = array(
            'result' => 'false'
        );
    }
    // session_start();
    // $sId = session_id();
    // $select_query_2 = "SELECT * FROM tbl_cart where sId = '$sId'";
    // $result_select_2 = $db->select($select_query_2);

    // if($result_select_2){
    //     $i = 0;
    //     $subtotal = 0;
    //     $subquantity = 0;
    //     //var_dump($result_select_2);
    //     while($result = $result_select_2->fetch_assoc() ){
    //         $i++;
    //         // var_dump($result['quantity']);
    //         $subtotal += $result['quantity'] * $result['price'];
    //         $subquantity += $result['quantity'];
    //     }

    // }
    // $data = array(
    //     'result' => 'success',
    //     'subtotal' => $fm->format_currency($subtotal)." "."VND",
    //     'subquantity' => $subquantity,

    // );
    $jsonString = json_encode($data);
    echo $jsonString;

?>