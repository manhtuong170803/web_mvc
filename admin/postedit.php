<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/post.php';?>
<?php
   if(!isset($_GET['catid']) || $_GET['catid']==Null){
     echo "<script>'window.location:81 = 'catlist.php'</script>";
   }else{
        $id = $_GET['catid'];
   }
   $post = new post();
   if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $catName = $_POST['catName'];
        $catDesc = $_POST['catDesc'];
        $catStatus = $_POST['catStatus'];
        $updateCat = $post->update_category_post($catName,$catDesc,$catStatus,$id);
    }
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Sửa danh mục tin tức</h2>
               <div class="block copyblock"> 
                <?php 
                    if(isset($updateCat)){
                        echo $updateCat;
                    }
                ?>
                <?php 
                    $get_cate_name = $post->getcatbyId($id);
                    if($get_cate_name){
                        while($result = $get_cate_name->fetch_assoc()){
                ?>
                 <form method='post'>
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['title'];?>" name="catName" placeholder="Sửa danh mục sản phẩm..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['description']; ?>" name="catDesc" placeholder="Sửa danh mục sản phẩm..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                               <select name="catStatus">
                                <?php
                                    if($result['status']==0){
                                ?>
                                <option selected value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>
                                <?php
                                    }else{
                                ?>
                                <option value="0">Hiển thị</option>
                                <option selected value="1">Ẩn</option>
                                <?php
                                    }
                                ?>
                               </select>
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Update" />
                            </td>
                        </tr>
                    </table>
                    </form>
                    <?php
                     }
                        }
                    ?>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>