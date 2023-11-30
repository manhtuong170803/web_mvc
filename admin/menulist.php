<?php 
    include 'inc/header.php';
    include 'inc/sidebar.php';
    include '../classes/menu.php';
    $menu = new menu();
    if(isset($_GET['delid']) && !empty($_GET['delid'])){
	   $id = $_GET['delid'];
	   $delmenu = $menu->del_menu($id);
    }
?>
    <div class="grid_10">
        <div class="box round first grid">
            <h2>Menu List</h2>
            <div class="block">   
            <?php 
                if(isset($delmenu)){
                    echo $delmenu;
                }
            ?>     
                <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Menu Name</th>
                        <th>Menu Link</th>
                        <th>Menu Prioritize</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $show_menu = $menu->show_menu();
                        if($show_menu){
                            $i = 0;
                            while($result = $show_menu->fetch_assoc()){
                                $i++;
                                //var_dump($result);
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $result['menuName'] ?></td>
                                    <td><?php echo $result['menuLink'] ?></td>
                                    <td><?php echo $result['menuPrioritize'] ?></td>
                                    <td>
                                        <a href="menuedit.php?menuid=<?php echo $result['menuId'] ?>">Edit</a> || 
                                        <a onclick="return confirm('Are you want to delete?')" 
                                            href="?delid=<?php echo $result['menuId'] ?>">Delete</a></td>
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

