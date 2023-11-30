<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');


    class cart
    {
        private $db;
        private $fm;


        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();
        }
        public function add_to_cart($quantity,$product_stock,$id){
            $quantity = $this->fm->validation($quantity);
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $product_stock = $this->fm->validation($product_stock);
            $product_stock = mysqli_real_escape_string($this->db->link, $product_stock);
            $id = mysqli_real_escape_string($this->db->link, $id);
            $sId = session_id();
            // var_dump($sId);
            $check_cart = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId = '$sId'";
            $result_check_cart = $this->db->select($check_cart);
            if($quantity <= $product_stock){//nếu sl đặt nhỏ hơn sl có trong kho
                
                if($result_check_cart){
                    $result_check_cart = $result_check_cart->fetch_assoc();
                     $quantity_update = $result_check_cart['quantity'] + $quantity;
                    if($quantity_update <= $product_stock){
                        $query = "UPDATE `tbl_cart` SET `quantity` = '$quantity_update' WHERE productId = '$id' AND sId = '$sId'";
                        $result = $this->db->update($query);
                    }else{
                        $msg = "<span class='error'>Số lượng tồn kho không đủ.</span>";
                        return $msg;
                    }



                    
                    // khi vào trường hợp này sản phẩm sẽ thêm 1 đơn vị
                    /*
                    1, kiểm tra xem trong database số lượng hiện tại là bao nhiêu $check_cart['quantity'] = 1
                    2, cập nhật dữ liệu của product trong cart
                        $quantity_update = $check_cart['quantity'] + 1 
                        UPDATE `tbl_cart` SET `quantity` = ' $quantity_update' WHERE productId = '$id' AND sId = '$sId';
                    */
                    // $sId,$id
                }else{
                    $query = "SELECT * FROM tbl_product where productId = '$id'";
                    $result = $this->db->select($query)->fetch_assoc();
                    
                    $image = $result['image'];
                    $price = $result['price'];
                    $productName = $result['productName'];

                    $query_insert = "INSERT INTO `tbl_cart`(`stock`,`productId`, `quantity`, `sId`, `image`, `price`, `productName`) VALUES ('$product_stock','$id','$quantity','$sId','$image','$price','$productName')";
                    $insert_cart = $this->db->insert($query_insert);
                    if($insert_cart){
                        $msg = "<span class='error'>Thêm sản phẩm thành công</span>";
                        return $msg;
                    }
                }
            }else{
                $msg = "<span class='error'>Số lượng đặt phải nhỏ hơn số lượng tồn kho.</span>";
                return $msg;
            }
        }
        public function get_product_cart(){
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart where sId = '$sId'";
            $result = $this->db->select($query);
            return $result; 
        }
        public function get_product_cart_checkout(){
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart where sId = '$sId' AND tbl_cart.status=1";
            $result = $this->db->select($query);
            return $result; 
        }
        public function update_quantity_cart($quantity,$stock, $cartId){
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $stock = mysqli_real_escape_string($this->db->link, $stock);
            $cartId = mysqli_real_escape_string($this->db->link, $cartId);
            if($stock >= $quantity){
                $query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE cartId = '$cartId'";
                $result = $this->db->update($query);
                if($result){
                    $msg = "<span class='success'>Product Quantity Update Successfully</span>";
                    return $msg;
                }else{
                    $msg = "<span class='error'>Product Quantity Update Not Successfully</span>";
                    return $msg;
                }
            }else{
                $msg = "<span class='error'>Số lượng tồn kho không đủ.</span>";
                return $msg;
            }
           
        }
        public function del_product_cart($cartid){
            $cartid = mysqli_real_escape_string($this->db->link, $cartid);
            $query = "DELETE FROM tbl_cart WHERE cartId = $cartid";
            $result = $this->db->delete($query);
            if($result){
                header("Location:cart.php");
            }else{
                $msg = "<span class='error'>Product Quantity Delete Not Successfully</span>";
                return $msg;
            }
        }
        public function check_cart(){
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->select($query);
            return $result; 
        }
        public function check_oder($customer_id){
            $sId = session_id();
            $query = "SELECT * FROM tbl_oder WHERE customer_id = '$customer_id'";
            $result = $this->db->select($query);
            return $result; 
        }
        public function dell_all_data_cart(){
            $sId = session_id();
            $query = "DELETE FROM tbl_cart WHERE sId = '$sId' AND status = '1';";
            $result = $this->db->delete($query);
            return $result; 
        }
        public function dell_compare($customer_id){
            $sId = session_id();
            $query = "DELETE FROM tbl_compare WHERE customer_id = '$customer_id'";
            $result = $this->db->delete($query);
            return $result;
        }
        public function insertOder($customer_id){
            $sId = session_id();
            $query = "SELECT * FROM `tbl_cart` WHERE `sId` LIKE '$sId' AND `status` = 1";//chọn sản phẩm từ giỏ hàng
            $get_product = $this->db->select($query);
            $oder_code = rand(0000,9999);
            //$customer_id = $customer_id;
            // insert vào tbl_placed
            $query_placed = "INSERT INTO `tbl_placed`(`customer_id`, `oder_code`, `status`) VALUES (' $customer_id','$oder_code','0')";
            $insert_placed = $this->db->insert($query_placed);
            if($get_product){
                while($result = $get_product->fetch_assoc()){
                    $productid = $result['productId'];
                    $productName = $result['productName'];
                    $quantity = $result['quantity'];
                    $price = $result['price'] * $quantity;
                    $image = $result['image'];
                    //$customer_id = $customer_id;
                    $query_oder = "INSERT INTO `tbl_oder`(`oder_code`,`productId`, `productName`, `quantity`, `price`, `image`, `customer_id`) VALUES ('$oder_code','$productid',
                    '$productName','$quantity','$price','$image','$customer_id')";
                    $insert_oder = $this->db->insert($query_oder);
                    //var_dump($insert_oder);
                }
            }
        }
        public function getAmountPrice($customer_id){
            $query = "SELECT price FROM tbl_oder WHERE customer_id = $customer_id";
            $get_price = $this->db->select($query);
            return $get_price;
        }
        public function get_cart_ordered($customer_id){
            $query = "SELECT * FROM tbl_oder WHERE customer_id = $customer_id";
            $get_cart_ordered = $this->db->select($query);
            return $get_cart_ordered;
        }
        public function get_inbox_cart(){
            $query = "SELECT * FROM tbl_placed, tbl_customer WHERE tbl_placed.customer_id=tbl_customer.id ORDER BY date_created";
            $get_inbox_cart = $this->db->select($query);
            return $get_inbox_cart;
        }
        public function get_inbox_cart_history($customer_id){
            $query = "SELECT * FROM tbl_placed, tbl_customer WHERE tbl_placed.customer_id=tbl_customer.id AND tbl_placed.customer_id=$customer_id ORDER BY date_created DESC";
            $get_inbox_cart = $this->db->select($query);
            return $get_inbox_cart;
        }
        public function shifted($id){
            $id = mysqli_real_escape_string($this->db->link, $id);
            $query = "UPDATE tbl_placed SET status = '1' WHERE oder_code = '$id'";
            $result = $this->db->update($query);
            $msg = "<span class='error'>Oder Update Not Successfully</span>";
            if($result){
                $msg = "<span class='success'>Oder Update Successfully</span>";
                return $msg;
            }  
            return $msg;
        }
        public function confirm_recieved($id){
            $id = mysqli_real_escape_string($this->db->link, $id);
            $query = "UPDATE tbl_placed SET status = '2' WHERE oder_code = '$id'";
            $result = $this->db->update($query);
            $msg = "<span class='error'>Oder Update Not Successfully</span>";
            if($result){
                $msg = "<span class='success'>Oder Update Successfully</span>";
                return $msg;
            }  
            return $msg;
        }
        public function del_shitfted($id){
            $id = mysqli_real_escape_string($this->db->link, $id);
            $query = "DELETE FROM tbl_placed WHERE oder_code = '$id'";
            $result = $this->db->delete($query);
            $msg = "<span class='error'> Oder Delete Not Successfully</span>";
            if($result){
                $msg = "<span class='success'> Oder Delete Successfully</span>";
                return $msg;
            }
            return $msg;
            
        }
        public function shifted_confirm($id,$time,$price){
            $id = mysqli_real_escape_string($this->db->link, $id);
            $time = mysqli_real_escape_string($this->db->link, $time);
            $price = mysqli_real_escape_string($this->db->link, $price);
            $query = "UPDATE tbl_oder SET status = '2' WHERE customer_id = '$id' AND date_oder = '$time' AND price = $price";
            $result = $this->db->update($query);
            return $result;
        }
    }
?>