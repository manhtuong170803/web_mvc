<?php
     include 'inc/header.php';
	//  include 'inc/slider.php';
?>
<?php
	   if(isset($_GET['oderid']) && $_GET['oderid']=='oder'){
		$customer_id = Session::get('customer_id');
        //var_dump($customer_id);
        $insertOrder = $ct->insertOder($customer_id);
        $delCart = $ct->dell_all_data_cart();
        // header('Location:success.php');

	  }

?>
<style>
    .box-left{
        width: 50%;
        /* border: 1px solid #666; */
        float: left;
        padding: 4px;
    }
    .box-right{
        width: 48%;
        /* border: 1px solid #666; */
        float: left;
        padding: 4px;
    }
    .center-submit{
        text-align: center;
    }
    .submit-oder{
        padding: 10px 70px;
        border:none;
        background:red;
        font-size:25px;
        color:#fff;
        margin:10px;
        cursor: pointer;
    }
</style>
<form action="" method="POST">
 <div class="main">
    <div class="content">
    	<div class="section group">
            <div class="heading">
                <h3>Offline Payment</h3>
            </div>
            <div class="clear"></div>
            <div class="box-left">
            <div class="cartpage">
                <?php
                    if(isset($update_quantity_cart)){
                        echo $update_quantity_cart;
                    }
                    if(isset($delcart)){
                        echo $delcart;
                    }
                ?>
                <table class="tblone">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Product Name</th>
                        <th width="15%">Price</th>
                        <th width="25%">Quantity</th>
                        <th width="20%">Total Price</th>
                    </tr>
                    <?php
                        $get_product_cart = $ct->get_product_cart_checkout();
                        $subtotal = 0;
                        if($get_product_cart){
                            $qty = 0;
                            $i = 0;
                            
                            while($result = $get_product_cart->fetch_assoc()){
                                $i++;
                                ?>
                                <tr class="tblone_tr">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $result['productName']; ?></td>
                                    <td><?php echo $fm->format_currency($result['price'])." "."VND";?></td>
                                    <td>
                                        <?php echo $result['quantity']; ?> 
                                    </td>
                                    <td><?php 
                                        $total = $result['price'] * $result['quantity'];
                                        echo $fm->format_currency($total).' '.'VNĐ';
                                    ?></td>

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
                    if($check_cart && $subtotal){				
                        ?>
                        <table style="float:right;text-align:left;margin:5px;" width="40%" class="tbbottom">
                            <tr>
                                <th>Sub Total : </th>
                                <td>
                                    <?php
                                        
                                        echo $fm->format_currency($subtotal).' '.'VNĐ';
                                        Session::set('sum',$subtotal);
                                        Session::set('qty',$qty);
                                    
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>VAT : </th>
                                <td>10% (<?php echo $fm->format_currency($vat = $subtotal * 0.1).' '.'VNĐ';?>)</td>
                            </tr>
                            <tr>
                                <th>Grand Total :</th>
                                <td><?php
                                    $vat = $subtotal * 0.1;
                                    $gtotal = $subtotal + $vat;
                                    echo $fm->format_currency($gtotal).' '.'VNĐ';
                                ?> </td>
                            </tr>
                        </table>
                        <?php
                    }else{
                        echo 'You Cart Is Empty ! Plaease Shopping Now';
                    }
                        ?>
				</div>
            </div>
            <div class="box-right">
            <table class="tblone">
                <?php
                  $id = Session::get('customer_id');
                  $get_customers = $cs->show_customers($id);
                  if($get_customers){
                      while($result = $get_customers->fetch_assoc()){
                ?>
                <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td><?php echo $result['name']; ?></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td>:</td>
                    <td><?php echo $result['city']; ?></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>:</td>
                    <td><?php echo $result['phone']; ?></td>
                </tr>
                <tr>
                    <td>Zipcode</td>
                    <td>:</td>
                    <td><?php echo $result['zipcode']; ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><?php echo $result['email']; ?></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>:</td>
                    <td><?php echo $result['address']; ?></td>
                </tr>
                <tr>
                    <td colspan="3"><a href="editprofile.php">Update Profile</a></td>
                </tr>
                <?php
                        }
                    }
                ?>
            </table>
            </div>
		
 		</div>
 	</div>
       <div class="center-submit"><a href="?oderid=oder" class="submit-oder">Oder Now</a></div><br>
</div>
</form>
 <?php
    include 'inc/footer.php';
?>




