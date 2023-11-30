</div>
   <div class="footer">
   	  <div class="wrapper">	
	     <div class="section group">
				<div class="col_1_of_4 span_1_of_4">
						<h4>Information</h4>
						<ul>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Customer Service</a></li>
						<li><a href="#"><span>Advanced Search</span></a></li>
						<li><a href="#">Orders and Returns</a></li>
						<li><a href="#"><span>Contact Us</span></a></li>
						</ul>
					</div>
				<div class="col_1_of_4 span_1_of_4">
					<h4>Why buy from us</h4>
						<ul>
						<li><a href="about.php">About Us</a></li>
						<li><a href="faq.php">Customer Service</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="contact.php"><span>Site Map</span></a></li>
						<li><a href="preview.php"><span>Search Terms</span></a></li>
						</ul>
				</div>
				<div class="col_1_of_4 span_1_of_4">
					<h4>My account</h4>
						<ul>
							<li><a href="contact.php">Sign In</a></li>
							<li><a href="index.php">View Cart</a></li>
							<li><a href="#">My Wishlist</a></li>
							<li><a href="#">Track My Order</a></li>
							<li><a href="faq.php">Help</a></li>
						</ul>
				</div>
				<div class="col_1_of_4 span_1_of_4">
					<h4>Contact</h4>
						<ul>
							<li><span>+88-01713458599</span></li>
							<li><span>+88-01813458552</span></li>
						</ul>
						<div class="social-icons">
							<h4>Follow Us</h4>
					   		  <ul>
							      <li class="facebook"><a href="#" target="_blank"> </a></li>
							      <li class="twitter"><a href="#" target="_blank"> </a></li>
							      <li class="googleplus"><a href="#" target="_blank"> </a></li>
							      <li class="contact"><a href="#" target="_blank"> </a></li>
							      <div class="clear"></div>
						     </ul>
   	 					</div>
				</div>
			</div>
			<div class="copy_right">
				<p>Training with live project &amp; All rights Reseverd </p>
		   </div>
     </div>
    </div>
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script>
		// ------------------CHECK CART TRONG GIỎ HÀNG----------------------------------//
		$('.buy_checked').change(function(){
			// var checkout_a = $('a.checkout-a');
			// checkout_a.addClass('active');
			// console.log(checkout_a);
			//alert('check mua hàng thành công');
			
			
			var id_cart = $(this).val();
			//alsert(id_cart);
			if($(this).is(':checked')){
				var cart_status = 1;
				$.ajax({
					url: 'ajax/stick_buy.php',
					data: {id_cart:id_cart,cart_status:cart_status},
					type: 'post',
					success:function(){
						var checkout_a = $('a.checkout-a');
						checkout_a.addClass('active');
						alert('check mua hàng thành công');
					}
				});
			}else{
				var cart_status = 0;
				$.ajax({
					url: 'ajax/stick_buy.php',
					data: {id_cart:id_cart,cart_status:cart_status},
					type: 'post',
					success:function(){
						var buy_checked = $('.buy_checked:checked');
						//console.log(buy_checked.length);
						if(!buy_checked.length){
							var checkout_a = $('a.checkout-a');
							checkout_a.removeClass('active');
							alert('check bỏ mua hàng thành công');
							// console.log(" ko còn phần tử check");
							//ẩn checkout => xoá class active
						}
						/*
							if không so sánh mà trả về kết quả:
								khác rõng: "ábhdgsad"
								khi bằng trở lên:

						*/
						
						

					}
				});
			}
		})
		// ------------------------------------------------------------------------------//


		// ------------------------BUY NOW------------------------------------------------//
		$('.buysubmit[name="submit"]').click(function(event){
			// console.log('.buysubmit[name="submit"]');
   			event.preventDefault();

			//var stock_remaining = $('.price p:last-child span');

			var no_product = $('span.no_product');

			var product_stock = $('.buyfield[name="product_stock"]').val();
			var quantity = $('.buyfield[name="quantity"]').val();
			var productid = $('input[name="productid"]' );
			var productid_value = productid.val();
			/*
				so sánh số lượng tồn kho
				so sánh các giá trị xem rõng không
				giá trị nhập âm thì hiển thông báo
			*/
			if(product_stock != "" || quantity != "" ||  productid_value != ""){
				// console.log(product_value,quantity);
				if(quantity > 0){
					// console.log(quantity);
					if(product_stock >= quantity){
						$.ajax({
							url: 'ajax/buy_now.php',
							data: {product_stock:product_stock,quantity:quantity,productid_value:productid_value},
							type: 'post',
							success:function(data){
								//console.log(data);
								var jsonbuynow = $.parseJSON(data);
								if(jsonbuynow.result == 'success'){
									//console.log(jsonbuynow);
									no_product.text(jsonbuynow.subtotal+' '+'đ'+'-'+'Qty:'+jsonbuynow.subquantity);
									//stock_remaining.text(jsonbuynow.stock+'/Cái');
									alert('thêm sản phẩm thành công');
								}else{
									alert ('Số lượng tồn kho không đủ');
								}
								


								// function isJSON(data) {
								// 	try {
								// 		var jsonbuynow = JSON.parse(data);
								// 		// alert( 'true');
								// 		console.log( true);
								// 		 no_product.text(jsonbuynow.subtotal+' '+'đ'+'-'+'Qty:'+jsonbuynow.subquantity);
								// 	} catch (e) {
								// 		console.log( false);
								// 	}
								// }

								// if (isJSON(data)) {
								// 	alert('Số lượng tồn kho không đủ.');
								// } else {
								// 	alert('thêm sản phẩm thành công');
								// }

							}
						});
					}else{
						alert('số lượng tồn kho k đủ');
					// hiển thị thông báo số lượng tồn kho k đủ
					}
				}else{
					alert('sản phẩm ko dc âm');
				// hiển thông báo sản phẩm ko dc âm
				}
			}else{
				alert('Dữ liệu rỗng');
			}
		});
		// ------------------------------------------------------------------------------//


		// -------------------------------COMPARE-----------------------------------------------//
		$('.buysubmit[name="compare"]').click(function(event){
			// console.log('.buysubmit[name="compare"]');
   			event.preventDefault();

			var compareid = $('input[name="productid"]');
			var compareid_value = compareid.val();
			if(compareid_value != ""){
				$.ajax({
							url: 'ajax/compare.php',
							data: {compareid_value:compareid_value},
							type: 'post',
							success:function(data){
								console.log(data);
								alert(data);
							}
						});
			}else{
				alert('sản phẩm không có')
			}
		});
		// ------------------------------------------------------------------------------//


		// -------------------------------WISHLIST-----------------------------------------------//

		$('.buysubmit[name="wishlist"]').click(function(event){
			event.preventDefault();
			
			var wishlistid = $('input[name="productid"]');
			var wishlistid_value = wishlistid.val();
			if(wishlistid_value != ""){
				$.ajax({
					url: 'ajax/wishlist.php',
					data: {wishlistid_value:wishlistid_value},
					type: 'post',
					success:function(data){
						console.log(data);
						alert(data);
					}
				});
			}else{
				alert('sản phẩm không có')
			}
		});
		// ---------------------------------------------------------------------------------------------------//
	

		// -------------------------NÚT TRỪ TRONG GIỎ HÀNG-----------------------------------------------------//

		$('.layout-icon .layout-icon-plus').click(function(){
			//tìm đối tượng 

			var no_product = $('span.no_product');

			var parent_tr = $(this).closest('tr');
			var parent_td = parent_tr.find('td:nth-child(6)');

			var parent_icon_plus = $(this).closest('form');
			var id_cart = parent_icon_plus.find('input[name="cartId"]').val();
			var quantity_cart = parent_icon_plus.find('input.quantity[name="quantity"]');
			var quantity_value= quantity_cart.val();
			if(quantity_value <= 1){
				alert('số lượng không được nhỏ hơn 1');
			}else{
				$.ajax({
					url: 'ajax/plus_product.php',
					data: {id_cart:"id_cart"},
					type: 'post',
					success:function(data){
						//console.log(data);
						if(data != ''){
							var jsonObject = $.parseJSON(data);
							quantity_cart.val(jsonObject.quantity);
							parent_td.text(jsonObject.total);
							no_product.text(jsonObject.subtotal+' '+'đ'+'-'+'Qty:'+jsonObject.subquantity);
							
						}
						
					}
				});
			}
			/*
			khi click thì:
			1, lấy số lượng(quantity) so sánh với 1
			nếu số lượng bằng 1 => giữ nguyên 1, hiển thị thông báo "sản phẩm không được nhỏ hơn 1"
			nếu số lượng nhỏ hơn 1 => thì hiển thị thông báo "sản phẩm không được nhỏ hơn 1"
			nếu số lượng lớn hơn 1 => trừ sản phẩm hiển thị thông báo "update thành công"
			*/
			
		})
		// ---------------------------------------------------------------------------------------------------//



		// -------------------------NÚT CỘNG TRONG GIỎ HÀNG-----------------------------------------------------//

		$('.layout-icon .layout-icon-minus').click(function(){
			var no_product = $('span.no_product');

			var parent_tr = $(this).closest('tr');
			var parent_td = parent_tr.find('td:nth-child(6)');

			var layout_icon_minus = $(this).closest('form');
			var id_cart = layout_icon_minus.find('input[name="cartId"]').val();
			//console.log(id_cart	);
			var stock = layout_icon_minus.find('input[name="stock"]');
			var stock_value = stock.val();
			var quantity_cart = layout_icon_minus.find('input.quantity[name="quantity"]');
			var quantity_value= quantity_cart.val();

			// console.log(parseInt(quantity_value) >= parseInt(stock_value));
			
			if(parseInt(quantity_value) >= parseInt(stock_value)){
				alert('số lượng sản phẩm trong kho chỉ còn ' + stock_value );
			}else{
				$.ajax({
					url: 'ajax/minus_product.php',
					data: {id_cart:id_cart},
					type: 'post',
					success:function(data){
						// console.log(data);
						if(data != ''){
							var jsonObject = $.parseJSON(data);
							quantity_cart.val(jsonObject.quantity);
							parent_td.text(jsonObject.total);
							no_product.text(jsonObject.subtotal+' '+'đ'+'-'+'Qty:'+jsonObject.subquantity);
							// quantity_cart.val(data);
							
						}
					}
				});
			}
		});
		// ---------------------------------------------------------------------------------------------------//

		// -----------------------------THANH TOÁN OFFLINE------------------------------------------------------------//

		$('a.submit-oder').click(function(event){
   			event.preventDefault();
			var submit_oder = $(this);
			var parent_tr = $('tr.tblone_tr');
			var parent_tb = $('table.tbbottom');
			//console.log(parent_td)
			$.ajax({
					url: 'ajax/submit_oder.php',
					data: {},
					type: 'post',
					success:function(data){
						//console.log(data);
						parent_tr.empty();
						parent_tb.remove();
						parent_tr.html("You Cart Is Empty ! Plaease Shopping Now");
						submit_oder.css("display",'none');
						//alert('Thanh toán thành công');
					}
				});
		});
		// ---------------------------------------------------------------------------------------------------//

		// -----------------------------------XOÁ TRONG GIỎ HÀNG-------------------------------------------------//

		$('a.delete').click(function(){
			event.preventDefault();
			var ebtnDefault = $(this);
			var no_product = $('span.no_product');
			var sub_total = $('td.subtotal_td');
			var grand_total= $('td.grandtotal_td');
			var delete_cart = $('a.delete');
			var id_cart = $('input[name="cartId"]').val();
			var parent_tr = ebtnDefault.closest('tr');
			//console.log(sub_total);
			$.ajax({
					url: 'ajax/delete_cart.php',
					data: {id_cart:id_cart},
					type: 'post',
					success:function(data){
						console.log(data);
						var jsonbuynow = $.parseJSON(data);
						if(jsonbuynow.result == 'success'){
							no_product.text(jsonbuynow.subtotal+' '+'đ'+'-'+'Qty:'+jsonbuynow.subquantity);
							sub_total.text(jsonbuynow.subtotal_2+' '+'VNĐ');
							grand_total.text(jsonbuynow.gtotal+' '+'VNĐ');
							//console.log(sub_total,grand_total);
							parent_tr.remove();
							alert('bạn có muốn xoá không');
						}else{
							alert('thất bại');
						}

					}
				});
		});
		// ---------------------------------------------------------------------------------------------------//


		// ------------------------------ADD TO CART-----------------------------------------------------------------//

		$('input.btn.btn-default').click(function(event){
			// console.log('.buysubmit[name="submit"]');
   			event.preventDefault();
			var no_product = $('span.no_product');
			var ebtnDefault = $(this);
			var product_stock = ebtnDefault.closest('form.section-from');
			var add_to_cart_stock = product_stock.find('.add_to_cart[name="stock"]');
			var value_product_stock = "";
			if(add_to_cart_stock){
				value_product_stock = add_to_cart_stock.val();
			}
			var quantity = $('.add_to_cart[name="quantity"]').val();
			var add_to_cart_product = product_stock.find('.add_to_cart[name="productId"]');
			var value_productId = "";
			if(add_to_cart_product){
				value_productId = add_to_cart_product.val();
			}
			if(value_product_stock != "" || quantity != "" ||  value_productId != ""){
				//console.log(value_product_stock, quantity, value_productId);
				if(quantity > 0){
					// console.log(quantity);
					if(value_product_stock >= quantity){
						$.ajax({
							url: 'ajax/add_to_cart.php',
							data: {
								product_stock:value_product_stock,
								quantity:quantity,
								productid_value:value_productId
							},
							type: 'post',
							success:function(data){
								//console.log(data);
								var jsonbuynow = $.parseJSON(data);
								if(jsonbuynow.result == 'success'){
									//console.log(jsonbuynow);
									no_product.text(jsonbuynow.subtotal+' '+'đ'+'-'+'Qty:'+jsonbuynow.subquantity);
									//stock_remaining.text(jsonbuynow.stock+'/Cái');
									alert('thêm sản phẩm thành công');
								}else{
									alert ('Số lượng tồn kho không đủ');
								}
							}
						});
					}else{
						alert('số lượng tồn kho k đủ');
					// hiển thị thông báo số lượng tồn kho k đủ
				}
				}else{
					alert('sản phẩm ko dc âm');
				// hiển thông báo sản phẩm ko dc âm
				}
			}else{
				alert('Dữ liệu rỗng');
			}
			
		});
		// ---------------------------------------------------------------------------------------------------//

		// ---------------------------------------PHÂN TRANG--------------------------------------------------------//


		var page_feature = 1;
		$('.see_more_feature').click(function(){
			var eThis = $(this);
			var parentPrev = eThis.parent().prev(); //next
			page_feature++;
			$.ajax({
				url: 'ajax/page_feature.php',
				data: {page_feature:page_feature},
				type: 'GET',
				success:function(data){
					var dataJson = $.parseJSON(data);
					if(dataJson.result == 'success' && parentPrev.length){
						$.each( dataJson.data, function( key, value ) {// trong mảng lun lun có 2 thành phần key và value -> (key là số thứ tự) (value là giá trị)
							parentPrev.append(`<div class="grid_1_of_4 images_1_of_4">
								<a href="details.php?proid=` + value.productId +`">
									<img src="admin/uploads/` + value.image +`" alt="` + value.image +`">
								</a>
								<h2>` + value.productName +`</h2>
								<p></p>
								<span class="price">` + value.price +` VND</span>
								<form action="" method="POST" class="section-from">
									<input type="hidden" class="add_to_cart" name="quantity" value="1">
									<input type="hidden" class="add_to_cart" name="stock" value="`+ value.product_quantity +`">
									<input type="hidden" class="add_to_cart" name="productId" value="` + value.productId +`">
									<div class="button">
										<a href="details.php?proid=` + value.productId +`" class="details">Details</a>
									</div>
									<input type="submit" name="themgiohang" value="Add to cart" class="btn btn-default">
								</form>
							</div>`);
						});
						if(dataJson.max_data){
							eThis.hide(); //show
						}
					}else{
						alert ('Lỗi khi loading product');
					}
				}
			});
		});

				// -------------------------------------------------------------------------------------------------------

		var page = 1;
		$('.see_more').click(function(){
			var eThis = $(this);
			var parentPrev = eThis.parent().prev(); //next
			page++;
			$.ajax({
				url: 'ajax/page.php',
				data: {page:page},
				type: 'GET',
				success:function(data){
					var dataJson = $.parseJSON(data);
					if(dataJson.result == 'success' && parentPrev.length){
						$.each( dataJson.data, function( key, value ) {// trong mảng lun lun có 2 thành phần key và value -> (key là số thứ tự) (value là giá trị)
							parentPrev.append(`<div class="grid_1_of_4 images_1_of_4">
								<a href="details.php?proid=` + value.productId +`">
									<img src="admin/uploads/` + value.image +`" alt="` + value.image +`">
								</a>
								<h2>` + value.productName +`</h2>
								<p></p>
								<span class="price">` + value.price +` VND</span>
								<form action="" method="POST" class="section-from">
									<input type="hidden" class="add_to_cart" name="quantity" value="1">
									<input type="hidden" class="add_to_cart" name="stock" value="`+ value.product_quantity +`">
									<input type="hidden" class="add_to_cart" name="productId" value="` + value.productId +`">
									<div class="button">
										<a href="details.php?proid=` + value.productId +`" class="details">Details</a>
									</div>
									<input type="submit" name="themgiohang" value="Add to cart" class="btn btn-default">
								</form>
							</div>`);
						});
						if(dataJson.max_data){
							eThis.hide();
						}
					}else{
						alert ('Lỗi khi loading product');
					}
				}
			});
		});
		// ---------------------------------------------------------------------------------------------------------------------------------------//

		// ---------------------------------------LÀM HÌNH GIỎ HÀNG BẤM CHUYỂN VÀO TRANG GIỎ HÀNG-------------------------------------------------//

		$('.shopping_cart').click(function(){
			//window.location.replace("http://localhost:81/web_mvc/cart.php");
			window.location.href = "http://localhost:81/web_mvc/cart.php";

		});

		// ---------------------------------------------------------------------------------------------------------------------------------------//





	  </script>


    <script type="text/javascript">
		$(document).ready(function() {
			/*
			var defaults = {
	  			containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
	 		};
			*/
			
			$().UItoTop({ easingType: 'easeOutQuart' });
			
		});
	</script>
    <a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>
    <link href="css/flexslider.css" rel='stylesheet' type='text/css' />
	  <script defer src="js/jquery.flexslider.js"></script>
	  <script type="text/javascript">
		// $(function(){
		//   SyntaxHighlighter.all();
		// });
		$(window).load(function(){
		  $('.flexslider').flexslider({
			animation: "slide",
			start: function(slider){
			  $('body').removeClass('loading');
			}
		  });
		});
	  </script>
	  <script>
		function remove_background(product_id){
			for(var count = 1; count <= 5; count++){
				$('#'+product_id+'-'+count).css('color','#ccc');
			}
		}
		//hover chuột đánh giá sao
		$(document).on('mouseenter','.rating',function(){
			var index = $(this).data('index');
			var product_id = $(this).data('product_id');
			remove_background(product_id);
			for(var count = 1; count<=index; count++){
				$('#'+product_id+'-'+count).css('color','#ffcc00');
			}
		});
		//nhả chuột không dánh giá
		$(document).on('mouseleave','.rating',function(){
			var index = $(this).data('index');
			var product_id = $(this).data('product_id');
			var rating = $(this).data('rating'); 
			remove_background(product_id);
			for(var count = 1; count<=rating; count++){
				$('#'+product_id+'-'+count).css('color','#ffcc00');
			}
		});
	  </script>
</body>
</html>