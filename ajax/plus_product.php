<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    $db = new Database();
    $fm = new Format();


    $id_cart = $_POST['id_cart'];
    //tìm cart hiện tại 
    $select_query = "SELECT * FROM `tbl_cart` WHERE `cartId` = $id_cart";
    $result_select = $db->select($select_query)->fetch_assoc();
    $quantity_update = $result_select['quantity'] - 1;
    //$total = $result_select['price'] * $quantity_update;
	// echo $fm->format_currency($total)." "."VND";
    //$quantityupdate = $result_select['price'] - $result_select['quantity'];
    $updateQuery = "UPDATE `tbl_cart` SET `quantity` = '$quantity_update' WHERE `tbl_cart`.`cartId` = $id_cart";
    $result = $db->Update($updateQuery);
    // var_dump( $updateQuery)
// ------------------
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
    //var_dump($select_query_2);
    //$result_select_2 = $db->select($select_query_2)->fetch_assoc();
    //$total = 0;
    //$quantity_2 = 0;
    //foreach($result_select_2 as $row) {
        //var_dump($row);
        //$total += $row['quantity'] * $row['price'];
    //    var_dump($row);
        //var_dump($row['price']);
        //$subtotal_2 += $total_2;
        //$quantity_2 += $row['quantity'];
        
    //}
    // for($i = 1; $i< count($result_select); $i++ ){

    // }
//----------------------

     $total = $result_select['price'] * $quantity_update;
    
    $data = array(
        'total' => $fm->format_currency($total)." "."VND",
        'quantity' => $quantity_update,
        'subtotal' => $fm->format_currency($subtotal)." "."VND",
        'subquantity' => $subquantity

    );



    $jsonString = json_encode($data);
    echo $jsonString;
     

    /*
    ghi lại
    ếp kiểu
    $test = 11; //sẽ thực hiện các phép toán được 
    $test = '11'; //không thực hiện các phép toán được (nếu muốn thực hiện các phép toán thì phải ép kiểu)
    $a = (int)($test + 12); 
        -----
        - mảng là gì: là khi mình muốn lưu nhiều giá trị vào 1 chổ thì dùng mảng
        - cấu trúc của mảng:
            $data = array(
                'key_1' => 'giá trị 1',
                'key_2' => $quantity_update,
                .....
            );

            cách lấy mảng: 
                $data->key_2
                $data->key_1
        ----
        mảng thường chia làm 3 loại:
        1, mảng chỉ có giá trị:
            vd: 
             $data = array(1,"abc", 1,'w');
            $data[] = 'a';

        loại 2:
            $Ho_va_ten = 'Truong The Lam';
            $lop = '11';
            $khoa = 2012;

             $data = array(
                'Ho_va_ten' => $Ho_va_ten,
                'lop' => $lop,
                'khoa' => 2012
            );
            
            $data['Ho_va_ten']  hiển cho em 'Truong The Lam'
            $data['lop']






    
    */



    // $result = $db->Update($updateQuery);
    // if($result){
    //     echo $quantity_update;
    // }

?>