<?php
     include 'inc/header.php';
	//  include 'inc/slider.php';
?>
<?php
	$id = "";
   if(!isset($_GET['idpost']) || $_GET['idpost']==Null){
     echo "<script>'window.location:81 = '404.php'</script>";
   }else{
        $id = $_GET['idpost'];
   }
//    if($_SERVER['REQUEST_METHOD'] === 'POST'){
//         $catName = $_POST['catName'];
//         $updateCat = $cat->update_category($catName, $id);	
//     }
?>

 <div class="main">
    <div class="content">
    	<div class="content_top">
		<?php 
			
			$name_cat = $pos->getpostbyCateId($id);
			
			if($name_cat){
				while($result_name = $name_cat->fetch_assoc()){
		?>
    		<div class="heading">
    		<h3>Category : <?php echo $result_name['title'];?></h3>
    		</div>
			<?php
					}
				}
			?>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
				<?php
				
					$postbycat = $pos->get_post_by_cat($id);
					if($postbycat){
						while($result = $postbycat->fetch_assoc()){
				?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details_blog.php?blogid=<?php echo $result['id']; ?>"><img src="admin/uploads/<?php echo $result['image']; ?>" width="200px" alt="" /></a>
					 <h2><?php echo $result['title']; ?></h2>
					 <p><?php echo $fm->textShorten($result['description'],150); ?></p>
				     <div class="button"><span><a href="details_blog.php?blogid=<?php echo $result['id']; ?>" class="details">Details</a></span></div>
				</div>
				<?php
						}
					}else{
						echo 'Hiện tại chưa có tin tức thuộc mục này.';
					}
				?>

			</div>

	
	
    </div>
 </div>

 <?php
    include 'inc/footer.php';
?>