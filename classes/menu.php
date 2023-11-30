<?php
    $filepath = realpath(dirname(__FILE__));
   include_once ($filepath.'/../lib/database.php');
   include_once ($filepath.'/../helpers/format.php');

    class menu
    {
        private $db;
        private $fm;


        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();
        }
        public function insert_menu($data){
            
            $menuName = $this->fm->validation($data['menuName']);
            $menuLink = $this->fm->validation($data['menuLink']);
            $menuPrioritize = $this->fm->validation($data['menuPrioritize']);
            
            $menuName = mysqli_real_escape_string($this->db->link, $menuName);
            $menuLink = mysqli_real_escape_string($this->db->link, $menuLink);
            $menuPrioritize = mysqli_real_escape_string($this->db->link, $menuPrioritize);

            $query = "INSERT INTO `tbl_menu` (`menuId`, `menuName`, `menuLink`, `menuPrioritize`) VALUES (NULL, '$menuName', '$menuLink', '$menuPrioritize');";
            $result = $this->db->insert($query);

            if($result){
                $alert = "<span class='success'>Insert Menu Successfully</span>";
            }else{
                $alert = "<span class='error'>Insert Menu Not Success</span>";
            }
            return $alert;
        }
        public function show_menu(){
            $query = "SELECT * FROM `tbl_menu` ORDER BY `tbl_menu`.`menuPrioritize` DESC";
            $result = $this->db->select($query);
            return $result;
        }
        public function show__menu_home(){
            $query = "SELECT * FROM `tbl_menu` ORDER BY `tbl_menu`.`menuPrioritize` DESC";
            $result = $this->db->select($query);
            return $result;
        }
        public function getmenubyId($id){
            $query = "SELECT * FROM `tbl_menu` WHERE `menuId` = '$id'";
            $result = $this->db->SELECT($query);
            return $result;
        }
        public function update_menu($data, $id){
            $menuName = $this->fm->validation($data['menuName']);
            $menuLink = $this->fm->validation($data['menuLink']);
            $menuPrioritize = $this->fm->validation($data['menuPrioritize']);
            
            $menuName = mysqli_real_escape_string($this->db->link, $menuName);
            $menuLink = mysqli_real_escape_string($this->db->link, $menuLink);
            $menuPrioritize = mysqli_real_escape_string($this->db->link, $menuPrioritize);
            $id = mysqli_real_escape_string($this->db->link, $id);
            
            $query = "UPDATE `tbl_menu` SET `menuName` = '$menuName', `menuLink` = '$menuLink', `menuPrioritize` = '$menuPrioritize' WHERE `tbl_menu`.`menuId` = '$id';";

            $result = $this->db->Update($query);
            if($result){
                $alert = "<span class='success'>Menu Update Successfully</span>";
            }else{
                $alert = "<span class='error'>Menu Update Not Success</span>";
            }
            return $alert;
        }
        public function del_menu($id){
            
            $query = "DELETE FROM `tbl_menu` WHERE `tbl_menu`.`menuId` = '$id';";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Menu Delete Successfully</span>";
            }else{
                $alert = "<span class='error'>Menu Delete Not Success</span>";
            }
            return $alert;
        }
    }
?>