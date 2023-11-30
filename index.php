<?php
     include 'inc/header.php';
	 include 'inc/slider.php';
?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['themgiohang'])){
		$product_stock = $_POST['stock'];
		$quantity = $_POST['quantity'];
		$id = $_POST['productId'];
		$insertCart = $ct->add_to_cart($quantity,$product_stock,$id);
		// if($insertCart){
		// 	echo "<script>'window.localhost:cart.php'</script>";
		// }
	}
?>

 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    			<h3>Feature Products</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
	    	<div class="section section-products">
				<?php
					$product_feathered = $product->get_all_product_2();
					if($product_feathered){
						while($result = $product_feathered->fetch_assoc()){
							?>
							<div class="grid_1_of_4 images_1_of_4">
								<a href="details.php?proid=<?php echo $result['productId'];?>">
									<img src="admin/uploads/<?php echo $result['image'];?>" alt="" />
								</a>
								<h2><?php echo $result['productName'];?></h2>
								<p><?php //echo $fm->textShorten($result['product_desc'], 50);?></p>
								<span class="price"><?php echo $fm->format_currency($result['price'])." "."VND";?></span>
								<form action="" method="POST" class="section-from">
									<input type="hidden" class="add_to_cart" name="quantity" value="1"></input>
									<input type="hidden" class="add_to_cart" name="stock" value="<?php echo $result['product_quantity'];?>"></input>
									<input type="hidden" class="add_to_cart" name="productId" value="<?php echo $result['productId'];?>"></input>
									<div class="button">
										<a href="details.php?proid=<?php echo $result['productId'];?>" class="details">Details</a>
									</div>
									<input type="submit" name="themgiohang" value="Add to cart" class="btn btn-default"></input>
								</form>
							</div>
							<?php
						}
					}
				?>
			</div>
			<div class="page">
			<div class="see_more_feature">Xem thêm</div>
				<?php
					// $product_all_2 = $product-> get_all_product_2();
					// $product_count_2 = mysqli_num_rows($product_all_2);
					// $product_button_2 = ceil($product_count_2/4);
					// $i = 0;
					// echo '<p>Trang : </p>';
					// for($i=1;$i<=$product_button_2;$i++){
					// 	echo '<a class="page_a" style="margin:0px 5px"; href="index.php?page='.$i.'">'.$i.'</a>';
					// }
				?>
			</div>
		<div class="content_bottom">
    		<div class="heading">
    			<h3>New Products</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
			<div class="section section-products">
				<?php
					$product_new = $product->get_all_product();
					if($product_new){
						while($result_new = $product_new->fetch_assoc()){
							?>
							<div class="grid_1_of_4 images_1_of_4">
								<a href="details.php?proid=<?php echo $result_new['productId']?>">
									<img src="admin/uploads/<?php echo $result_new['image']?>" alt="" />
								</a>
								<h2><?php echo $result_new['productName']?></h2>
								<p><?php //echo $fm->textShorten($result_new['product_desc'], 50)?></p>
								<span class="price"><?php echo $fm->format_currency($result_new['price'])." "."VND"?></span>
								<form action="" method="POST" class="section-from">
									<input type="hidden" class="add_to_cart" name="quantity" value="1"></input>
									<input type="hidden" class="add_to_cart" name="stock" value="<?php echo $result_new['product_quantity'];?>"></input>
									<input type="hidden" class="add_to_cart" name="productId" value="<?php echo $result_new['productId'];?>"></input>
									<div class="button">
										<a href="details.php?proid=<?php echo $result_new['productId']?>" class="details">Details</a>
									</div>
									<input type="submit" name="themgiohang" value="Add to cart" class="btn btn-default"></input>
								</form>
							</div>
							<?php
						}
					}
				?>
			</div>
			<div class="page">
				<div class="see_more">Xem thêm</div>
				<?php
					// $product_all = $product-> get_all_product();
					// $product_count = mysqli_num_rows($product_all);
					// $product_button = ceil($product_count/4);
					// $i = 0;
					// echo '<p>Trang : </p>';
					// for($i=1;$i<=$product_button;$i++){
					// 	echo '<a style="margin:0px 5px"; href="index.php?trang='.$i.'">'.$i.'</a>';
					// }
				?>
			</div>
    </div>
 </div>

 <?php
     include 'inc/footer.php';
?>
