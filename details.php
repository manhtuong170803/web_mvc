<?php
     include 'inc/header.php';
	//  include 'inc/slider.php';
?>
<?php
	   if(!isset($_GET['proid']) || $_GET['proid']==Null){
		echo "<script>'window.location:81 = '404.php'</script>";
	  }else{
		   $id = $_GET['proid'];
	  }
	  $customer_id = Session::get('customer_id');
	  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])){
		$productid = $_POST['productid'];
		$inserCompare = $product->insertCompare($productid,$customer_id);
		
	  }
	  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlist'])){
		$productid = $_POST['productid'];
		$inserWishlist = $product->insertwishlist($productid,$customer_id);
	  }
	  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
		$product_stock = $_POST['product_stock'];
		$quantity = $_POST['quantity'];
		$AddtoCart = $ct->add_to_cart($quantity,$product_stock,$id);
		
	  }
	  if(isset($_POST['binhluan_submit'])){
		$binhluan_insert = $cs->insert_binhluan();
	  }
?>


 <div class="main">
    <div class="content">
    	<div class="section group">
			<?php
				$get_product_details = $product->get_details($id);
				if($get_product_details){
					while($result_details = $get_product_details->fetch_assoc()){
			
			?>
			<div class="cont-desc span_1_of_2">				
				<div class="grid images_3_of_2">
					<img src="admin/uploads/<?php echo $result_details['image'];?>" alt="" />
				</div>
				<div class="desc span_3_of_2">
					<h2><?php echo $result_details['productName']?></h2>
					<p><?php echo $fm->textShorten($result_details['product_desc'],150); ?></p>
					<div class="price">
						<p>Price: <span><?php echo $fm->format_currency($result_details['price'])." "."VND";?></span></p>
						<p>Category: <span><?php echo $result_details['catName'];?></span></p>
						<p>Brand:<span><?php echo $result_details['brandName'];?></span></p>
						<p>Stock:<span><?php echo $result_details['product_quantity'];?>/ Cái</span></p>
					</div>
					<div class="add-cart">
						<form action="" method="post">
							<input type="hidden" class="buyfield" name="product_stock" value="<?php echo $result_details['product_quantity'];?>"/>
							<input type="number" class="buyfield" name="quantity" value="1" min="1"/>
							<?php
								if($result_details['product_quantity']>0){
							?>
							<input type="submit" class="buysubmit" name="submit" value="Buy Now"/>
							<?php
								}
							?>
						</form>	
						<?php
							if(isset($AddtoCart)){
								echo $AddtoCart;
							}
						?>	
					</div>
					<div class="add-cart">
						<div class="button-details">
							<form action="" method="POST">
							<input type="hidden" name="productid" value="<?php echo $result_details['productId'];?>"/>
							<input type="hidden" name="customerlogin" class="customer_login" value="<?php echo $login_check = Session::get('customer_login');?>"/>
							<?php
								$login_check = Session::get('customer_login');
								// var_dump($login_check);
    							if($login_check){
       								echo '<input type="submit" class="buysubmit" name="compare" value="Compare Product"/>';
   			 					}else{
									echo '';
								}
							?>
						
							</form>
							<form action="" method="POST">
							<input type="hidden" name="productid" value="<?php echo $result_details['productId'];?>"/>
							<?php
								$login_check = Session::get('customer_login');
    							if($login_check){
									echo '<input type="submit" class="buysubmit" name="wishlist" value="Save To Wishlist"/>';
   			 					}else{
									echo '';
								}
							?>
						
							</form>
						</div>
						<div class="clear"></div>
						<p>
						<?php
							if(isset($inserCompare)){
								echo $inserCompare;
							}
						?>
						<?php
							if(isset($inserWishlist)){
								echo $inserWishlist;
							}
						?>
						</p>
					</div>
				</div>
				<div class="product-desc">
				<h2>Product Details</h2>
				<?php echo $fm->textShorten($result_details['product_desc'],150);?>
				</div>
			</div>
			<?php
					}
				}
			?>
				<div class="rightsidebar span_3_of_1">
					<h2>CATEGORIES</h2>
					<ul>
						<?php
							$getall_category = $cat->show_category_fontend();
							if($getall_category){
								while($result_allcat = $getall_category->fetch_assoc()){
						?>
				      <li><a href="productbycat.php?catid=<?php echo $result_allcat['catId'];?>"><?php echo $result_allcat['catName'];?></a></li>
					  <?php
					 			}
							} 
					  ?>
    				</ul>
 				</div>
 		</div>
		<div class="binhluan">
			<div class="row">
				<div class="col-md-8">
					<h5>Bình luận sản phẩm</h5>
					<ul>
					<?php
						$get_product_details_2 = $product->get_details_2($id);
						if($get_product_details_2){
							while($result_details2 = $get_product_details_2->fetch_assoc()){
					
					?>
						<?php
							for($count = 1; $count <= 5; $count++){
								if($count<=4){
									$color = 'color:#ffcc00;'; //màu vàng
								}else{
									$color = 'color:#ccc;'; //màu xám
								}
						?>
						<li class="rating" style="cursor:pointer;font-size:40px;<?php echo $color;?>"
							id="<?php echo $result_details2['productId']; ?>-<?php echo $count;?>"
							data-prodcut_id="<?php echo $result_details2['productId']; ?>"
							data-rating="<?php echo $count;?>"
							data-index="<?php echo $count;?>"
						>
						&#9733;
						</li>
						<?php
						}
						?>
						<li>Đã đánh giá : 4/5</li>
					</ul>
					<?php
							}
						}
					?>
					<?php
						if(isset($binhluan_insert)){
							echo $binhluan_insert;
						}
					?>
					<form action="" method="POST">
						<p><input type="hidden" value="<?php echo $i;?>" name="product_id_binhluan"></input></p>
						<p><input type="text" style="width: 100%;" placeholder="Điền tên" class="from-control" name="tennguoibinhluan"></input></p>
						<p><textarea name="binhluan" style="resize:none;width: 100%;" placeholder="Bình luận..." class="from-control" rows="5"></textarea></p>
						<p><input type="submit" name="binhluan_submit" class="btn btn-success" value="Gửi bình luận"></input></p>
					</form>
				</div>
			</div>
		</div>

 	</div>

	 <?php
    include 'inc/footer.php';
?>




