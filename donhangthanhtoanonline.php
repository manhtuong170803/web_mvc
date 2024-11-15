<?php
     include 'inc/header.php';
	 include 'inc/slider.php';
?>

<?php
	if(isset($_GET['cartid'])){
		$cartid = $_GET['cartid'];
		$delcart = $ct->del_product_cart($cartid);
	}

	  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
		$cartId = $_POST['cartId'];
		$quantity = $_POST['quantity'];
		$update_quantity_cart = $ct->update_quantity_cart($quantity, $cartId);
		if($quantity<=0){
			$delcart = $ct->del_product_cart($cartId);
		}
	  }

?>

 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Your Cart</h2>
					<?php
						if(isset($update_quantity_cart)){
							echo $update_quantity_cart;
						}
					?>
						<?php
						if(isset($delcart)){
							echo $delcart;
						}
					?>
						<table class="tblone">
							<tr>
								<th width="20%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="25%">Quantity</th>
								<th width="20%">Total Price</th>
								<th width="10%">Action</th>
							</tr>
							<?php
								$get_product_cart = $ct->get_product_cart();
								if($get_product_cart){
									$subtotal = 0;
									$qty = 0;
									while($result = $get_product_cart->fetch_assoc()){
							?>
							<tr>
								<td><?php echo $result['productName'] ?></td>
								<td><img src="admin/uploads/<?php echo $result['image']; ?>" alt=""/></td>
								<td><?php echo $fm->format_currency($result['price'])." "."VND"?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="cartId" value="<?php echo $result['cartId'];?>"/>
										<input type="number" name="quantity" min="0" value="<?php echo $result['quantity']; ?>"/>
										<input type="submit" name="submit" value="Update"/>
									</form>
								</td>
								<td><?php 
									$total = $result['price'] * $result['quantity'];
									echo $fm->format_currency($total)." "."VND";
								?></td>
								<td><a href="?cartid=<?php echo $result['cartId']; ?>">Xoá</a></td>
							</tr>
							<?php
									$subtotal += $total;
									$qty = $qty + $result['quantity'];
									}
								}
							?>
						</table>
						<?php 
							$check_cart = $ct->check_cart();
								if($check_cart){				
						?>
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td><?php
								 	echo $fm->format_currency($subtotal)." "."VND";
									Session::set('sum',$subtotal);
									Session::set('qty',$qty);
								 ?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>10%</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td><?php
									$vat = $subtotal * 0.1;
									$gtotal = $subtotal + $vat;
									echo $fm->format_currency($gtotal)." "."VND";
								?> </td>
							</tr>
					   </table>
					   <?php
							}else{
								echo 'You Cart Is Empty ! Plaease Shopping Now';
							}
					   ?>
					</div>
                    <?php
                        $check_cart = $ct->check_cart();
                        if(Session::get('customer_id')==true && $check_cart){
                    ?>
                    <a href="payment/php" class="btn btn-success btn-thanhtoan">Thanh toán giỏ hàng</a>
                    <?php
                        }
                    ?>
					
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

 <?php
    include 'inc/footer.php';
?>