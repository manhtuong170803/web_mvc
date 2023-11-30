<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    $db = new Database();
    $fm = new Format();

    session_start();
    $sId = session_id();
    $query = "SELECT * FROM `tbl_cart` WHERE `sId` LIKE '$sId' AND `status` = 1";//chọn sản phẩm từ giỏ hàng
    $get_product =$db->select($query);
    $oder_code = rand(0000,9999);
    $check_login = "SELECT * FROM tbl_customer";
    $result_check = $db->select($check_login);
    if($result_check->num_rows > 0){
        $customer_id = 0;
        while($row = $result_check->fetch_assoc()){
            $customer_id = $row["id"];
        }
    }else{
        echo 'Không có dữ liệu';
    }
    // $customer_id = 4;
    // var_dump($customer_id);
    // // // insert vào tbl_placed
    $query_placed = "INSERT INTO `tbl_placed`(`customer_id`, `oder_code`, `status`) VALUES ('$customer_id','$oder_code','0')";
    $insert_placed = $db->insert($query_placed);
    if($get_product){
        while($result = $get_product->fetch_assoc()){
            $productid = $result['productId'];
            $productName = $result['productName'];
            $quantity = $result['quantity'];
            $price = $result['price'] * $quantity;
            $image = $result['image'];
            // $customer_id = $customer_id;
            $query_oder = "INSERT INTO `tbl_oder`(`oder_code`,`productId`, `productName`, `quantity`, `price`, `image`, `customer_id`) VALUES ('$oder_code','$productid',
            '$productName','$quantity','$price','$image','$customer_id')";
            $insert_oder = $db->insert($query_oder);
            $query_2 = "DELETE FROM tbl_cart WHERE sId = '$sId' AND status = '1'";
            $result_2 = $db->delete($query_2);
            if($result_2){
                echo 'Thanh toán thành công';
            }
        }
    }else{
        echo 'Thanh toán thất bại';
    }
    // $query_2 = "DELETE FROM tbl_cart WHERE sId = '$sId' AND status = '1';";
    // $result_2 = $db->delete($query_2);
    // if($result_2){
    //     echo 'Thanh toán thành công';
    // }

?>