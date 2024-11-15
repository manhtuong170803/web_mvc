<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');


    class brand
    {
        private $db;
        private $fm;


        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();
        }
        public function insert_brand($brandName){
            
            $brandName = $this->fm->validation($brandName);
            $brandName = mysqli_real_escape_string($this->db->link, $brandName);

            if(empty($brandName)){
                $alert = "<span class='error'>Brand must be not empty</span>";
                return $alert;
            }else {
            
                // $query = "INSERT INTO tbl_category(catName) VALUES($catName)";
                $query = "INSERT INTO `tbl_brand` (`brandName`) VALUES ('$brandName');";
                $result = $this->db->insert($query);
                if($result){
                    $alert = "<span class='success'>Insert Brand Successfully</span>";
                    return $alert;
                }else{
                    $alert = "<span class='error'>Insert Brand Not Success</span>";
                    return $alert;
                }
            }
        }
        public function show_brand(){
            $query = "SELECT * FROM tbl_brand order by brandId desc";
            $result = $this->db->SELECT($query);
            return $result;
        }
        public function show__brand_home(){
            $query = "SELECT * FROM tbl_brand order by brandId desc";
            $result = $this->db->select($query);
            return $result;
        }
        public function getbrandbyId($id){
            $query = "SELECT * FROM tbl_brand where brandId = '$id'";
            $result = $this->db->SELECT($query);
            return $result;
        }
        public function get_name_by_brand($id){
            $query = "SELECT tbl_brand.*,tbl_category.catName,tbl_category.catId FROM tbl_brand,tbl_category 
            WHERE tbl_brand.brandId=tbl_category.catId AND tbl_brand.brandId = '$id' LIMIT 1;";
            $result = $this->db->select($query);
            return $result;
        }
        public function get_product_by_brand($id){
            $query = "SELECT * FROM tbl_product WHERE brandId = '$id' order by productId desc LIMIT 8;";
            $result = $this->db->select($query);
            return $result;
        }
        public function update_brand($brandName,$id){
            $brandName = $this->fm->validation($brandName);
            $brandName = mysqli_real_escape_string($this->db->link, $brandName);
            $id = mysqli_real_escape_string($this->db->link, $id);

            if(empty($brandName)){
                $alert = "<span class='error'>Brand must be not empty</span>";
                return $alert;
            }else {
            
                // $query = "INSERT INTO tbl_brand(catName) VALUES($catName)";
                $query = "UPDATE tbl_brand SET brandName = '$brandName' WHERE brandId = '$id'";
                $result = $this->db->Update($query);
                if($result){
                    $alert = "<span class='success'>Brand Update Successfully</span>";
                    return $alert;
                }else{
                    $alert = "<span class='error'>Brand Update Not Success</span>";
                    return $alert;
                }
            }
        }
        public function del_brand($id){
            $query = "DELETE FROM tbl_brand where brandId = '$id'";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Brand Delete Successfully</span>";
                return $alert;
            }else{
                $alert = "<span class='error'>Brand Delete Not Success</span>";
                return $alert;
            }
        }
    }
?>