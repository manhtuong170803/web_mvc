<?php
     include 'inc/header.php';
	//  include 'inc/slider.php';
?>

<style>
h2.success-oder {
    text-align: center;
    color: red;
}
p.success-note{
    text-align: center;
    padding: 8px;
    font-size: 17px;
}
</style>
<form action="" method="POST">
 <div class="main">
    <div class="content">
    	<div class="section group">
            <h2 class="success-oder">Success Oder</h2>
            <?php
                $customer_id = Session::get('customer_id');
                $get_amount = $ct->getAmountPrice($customer_id);
                if($get_amount){
                    $amonut = 0;
                    while($result = $get_amount->fetch_assoc()){
                        $price = $result['price'];
                        $amonut += $price;
                    }
                }
            ?>
            <p class="success-note">Total Price You Have Bought From My Website : <?php 
                $vat = $amonut * 0.1;
                $total = $vat + $amonut;
                echo $fm->format_currency($total).' VNĐ';
            ?></p>
            <p class="success-note">We Will Contact As Soon As Possiable. Please See Your Oder Details here <a href="oderdetails.php">Click Here</a></p>
 		</div>
 	</div>
</div>
</form>
	 <?php
    include 'inc/footer.php';
?>




