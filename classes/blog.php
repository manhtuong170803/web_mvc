<?php
    $filepath = realpath(dirname(__FILE__));
   include_once ($filepath.'/../lib/database.php');
   include_once ($filepath.'/../helpers/format.php');


    class blog
    {
        private $db;
        private $fm;


        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function insert_blog($data,$files){
            $title = mysqli_real_escape_string($this->db->link, $data['title']);
            $category = mysqli_real_escape_string($this->db->link, $data['category_post']);
            $desc = mysqli_real_escape_string($this->db->link, $data['desc']);
            $content = mysqli_real_escape_string($this->db->link, $data['content']);
            $status = mysqli_real_escape_string($this->db->link, $data['status']);
            // $status = mysqli_real_escape_string($this->db->link, $data['status']);
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
            $alert = "";
            if($title=="" || $category=="" || $desc=="" ||$content=="" || $status=="" || $file_name=="" ){
                $alert = "<span class='error'>Fields must be not empty</span>";
            }else{
                move_uploaded_file($file_temp,$uploaded_image);
                $query = "INSERT INTO `tbl_blog` (`title`, `description`, `content`, `category_post`, `image`, `status`) VALUES ('$title','$desc','$content','$category','$unique_image','$status')";
                $result = $this->db->insert($query);
                if($result){
                    $alert = "<span class='success'>Insert BLog Successfully</span>";
                }else{
                    $alert = "<span class='error'>Insert Blog Not Success</span>";
                }
            }
            return $alert;
        }
        public function show_blog(){
            $query = "SELECT tbl_blog.*,tbl_category_post.title
                    FROM tbl_blog INNER JOIN tbl_category_post ON tbl_category_post.id_cate_post = tbl_blog.category_post
                    order by tbl_blog.id desc";
            // $query = "SELECT * FROM tbl_product order by productId desc";
            $result = $this->db->select($query);
            return $result;
        }
        public function update_blog($data,$files,$id){
            $title = mysqli_real_escape_string($this->db->link, $data['title']);
            $category = mysqli_real_escape_string($this->db->link, $data['category_post']);
            $desc = mysqli_real_escape_string($this->db->link, $data['desc']);
            $content = mysqli_real_escape_string($this->db->link, $data['content']);
            $status = mysqli_real_escape_string($this->db->link, $data['status']);
            // Kiểm tra hình ảnh và lấy hình ảnh cho vào folder upload
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()),0,10).''.$file_ext;
            $uploaded_image = "uploads/" . $unique_image;

            if($title=="" || $category=="" || $desc=="" ||$content=="" || $status=="" ){
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
                    $query = "UPDATE tbl_blog SET 
                    title = '$title',
                    category_post = '$category',
                    status = '$status',
                    content = '$content',
                    image = '$unique_image',
                    description = '$desc'
                    WHERE id = '$id'";
                }else{
                    // Nếu người dùng không chọn ảnh
                    $query = "UPDATE tbl_blog SET 
                    title = '$title',
                    category_post = '$category',
                    status = '$status',
                    content = '$content',
                    description = '$desc'
                    WHERE id = '$id'";
                }
                $result = $this->db->update($query);
                if($result){
                    $alert = "<span class='success'>Blog Update Successfully</span>";
                    return $alert;
                }else{
                    $alert = "<span class='error'>Blog Update Not Success</span>";
                    return $alert;
                }
            }
        }
        public function del_blog($id){
            $query = "DELETE FROM tbl_blog where id = '$id'";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Blog Delete Successfully</span>";
                return $alert;
            }else{
                $alert = "<span class='error'>Blog Delte Not Success</span>";
                return $alert;
            }
        }
        public function getblogbyId($id){
            $query = "SELECT * FROM tbl_blog where id = '$id'";
            $result = $this->db->select($query);
            return $result;
        }
    }
?>