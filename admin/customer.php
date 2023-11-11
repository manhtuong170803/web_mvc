<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/customer.php');
    include_once ($filepath.'/../helpers/format.php');
?>
<?php
   if(!isset($_GET['customerid']) || $_GET['customerid']==Null){
     echo "<script>'window.location:81 = 'inbox.php'</script>";
   }else{
        $id = $_GET['customerid'];
        $oder_code = $_GET['oder_code'];
   }
   $cs = new customer();
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Chi tiết đơn hàng</h2>
               <div class="block copyblock"> 
                <?php 
                    $get_customer = $cs->show_customers($id);
                    if($get_customer){
                        while($result = $get_customer->fetch_assoc()){
                ?>
                 <form action="#" method='post'>
                    <h3>Thông tin người đặt hàng</h3>
                    <table class="form">					
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['name']; ?>" name="Name" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['phone']; ?>" name="Phone" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>:</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['city']; ?>" name="City" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>:</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['country']; ?>" name="Country" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['address']; ?>" name="Address" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Zip Code</td>
                            <td>:</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['zipcode']; ?>" name="Zip Code" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['email']; ?>" name="Email" class="medium" />
                            </td>
                        </tr>
                    </table>
                    </form>
                    <?php
                     }
                        }
                    ?>
                </div>
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
                        $get_oder = $cs->show_oder($oder_code);
                        if($get_oder){
                            $subtotal = 0;
                            $total = 0;
                            while($result_oder = $get_oder->fetch_assoc()){
                                $subtotal = $result_oder['quantity']* $result_oder['price'];
                                $total+=$subtotal;
                    ?>
                        <tr>
                            <td><?php echo $result_oder['productName']; ?></td>
                            <td><img src="uploads/<?php echo $result_oder['image'];?>" width="80"></td>
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
<?php include 'inc/footer.php';?>