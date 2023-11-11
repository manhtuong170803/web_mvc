<?php
     include 'inc/header.php';
	//  include 'inc/slider.php';
?>
<?php
	$id = "";
   if(!isset($_GET['catid']) || $_GET['catid']==Null){
     echo "<script>'window.location:81 = '404.php'</script>";
   }else{
        $id = $_GET['catid'];
   }
//    if($_SERVER['REQUEST_METHOD'] === 'POST'){
//         $catName = $_POST['catName'];
//         $updateCat = $cat->update_category($catName, $id);	
//     }

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['themgiohang'])){
		$product_stock = $_POST['stock'];
		$quantity = $_POST['quantity'];
		$id = $_POST['productId'];
		$insertCart = $ct->add_to_cart($quantity,$product_stock,$id);
		if($insertCart){
			echo "<script>'window.localhost:81/cart.php'</script>";
		}
	}
?>

 <div class="main">
    <div class="content">
    	<div class="content_top">
		<?php 
			
			$catName = $cat->get_name_by_cat($id);
			
			if($catName){
				while($result_name = $catName->fetch_assoc()){
		?>
    		<div class="heading">
    		<h3>Category : <?php echo $result_name['catName'];?></h3>
    		</div>
			<?php
					}
				}
			?>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
				<?php
				
					$productbycat = $cat->get_product_by_cat($id);
					
					if($productbycat){
						while($result = $productbycat->fetch_assoc()){
				?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="preview-3.php"><img src="admin/uploads/<?php echo $result['image']; ?>" width="200px" alt="" /></a>
					 <h2><?php echo $result['productName']; ?></h2>
					 <p><?php echo $fm->textShorten($result['product_desc'],50); ?></p>
					 <p><?php echo $fm->format_currency($result['price'])." "."VND";?></p>
					 <form action="" method="FOSt">
						<input type="hidden" name="quantity" value="1"></input>
						<input type="hidden" name="stock" value="<?php echo $result['product_quantity'];?>"></input>
						<input type="hidden" name="productId" value="<?php echo $result['productId'];?>"></input>
						<input type="submit" name="themgiohang" value="Thêm giỏ hàng" class="btn btn-default"></input>
					 </form>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a></span></div>
				</div>
				<?php
						}
					}else{
						echo 'Category Not Avaiable';
					}
				?>

			</div>

	
	
    </div>
 </div>

 <?php
    include 'inc/footer.php';
?>