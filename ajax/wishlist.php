<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
    include '../lib/session.php';
    
    $db = new Database();
        $wishlistid_value = $_POST['wishlistid_value'];//29
        session_start();
        //Session::get('customer_id');
        $customer_id = Session::get('customer_id');
        //var_dump($customer_id);
        // if (isset($_SESSION['customer_id'])) {
        //     echo $_SESSION['customer_id'];
        // }
        $check_compare = "SELECT * FROM tbl_compare where productId = '$wishlistid_value' AND customer_id = $customer_id";
        $result_check_wishlist = $db->select($check_compare);
        // var_dump($result_check_compare);
        if($result_check_wishlist){
            echo 'Product Already Added To Wishlist';
            // $msg = "<span class='error'>Product Already Added To Wishlist</span>";
            // return $msg;
        }else{
            $query = "SELECT * FROM tbl_product where productId = '$wishlistid_value'";
            $result = $db->select($query)->fetch_assoc();
            $productName = $result['productName'];
            $price = $result['price'];
            $image = $result['image'];
                $query_insert = "INSERT INTO `tbl_compare`(`productId`, `price`, `image`, `customer_id`, `productName`) VALUES ('$wishlistid_value','$price','$image','$customer_id','$productName')";
                $insert_wishlist = $db->insert($query_insert);
                if($insert_wishlist){
                    echo 'Added Wishlist Successfully';
                    // $alert = "<span class='success'>Added Wishlist Successfully</span>";
                    // return $alert;
                }else{
                    echo 'Added Wishlist Not Success';
                    // $alert = "<span class='error'>Added Wishlist Not Success</span>";
                    // return $alert;
                }
        }
?>