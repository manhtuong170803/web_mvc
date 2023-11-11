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
      $id = Session::get('customer_id');
	  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){
		$UpdateCustomer = $cs->update_customer($_POST,$id);
	  }
?>

 <div class="main">
    <div class="content">
        <div class="section group">
            <div class="content_top">
                <div class="heading">
                    <h3> Update Profile Customers</h3>
    	        </div>
    	        <div class="clear"></div>
    	    </div>
            <form action="" method="POST">
            <table class="tblone">
                <tr>
                    <?php
                        if(isset($UpdateCustomer)){
                            echo '<td colspan="3">'.$UpdateCustomer.'</td>';
                        }
                    ?>
                </tr>
                <?php
                    $id = Session::get('customer_id');
                    $get_customers = $cs->show_customers($id);
                    if($get_customers){
                        while($result = $get_customers->fetch_assoc()){
                ?>
                <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td><input type="text" name="name" value="<?php echo $result['name']; ?>"></input></td>
                </tr>
                <!-- <tr>
                    <td>City</td>
                    <td>:</td>
                    <td><input type="text" name="name" value=""></input></td>
                </tr> -->
                <tr>
                    <td>Phone</td>
                    <td>:</td>
                    <td><input type="text" name="phone" value="<?php echo $result['phone']; ?>"></input></td>
                </tr>
                <!-- <tr>
                    <td>Country</td>
                    <td>:</td>
                    <td></td>
                </tr> -->
                <tr>
                    <td>Zipcode</td>
                    <td>:</td>
                    <td><input type="text" name="zipcode" value="<?php echo $result['zipcode']; ?>"></input></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><input type="text" name="email" value="<?php echo $result['email']; ?>"></input></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>:</td>
                    <td><input type="text" name="address" value="<?php echo $result['address']; ?>"></input></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="submit" name="save" value="Save"></input></td>
                </tr>
                <?php
                        }
                    }
                ?>
            </table>
            </form>
 	    </div>
 	</div>
</div>

<?php
    include 'inc/footer.php';
?>




