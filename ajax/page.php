<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    $db = new Database();
    $fm = new Format();

    // require "config.php";
    $sp_perpage = 4;
    $page = $_GET['page'];
    settype($page, "int");
    $min = (($page - 1) * $sp_perpage);
    $max = $min + $sp_perpage;
    $query = "SELECT * FROM tbl_product order by productId ASC LIMIT $min,$max";
    $result = $db->SELECT($query);
    if($result){
        // khai báo mảng (cha) array_products
        $parentData = array();
        while($row = $result->fetch_assoc()){
            //khai báo 1 mảng (con) e_product
            //thêm giá trị id vào mảng con (e_product)
            // thêm giá trị name vào mảng con (e_product)
            // ...
            //thêm mảng con (e_product) vào mảng cha array_products
            $parentData[] = array(
                'productId' => $row['productId'],
                'image' => $row['image'],
                'productName' => $row['productName'],
                'price' => $fm->format_currency($row['price'])." "."VND",
                'product_quantity' => $row['product_quantity']
            );
        }
        
        //check max product 
        $query_count = "SELECT COUNT(*) AS count FROM `tbl_product`;";
        $result_count = $db->SELECT($query_count);
        $count = $result_count->fetch_assoc();
        $max_data = true;
        if($count['count'] > $max){
            $max_data = false;
        }
        //ép json trả về hết
        $data = array();
        if(count($parentData)){
            $data = array(
                'result' => 'success',
                'data' => $parentData,
                'max_data' => $max_data
            );
        }else{
            $data = array(
                'result' => 'failure'
            );
        }
        
        $jsonString = json_encode($data);
        echo $jsonString;
    }

    

    // $page = $_GET['page'];
    // $sp_everypage = 4;
    // if(!isset($_GET['page'])){
    //     $page = 1;
    // }else{
    //     $page = $_GET['page'];
    // }
    // $everypage = ($page-1)*$sp_everypage;
    // $query = "SELECT * FROM tbl_product where type = '0' order by productId desc LIMIT $everypage,$sp_everypage";
    // $result = $db->SELECT($query);
    // $query = "SELECT * FROM tbl_product";
    // $result = $db->SELECT($query);
    




?>