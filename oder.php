<?php
     include 'inc/header.php';
	//  include 'inc/slider.php';

	$login_check = Session::get('customer_login');
	if($login_check==false){
		header('Location:login.php');
	}
?>
<style>
  .oder_page{
    font-size: 30px;
    font-weight: bold;
    color: red;
    }
</style>
<div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
                <div class="not_found">
                   <h3 class="oder_page">Oder Page</h3>
                </div>
						
			</div>


    	     </div>  	
       <div class="clear"></div>
    </div>
 </div>
 <?php
    include 'inc/footer.php';
?>