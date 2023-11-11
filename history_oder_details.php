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
	// if(isset($_GET['danhanhang'])){
	// 	$danhanhang = $_GET['danhanhang'];
	// 	$danhanhang = $ct->confirm_recieved($danhanhang);
	// }
?>

 <div class="main">
    <div class="content">
        <div class="section group">
            <div class="content_top">
                <div class="heading">
                <h3 class="payment">Chi tiết lịch sử đơn đã đặt hàng </h3>
    	        </div>
    	        <div class="clear"></div>
                <div class="wrapper-methor">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh sản phẩm</th>
                            <th>Gia sản phẩm</th>
                            <th>Số lượng sản phẩm</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $oder_code = $_GET['oder_code'];
                        $get_oder = $cs->show_oder($oder_code);
                        $total = 0;
                        if($get_oder){
                            $subtotal = 0;
                            while($result_oder = $get_oder->fetch_assoc()){
                                $subtotal = $result_oder['quantity']* $result_oder['price'];
                                $total+=$subtotal;
                            ?>
                                <tr>
                                    <td><?php echo $result_oder['productName']; ?></td>
                                    <td><img src="admin/uploads/<?php echo $result_oder['image'];?>" width="80"></td>
                                    <td><?php echo number_format($result_oder['price'],0,',','.'); ?>đ</td>
                                    <td><?php echo $result_oder['quantity']; ?></td>
                                    <td><?php echo number_format($subtotal,0,',','.'); ?>đ</td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="5">Thành tiền: <?php echo number_format($total,0,',','.'); ?>đ</td>
                        </tr>
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




