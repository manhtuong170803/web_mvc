<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/brand.php';?>
<?php
   if(!isset($_GET['brandid']) || $_GET['brandid']==Null){
     echo "<script>'window.location:81 = 'brandlist.php'</script>";
   }else{
        $id = $_GET['brandid'];
   }
   $brand = new brand();
   if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $brandName = $_POST['brandName'];
        $updatebrand = $brand->update_brand($brandName, $id);	
    }
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Sửa thương hiệu</h2>
               <div class="block copyblock"> 
                <?php 
                    if(isset($updatebrand)){
                        echo $updatebrand;
                    }
                ?>
                <?php 
                    $get_brand_name = $brand->getbrandbyId($id);
                    if($get_brand_name){
                        while($result = $get_brand_name->fetch_assoc()){
                ?>
                 <form method='post'>
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['brandName'] ?>" name="brandName" placeholder="Sửa thương hiệu sản phẩm..." class="medium" />
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