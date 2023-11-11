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
	if(isset($_GET['danhanhang'])){
		$danhanhang = $_GET['danhanhang'];
		$danhanhang = $ct->confirm_recieved($danhanhang);
        if($danhanhang){
            echo "<script>'window.location:81 = 'inbox.php'</script>";
        }
	}
?>


 <div class="main">
    <div class="content">
        <div class="section group">
            <div class="content_top">
                <div class="heading">
                <h3 class="payment">Lịch sử đơn đã đặt hàng</h3>
    	        </div>
    	        <div class="clear"></div>
                <div class="wrapper-methor">
                <table class="table table-striped table-bordered table-hover" id="example">
					<thead>
						<tr>
							<th>No.</th>
							<th>Oder Time</th>
							<th>Oder Code</th>
							<th>Customer ID</th>
							<th>Action</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$ct = new cart();
							$fm = new Format();
							$get_inbox_cart = $ct->get_inbox_cart_history(Session::get('customer_id'));
							if($get_inbox_cart){
								$i = 0;
								while($result = $get_inbox_cart->fetch_assoc()){
									$i++;
						?> 
						<tr class="odd gradeX">
							<td><?php echo $i;?></td>
							<td><?php echo $fm->formatDate($result['date_created']); ?></td>
							<td><?php echo $result['oder_code'];?></td>
							<td><?php echo $result['customer_id'];?></td>
							
							<td><a href="history_oder_details.php?customerid=<?php echo $result['customer_id']; ?>&oder_code=<?php echo $result['oder_code'];?>">View Oder</a></td>
							<td>
								<?php
								// echo "<pre>";
								// var_dump($result);
								// echo "</pre>";
								if($result['status']==1){
									?>
									<a href="?danhanhang=<?php echo $result['oder_code'];?>" >Đã nhận hàng</a>
									<?php
								}elseif($result['status']==2){
									?>
									<?php
									echo 'Đơn hàng thành công';
									?>
                                <?php
                                }
                                ?>
							</td>
						</tr>
						<?php
								}
							}
						?>
						
					</tbody>
				</table>
                </div>
    	    </div>
 	    </div>
 	</div>
</div>

<?php
    include 'inc/footer.php';
?>




