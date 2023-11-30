<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
    include '../lib/session.php';
    
    $db = new Database();
        $compareid_value = $_POST['compareid_value'];//29
        session_start();
        //Session::get('customer_id');
        $customer_id = Session::get('customer_id');
        //var_dump($customer_id);
        // if (isset($_SESSION['customer_id'])) {
        //     echo $_SESSION['customer_id'];
        // }
        $check_compare = "SELECT * FROM tbl_compare where productId = '$compareid_value' AND customer_id = $customer_id";
        $result_check_compare = $db->select($check_compare);
        // var_dump($result_check_compare);
        if($result_check_compare){
            echo 'Product Already Added To Compare';
            // $msg = "<span class='error'>Product Already Added To Compare</span>";
            // return $msg;
        }else{
            $query = "SELECT * FROM tbl_product where productId = '$compareid_value'";
            $result = $db->select($query)->fetch_assoc();
            $productName = $result['productName'];
            $price = $result['price'];
            $image = $result['image'];
                $query_insert = "INSERT INTO `tbl_compare`(`productId`, `price`, `image`, `customer_id`, `productName`) VALUES ('$compareid_value','$price','$image','$customer_id','$productName')";
                $insert_compare = $db->insert($query_insert);
                if($insert_compare){
                    echo 'Added Compare Successfully';
                    // $alert = "<span class='success'>Added Compare Successfully</span>";
                    // return $alert;
                }else{
                    echo 'Added Compare Not Success';
                    // $alert = "<span class='error'>Added Compare Not Success</span>";
                    // return $alert;
                }
        }
?>