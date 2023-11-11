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
<style>
    h3.payment{
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        text-decoration: underline;
    }
    .wrapper_method{
        text-align: center;
        width: 550px;
        margin: 0px auto;
        border: 1px solid #666;
        padding: 20px;
        background: cornsilk;
    }
    .wrapper_method a{
        padding: 10px;
        background: red;
        color: #fff;
    }
    .wrapper_method h3{
        margin-bottom: 20px;
    }
</style>
<div class="main">
    <div class="content">
        <div class="section_group">
            <div class="content_top">
                <div class="heading">
                    <h3>Thanh toán online</h3>
                </div>
                <div class="clear"></div>
                <div class="wrapper_method">
                    <h3 class="payment">Chọn cổng thanh toán online</h3>
                    <form action="donhangthanhtoanonline.php" method="POST">
                        <button class="btn btn-success"name="redirect" id="redirect">Thanh toán VNPAY</button>
                    </form>
                    <p>Đang trong quá trình phát triển xin vui lòng chờ nhé...</p>
                    <a href="payment.php" style="background: grey;"> << Quay về</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include 'inc/footer.php';
?>