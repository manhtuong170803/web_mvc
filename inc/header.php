<?php
    include 'lib/session.php';
    session::init();
	include_once 'lib/database.php';
    include_once 'helpers/format.php';

	spl_autoload_register(function($class){
		include_once "classes/".$class.".php";
	});
	$db = new Database();
	$fm = new Format();
	$ct = new cart();
	$us = new user();
	$br = new brand();
	$cat = new category();
	$cs = new customer();
	$product = new product();
	$pos = new post();
	$menu = new menu();
	
?>

<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache"); 
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
  header("Cache-Control: max-age=2592000");
?>
<!DOCTYPE HTML>
<head>
<title>Store Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>
<script src="js/jquerymain.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="js/nav.js"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script> 
<script type="text/javascript" src="js/nav-hover.js"></script>
<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript">
  $(document).ready(function($){
    $('#dc_mega-menu-orange').dcMegaMenu({rowItems:'4',speed:'fast',effect:'fade'});
  });
</script>
</head>
<body>
  <div class="wrap">
		<div class="header_top">
			<div class="logo">
				<a href="index.php"><img src="images/logo.png" alt="" /></a>
			</div>
			  <div class="header_top_right">
			    <div class="search_box">
				    <form action="search.php" method="POST">
				    	<input type="text" placeholder="Tìm kiếm sản phẩm" name="tukhoa"></input>
						<input type="submit" name="search_product" value="Tìm kiếm"></input>
				    </form>
			    </div>
			    <div class="shopping_cart">
					<div class="cart">
						<?php
						$check_cart = $ct->check_cart();
						if($check_cart){
							?>
							<a href="cart.php" title="View my shopping cart" rel="nofollow">
								<span class="cart_title">Cart</span>
								<span class="no_product">
									<?php 
										$sum = Session::get("sum");
										$qty = Session::get("qty");
										//var_dump($sum,$qty);
										echo $fm->format_currency($sum).' '.'đ'.'-'.'Qty:'.$qty;
									?>
								</span>
							</a>
							<?php
							}else{
								?>
								<a href="cart.php" title="View my shopping cart" rel="nofollow">
									<span class="cart_title">Cart</span>
									<span class="no_product">
										Empty
									</span>
								</a>
								<?php
							}
							?>
						</div>
			      </div>
			<?php
				if(isset($_GET['customer_id'])){
					$customer_id = $_GET['customer_id'];
					$delCart = $ct->dell_all_data_cart();
					$delCompare = $ct->dell_compare($customer_id);
					Session::destroy();
				}
			?>

		   <div class="login">
			<?php
				$login_check = Session::get('customer_login');
				if($login_check==false){
					echo '<a href="login.php">Login</a></div>';
				}else{
					echo '<a href="?customer_id='.Session::get('customer_id').'">Logout</a></div>';
				}
			?>
		 <div class="clear"></div>
	 </div>
	 <div class="clear"></div>
 </div>
<div class="menu">
	<ul id="dc_mega-menu-orange" class="dc_mm-orange">
	  	<?php
		$menu_list = $menu->show__menu_home();
		if($menu){
			while($result_menu = $menu_list->fetch_assoc()){
				if($result_menu['menuName'] == 'Products' ){
					?>
						<li class="dropdown">
							<a href="<?php echo $result_menu['menuLink']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $result_menu['menuName']; ?></a>
							<ul class="dropdown-menu">
								<?php
									$cate = $cat->show_category();
									if($cate){
										while($result_new = $cate->fetch_assoc()){
											//var_dump($result_new);
										?>
										<li>
											<a href="productbycat.php?catid=<?php echo $result_new['catId'];?>"><?php echo $result_new['catName'];?></a> 
										</li>
										<?php
										}
									}
								?>
							</ul>
						</li> 
					<?php
				}else if($result_menu['menuName'] == 'Top Brands' ){
					?>
						<li class="dropdown">
							<a href="<?php echo $result_menu['menuLink']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $result_menu['menuName']; ?></a>
							<ul class="dropdown-menu">
								<?php
									$brand = $br->show__brand_home();
									if($brand){
										while($result_new = $brand->fetch_assoc()){
											?>
											<li>
												<a href="topbrand.php?brandid=<?php echo $result_new['brandId']?>"><?php echo $result_new['brandName']?></a>
											</li>
											<?php
										}
									}
										
								?>
							</ul>
					</li>  
					<?php
				}else{
					if($result_menu['menuName'] == 'Cart' ){
						$check_cart = $ct->check_cart();
						if($check_cart==true){
							?>
								<li><a href="<?php echo $result_menu['menuLink']; ?>"><?php echo $result_menu['menuName']; ?></a></li> 
							<?php
						}
					}else{
						?>
							<li><a href="<?php echo $result_menu['menuLink']; ?>"><?php echo $result_menu['menuName']; ?></a></li> 
						<?php
					}
					
				}
			}
		}
		?>
			<?php
				// $customer_id = Session::get('customer_id');
				// if($customer_id != false){
				// 	$check_oder = $ct->check_oder($customer_id);
				// 	if($check_oder==true){
				// 		echo '<li><a href="oderdetails.php">Ordered</a></li>';
				// 	}else{
				// 		echo '';
				// 	}
				// }
			?>

			<?php
				// $login_check = Session::get('customer_login');
				// if($login_check==false){
				// 	echo '';
				// }else{
				// 	echo '<li><a href="profile.php">Profile</a> </li>';
				// 	echo '<li><a href="history_oder.php">Đơn đặt hàng</a> </li>';
				// }
			?>
			<?php
				// $login_check = Session::get('customer_login');
				// if($login_check){
				// 	echo '<li><a href="compare.php">Compare</a></li>';
				// }
			?>
			<?php
				// $login_check = Session::get('customer_login');
				// if($login_check){
				// 	echo '<li><a href="wishlist.php">Wishlist</a></li>';
				// }
			?>
		<!-- <li><a href="contact.php">Contact</a> </li> -->
	  <div class="clear"></div>
	</ul>
</div>