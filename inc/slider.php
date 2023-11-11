<div class="header_bottom">
		<div class="header_bottom_left">
			<div class="section group">
				<div class="listview_1_of_2 images_1_of_2">
					<?php
						$getLastestdell = $product->getLastestDell();
						if($getLastestdell){
							while($result = $getLastestdell->fetch_assoc()){
					?>
					<div class="listimg listimg_2_of_1">
						 <a href="preview.php"> <img src="admin/uploads/<?php echo $result['image']; ?>" alt="" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>Dell</h2>
						<p><?php echo $result['productName']; ?></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>">Add to cart</a></span></div>
				   </div>
			   </div>	
			   <?php
						}
					}
				?>		
				<div class="listview_1_of_2 images_1_of_2">
					<?php
						$getLastestSS = $product->getLastestSamsung();
						if($getLastestSS){
							while($result = $getLastestSS->fetch_assoc()){
					?>
					<div class="listimg listimg_2_of_1">
						  <a href="preview.php"><img src="admin/uploads/<?php echo $result['image']; ?>" alt="" /></a>
					</div>
					<div class="text list_2_of_1">
						  <h2>Samsung</h2>
						  <p><?php echo $result['productName']; ?> </p>
						  <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>">Add to cart</a></span></div>
					</div>
				</div>
				<?php
						}
					}
				?>
			</div>
			<div class="section group">
				<?php
					$getLastestOp = $product->getLastestOppo();
					if($getLastestOp){
						while($result = $getLastestOp->fetch_assoc()){
				?>
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						<a href="preview.php"><img src="admin/uploads/<?php echo $result['image']; ?>" alt="" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>Oppo</h2>
						<p><?php echo $result['productName'];?></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>">Add to cart</a></span></div>
				   </div>
			   </div>
			   <?php
						}
					}
				?>			
				<div class="listview_1_of_2 images_1_of_2">
					<?php
						$getLastesthw = $product->getLastestHuawei();
						if($getLastesthw){
							while($result = $getLastesthw->fetch_assoc()){
					?>
					<div class="listimg listimg_2_of_1">
						  <a href="preview.php"><img src="admin/uploads/<?php echo $result['image']; ?>" alt="" /></a>
					</div>
					<div class="text list_2_of_1">
						  <h2></h2>
						  <p><?php echo $result['productName']; ?></p>
						  <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>">Add to cart</a></span></div>
					</div>
				</div>
				<?php
						}
					}
				?>	
			</div>
		  <div class="clear"></div>
		</div>
			 <div class="header_bottom_right_images">
		   <!-- FlexSlider -->
             
			<section class="slider">
				  <div class="flexslider">
					<ul class="slides">
					<?php
							$get_slider = $product->show_slider();
							if($get_slider){
								while($result_slider = $get_slider->fetch_assoc()){
					?>
						<li><img src="admin/uploads/<?php echo $result_slider['slider_image'];?>" alt="<?php echo $result_slider['sliderName'];?>"/></li>
						<?php
								}
							}
						?>
				    </ul>
				  </div>
	      </section>
<!-- FlexSlider -->
	    </div>
	  <div class="clear"></div>
  </div>	