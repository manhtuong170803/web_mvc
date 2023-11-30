<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    $db = new Database();
    $fm = new Format();

    $quantity = $_POST['quantity'];
    $product_stock = $_POST['product_stock'];//9
    $productid_value = $_POST['productid_value'];//29
    session_start();
    $sId = session_id();
    $check_cart = "SELECT * FROM tbl_cart WHERE productId = '$productid_value' AND sId = '$sId'";
    $result_check_cart = $db->select($check_cart);
        $mess_error = false;
        if($result_check_cart){
            $result_check_cart = $result_check_cart->fetch_assoc();
            $quantity_update = $result_check_cart['quantity'] + $quantity;
            $stock_remaining = $product_stock - $quantity_update;
            if($quantity_update <= $product_stock){
                $query = "UPDATE `tbl_cart` SET `quantity` = '$quantity_update' WHERE productId = '$productid_value' AND sId = '$sId'";
                $result = $db->update($query);
                

            }else{
                $mess_error = true;
                
            }
            
            // khi vào trường hợp này sản phẩm sẽ thêm 1 đơn vị
            /*
            1, kiểm tra xem trong database số lượng hiện tại là bao nhiêu $check_cart['quantity'] = 1
            2, cập nhật dữ liệu của product trong cart
                $quantity_update = $check_cart['quantity'] + 1 
                UPDATE `tbl_cart` SET `quantity` = ' $quantity_update' WHERE productId = '$id' AND sId = '$sId';
            */
        }else{
            //
            $stock_remaining = $product_stock - $quantity;
            $query = "SELECT * FROM tbl_product where productId = '$productid_value'";
            $result = $db->select($query)->fetch_assoc();
            
            $image = $result['image'];
            $price = $result['price'];
            $productName = $result['productName'];

            $query_insert = "INSERT INTO `tbl_cart`(`stock`,`productId`, `quantity`, `sId`, `image`, `price`, `productName`) VALUES ('$product_stock','$productid_value','$quantity','$sId','$image','$price','$productName')";
            $insert_cart = $db->insert($query_insert);
            
        }
        if(!$mess_error){
            // select những thứ em cần rồi bỏ vào aray ...
            $query = "SELECT * FROM tbl_cart where sId = '$sId'";
            $result_2 = $db->select($query);
            if($result_2){
                $i = 0;
                $subtotal = 0;
                $subquantity = 0;
                //$stock_remaining_2 = 0;
                while($result = $result_2->fetch_assoc() ){
                    $i++;
                    $subtotal += $result['quantity'] * $result['price'];
                    $subquantity += $result['quantity'];
                    //$stock_remaining_2 = $stock_remaining;
                }
            }
            $data = array(
                'result' => 'success',
                'subtotal' => $fm->format_currency($subtotal)." "."VND",
                'subquantity' => $subquantity,
                'stock' => $stock_remaining,
                'productId'=> $productid_value
            );
        }else{
            $data = array(
                'result' => 'false'
            );
        }
        
        $jsonString = json_encode($data);
        echo $jsonString;


    













?>