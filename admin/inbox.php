<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/cart.php');
    include_once ($filepath.'/../helpers/format.php');
?>
<?php
	$ct = new cart();
	if(isset($_GET['shiftid']) ){
		$id = $_GET['shiftid'];
		$shifted = $ct->shifted($id);
		if($shifted){
            echo "<script>'window.location:81 = 'inbox.php'</script>";
        }

	}elseif(isset($_GET['delid']) ){
		$id = $_GET['delid'];
		$del_shifted = $ct->del_shitfted($id);
		if($del_shifted){
            echo "<script>'window.location:81 = 'inbox.php'</script>";
        }
	}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Inbox</h2>
                <div class="block">  
					<?php
						if(isset($shifted)){
							echo $shifted;
						}elseif(isset($del_shifted)){
							echo $del_shifted;
						}
					?> 
                    <table class="data display datatable" id="example">
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
							$get_inbox_cart = $ct->get_inbox_cart();
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
							
							<td><a href="customer.php?customerid=<?php echo $result['customer_id']; ?>&oder_code=<?php echo $result['oder_code'];?>">View Oder</a></td>
							<td>
								<?php
								// echo "<pre>";
								// var_dump($result);
								// echo "</pre>";
								if($result['status']==0){
									?>
									<a href="?shiftid=<?php echo $result['oder_code'];?>" >Tình trạng mới</a>
									<?php
								}elseif($result['status']==1){
									?>
									<?php
									echo 'Đang vận chuyển...';
									?>
									<?php
								}elseif($result['status']==2){
									?>
									<a href="?delid=<?php echo $result['oder_code'];?>">Đã nhận | Xoá</a>
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
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
