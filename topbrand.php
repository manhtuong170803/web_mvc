<?php
     include 'inc/header.php';
	 include 'inc/slider.php';
?>
<?php
	 if(!isset($_GET['brandid']) || $_GET['brandid']==Null){
		echo "<script>'window.location:81 = '404.php'</script>";
	  }else{
		   $id = $_GET['brandid'];
	  }
?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['themgiohang'])){
		$product_stock = $_POST['stock'];
		$quantity = $_POST['quantity'];
		$id = $_POST['productId'];
		$insertCart = $ct->add_to_cart($quantity,$product_stock,$id);
		if($insertCart){
			echo "<script>'window.location:81 = 'cart.php'</script>";
		}
	}
?>
 <div class="main">
    <div class="content">
    	<?php
			$name_brand = $br->get_name_by_brand($id);
			if($name_brand){
				while($result_name = $name_brand->fetch_assoc()){
				?>
				<div class="content_top">
					<div class="heading">
						<h3>Thương hiệu : <?php echo $result_name['brandName']?></h3>
					</div>
					<div class="clear"></div>
				</div>
				<?php
				}
			}
		?>
		<div class="section_group">
			<?php
				$brandpr = $br->get_product_by_brand($id);
				if($brandpr){
					while($result = $brandpr->fetch_assoc()){
						//var_dump($result);
					?>
					 <div >
						<a href="detail.php?=<?php echo $result['productName']; ?>">
							<img src="admin/uploads/<?php  echo $result['image']; ?>" />
						</a>
						<h2><?php echo $result['productName']; ?></h2>
						<p><?php echo $fm->textShorten($result['product_desc'],50); ?></p>
						<p><span class="price"><?php echo $fm->format_currency($result['price'])." "."VND";?></span></p>
						<form action="" method="POST">
							<input type="hidden" name="quantity" value="1"></input>
							<input type="hidden" name="stock" value="<?php echo $result['product_quantity'];?>"></input>
							<input type="hidden" name="productId" value="<?php echo $result['productId'];?>"></input>
							<input type="submit" name="themgiohang" value="Thêm giỏ hàng" class="btn btn-default"></input>
						</form>
						<div class="button">
							<span><a href="details.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a></span>
						</div>
					</div>
					<?php
					}
				}else{
					echo 'Thương hiệu hiện tại chưa có sản phẩm';
				}
			?>
		</div>

    </div>
 </div>

 <?php
    include 'inc/footer.php';
?>