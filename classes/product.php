<?php
    $filepath = realpath(dirname(__FILE__));
   include_once ($filepath.'/../lib/database.php');
   include_once ($filepath.'/../helpers/format.php');


    class product
    {
        private $db;
        private $fm;


        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function search_product($tukhoa){
            $tukhoa = $this->fm->validation($tukhoa);
            $query = "SELECT * FROM tbl_product WHERE productName LIKE '%$tukhoa%'";
            $result = $this->db->select($query);
            return $result;
        }
        public function insert_product($data,$files){
            $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $product_quantity = mysqli_real_escape_string($this->db->link, $data['product_quantity']);
            $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link, $data['price']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);
            // Kiểm tra hình ảnh và lấy hình ảnh cho vào folder upload
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()),0,10).''.$file_ext;
            $uploaded_image = "uploads/".$unique_image;
            // -----------------------------------------------------------------
            if($productName=="" || $product_quantity=="" || $brand=="" || $category=="" ||$product_desc=="" || $price=="" || $type=="" || $file_name==""){
                $alert = "<span class='error'>Fields must be not empty</span>";
                return $alert;
            }else{
                move_uploaded_file($file_temp,$uploaded_image);
                $query = "INSERT INTO `tbl_product` (`productName`, `product_quantity`, `catId`, `brandId`, `product_desc`, `type`, `price`, `image`) VALUES ('$productName','$product_quantity','$category','$brand','$product_desc','$type','$price','$unique_image')";
                $result = $this->db->insert($query);
                if($result){
                    $alert = "<span class='success'>Insert Product Successfully</span>";
                    return $alert;
                }else{
                    $alert = "<span class='error'>Insert Product Not Success</span>";
                    return $alert;
                }
            }
        }
        public function insert_slider($data,$files){
            $sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);
           // Kiểm tra hình ảnh và lấy hình ảnh cho vào folder upload
           $permited = array('jpg','jpeg','png','gif');
           $file_name = $_FILES['image']['name'];
           $file_size = $_FILES['image']['size'];
           $file_temp = $_FILES['image']['tmp_name'];

           $div = explode('.', $file_name);
           $file_ext = strtolower(end($div));
           $unique_image = substr(md5(time()),0,10).''.$file_ext;
           $uploaded_image = "uploads/" . $unique_image;

           if($sliderName=="" || $type==""){
               $alert = "<span class='error'>Fields must be not empty</span>";
               return $alert;
           }else{
               if(!empty($file_name)){
                   // Nếu người dùng chọn ảnh
                   if($file_size > 2048000){
                       $alert = "<span class='success'>Image Size should be less then 2MB!</span>";
                       return $alert;
                   }
                   elseif(in_array($file_ext, $permited) === false)
                   {
                       $alert = "<span class='success'>You can upload only:-".implode(',', $permited)."</span>";
                       return $alert;
                   }
                   move_uploaded_file($file_temp,$uploaded_image);
                    $query = "INSERT INTO `tbl_slider`(`sliderName`, `type`, `slider_image`) VALUES ('$sliderName','$type','$unique_image')";
                    $result = $this->db->insert($query);
                    if($result){
                        $alert = "<span class='success'>Slider Added Successfully</span>";
                     return $alert;
                    }else{
                        $alert = "<span class='error'>Slider Added Not Success</span>";
                        return $alert;
                    }
               }
           }
        }
        public function show_slider(){
            $query = "SELECT * FROM tbl_slider where type='1' order by sliderId desc";
            $result = $this->db->select($query);
            return $result;
        }
        public function show_slider_list(){
            $query = "SELECT * FROM tbl_slider order by sliderId desc";
            $result = $this->db->select($query);
            return $result;
        }
        public function show_product(){
            $query = "SELECT tbl_product.*,tbl_category.catName, tbl_brand.brandName
                    FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
                    INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
                    order by tbl_product.productId desc";
            // $query = "SELECT * FROM tbl_product order by productId desc";
            $result = $this->db->select($query);
            return $result;
        }
        public function update_product($data,$files,$id){
            $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $product_quantity = mysqli_real_escape_string($this->db->link, $data['product_quantity']);
            $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link, $data['price']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);
            // Kiểm tra hình ảnh và lấy hình ảnh cho vào folder upload
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()),0,10).''.$file_ext;
            $uploaded_image = "uploads/" . $unique_image;

            if($productName=="" || $product_quantity=="" || $brand=="" || $category=="" ||$product_desc=="" || $price=="" || $type==""){
                $alert = "<span class='error'>Fields must be not empty</span>";
                return $alert;
            }else{
                if(!empty($file_name)){
                    // Nếu người dùng chọn ảnh
                    if($file_size > 20480){
                        $alert = "<span class='success'>Image Size should be less then 2MB!</span>";
                        return $alert;
                    }
                    elseif(in_array($file_ext, $permited) === false)
                    {
                        $alert = "<span class='success'>You can upload only:-".implode(',', $permited)."</span>";
                        return $alert;
                    }
                    move_uploaded_file($file_temp,$uploaded_image);
                    $query = "UPDATE tbl_product SET 
                    productName = '$productName',
                    product_quantity = '$product_quantity',
                    brandId = '$brand',
                    catId = '$category',
                    type = '$type',
                    price = '$price',
                    image = '$unique_image',
                    product_desc = '$product_desc'
                    WHERE productId = '$id'";
                }else{
                    // Nếu người dùng không chọn ảnh
                    $query = "UPDATE tbl_product SET 
                    productName = '$productName',
                    product_quantity = '$product_quantity',
                    brandId = '$brand',
                    catId = '$category',
                    type = '$type',
                    price = '$price',
                    product_desc = '$product_desc'
                    WHERE productId = '$id'";
                }
                $result = $this->db->update($query);
                if($result){
                    $alert = "<span class='success'>Prusuct Update Successfully</span>";
                    return $alert;
                }else{
                    $alert = "<span class='error'>Product Update Not Success</span>";
                    return $alert;
                }
            }
        }
        public function update_type_slider($id,$type){
            $type = mysqli_real_escape_string($this->db->link, $type);
            $query = "UPDATE tbl_slider SET type = '$type' where sliderId='$id'";
            $result = $this->db->update($query);
            return $result;
        }
        public function del_slider($id){
            $query = "DELETE FROM tbl_slider where sliderId = '$id'";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Slider Delete Successfully</span>";
                return $alert;
            }else{
                $alert = "<span class='error'>Slider Delte Not Success</span>";
                return $alert;
            }
        }
        public function del_product($id){
            $query = "DELETE FROM tbl_product where productId = '$id'";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Product Delete Successfully</span>";
                return $alert;
            }else{
                $alert = "<span class='error'>Product Delte Not Success</span>";
                return $alert;
            }
        }
        public function del_wlist($proid,$customer_id){
            $query = "DELETE FROM tbl_wishlist where productId = '$proid' AND customer_id = '$customer_id'";
            $result = $this->db->delete($query);
            return $result;
        }
        public function getcatbyId($id){
            $query = "SELECT * FROM tbl_product where productId = '$id'";
            $result = $this->db->SELECT($query);
            return $result;
        }
        // END BACKEND
        public function getproduct_feathered(){
            // $sp_everypage = 4;
            // if(!isset($_GET['page'])){
            //     $page = 1;
            // }else{
            //     $page = $_GET['page'];
            // }
            // $everypage = ($page-1)*$sp_everypage;
            // $query = "SELECT * FROM tbl_product where type = '0' order by productId desc LIMIT $everypage,$sp_everypage";
            // $result = $this->db->SELECT($query);
            // return $result;
        }
        public function getproduct_new(){
            // $sp_tungtrang = 4;
            // if(!isset($_GET['trang'])){
            //     $trang = 1;
            // }else{
            //     $trang = $_GET['trang'];
            // }
            // $tung_trang = ($trang-1)*$sp_tungtrang;
            // $query = "SELECT * FROM tbl_product order by productId desc LIMIT $tung_trang,$sp_tungtrang";
            // $result = $this->db->SELECT($query);
            // return $result;
        }
        public function get_all_product(){
            $query = "SELECT * FROM tbl_product order by productId ASC LIMIT 0,4";
            $result = $this->db->SELECT($query);
            return $result;
        }
        public function get_all_product_2(){
            $query = "SELECT * FROM tbl_product where type = '0' order by productId ASC LIMIT 0,4";
            $result = $this->db->SELECT($query);
            return $result;
        }
        public function get_details($id){
            $query = "SELECT tbl_product.*,tbl_category.catName, tbl_brand.brandName
            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
            WHERE tbl_product.productId = '$id'";
             $result = $this->db->select($query);
             return $result;
        }
        public function get_details_2($id){
            $query = "SELECT tbl_product.*,tbl_category.catName, tbl_brand.brandName
            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
            WHERE tbl_product.productId = '$id'";
             $result = $this->db->select($query);
             return $result;
        }
        public function getLastestDell(){
            $query = "SELECT * FROM tbl_product WHERE brandId = '1'order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }
        public function getLastestSamsung(){
            $query = "SELECT * FROM tbl_product WHERE brandId = '3'order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }
        public function getLastestOppo(){
            $query = "SELECT * FROM tbl_product WHERE brandId = '5'order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }
        public function getLastestHuawei(){
            $query = "SELECT * FROM tbl_product WHERE brandId = '6'order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }
        public function get_compare($customer_id){
            $query = "SELECT * FROM tbl_compare WHERE customer_id = '$customer_id'order by id desc ";
            $result = $this->db->select($query);
            return $result;
        }
        public function get_wishlist($customer_id){
            $query = "SELECT * FROM tbl_wishlist WHERE customer_id = '$customer_id'order by id desc ";
            $result = $this->db->select($query);
            return $result;
        }
        public function insertCompare($productid,$customer_id){
            $productid = $this->fm->validation($productid);
            $customer_id = mysqli_real_escape_string($this->db->link, $customer_id);

            $check_compare = "SELECT * FROM tbl_compare where productId = '$productid' AND customer_id = $customer_id";
            $result_check_compare = $this->db->select($check_compare);
            // var_dump($result_check_compare);
            if($result_check_compare){
                $msg = "<span class='error'>Product Already Added To Compare</span>";
                return $msg;
            }else{
                $query = "SELECT * FROM tbl_product where productId = '$productid'";
                $result = $this->db->select($query)->fetch_assoc();
                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];
                    $query_insert = "INSERT INTO `tbl_compare`(`productId`, `price`, `image`, `customer_id`, `productName`) VALUES ('$productid','$price','$image','$customer_id','$productName')";
                    $insert_compare = $this->db->insert($query_insert);
                    if($insert_compare){
                        $alert = "<span class='success'>Added Compare Successfully</span>";
                        return $alert;
                    }else{
                        $alert = "<span class='error'>Added Compare Not Success</span>";
                        return $alert;
                    }
            }
        }
        public function insertwishlist($productid,$customer_id){
            $productid = $this->fm->validation($productid);
            $customer_id = mysqli_real_escape_string($this->db->link, $customer_id);

            $check_wlist = "SELECT * FROM tbl_wishlist where productId = '$productid' AND customer_id = $customer_id";
            $result_check_wishlist = $this->db->select($check_wlist);
            if($result_check_wishlist){
                $msg = "<span class='error'>Product Already Added To Wishlist</span>";
                return $msg;
            }else{
                $query = "SELECT * FROM tbl_product where productId = '$productid'";
                $result = $this->db->select($query)->fetch_assoc();
                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];
                    $query_insert = "INSERT INTO `tbl_wishlist`(`productId`, `price`, `image`, `customer_id`, `productName`) VALUES ('$productid','$price','$image','$customer_id','$productName')";
                    $insert_wishlist = $this->db->insert($query_insert);
                    if($insert_wishlist){
                        $alert = "<span class='success'>Added To Wishlist Successfully</span>";
                        return $alert;
                    }else{
                        $alert = "<span class='error'>Added To Wishlist Not Success</span>";
                        return $alert;
                    }
            }
        }
    }
?>