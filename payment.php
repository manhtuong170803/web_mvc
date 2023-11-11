<?php
     include 'inc/header.php';
	//  include 'inc/slider.php';
?>
<?php
	$login_check = Session::get('customer_login');
    if($login_check==false){
        header('Location:login.php');
    }
?>
<?php
	//    if(!isset($_GET['proid']) || $_GET['proid']==Null){
	// 	echo "<script>'window.location:81 = '404.php'</script>";
	//   }else{
	// 	   $id = $_GET['proid'];
	//   }
	//   if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
	// 	$quantity = $_POST['quantity'];
	// 	$AddtoCart = $ct->add_to_cart($quantity, $id);
	//   }
?>
<style>
    .wrapper-methor{
        text-align: center;
        width: 550px;
        margin: 0 auto;
        border: 1px solid #666;
        padding: 20px;
        background: cornsilk;
    }
    .payment{
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        text-decoration: underline;
    }
    .wrapper-methor a{
        padding: 5px;
        background: red;
        color: #fff;
    }
    .wrapper-methor h3{
        margin-bottom: 20px;
    }

</style>

 <div class="main">
    <div class="content">
        <div class="section group">
            <div class="content_top">
                <div class="heading">
                    <h3>Payment Method</h3>
    	        </div>
    	        <div class="clear"></div>
                <div class="wrapper-methor">
                    <h3 class="payment">Choose Your Method Payment</h3>
                    <a href="offlinepayment.php">Offlinepayment</a>
                    <a href="onlinepayment.php">Onlinepayment</a><br><br>
                    <a style="background:grey" href="cart.php"> << Previous</a>
                </div>
    	    </div>
 	    </div>
 	</div>
</div>

<?php
    include 'inc/footer.php';
?>




