<?php 
    include 'inc/header.php';
    include 'inc/sidebar.php';
    include '../classes/menu.php';

    
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
        
        if( !empty($_POST['menuName']) && !empty($_POST['menuLink'])){
            $menu = new menu();
            $insertMenu = $menu->insert_menu($_POST);	
        }else{
            $insertMenu = "<span class='error'>Menu must be not empty</span>";
        }
	}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Thêm Menu</h2>
            <div class="block copyblock"> 
                <?php 
                    if(isset($insertMenu)){
                        echo $insertMenu;
                    }
                ?>
                <form action="menuadd.php" method='post'>
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="menuName" placeholder="Thêm menu..." class="medium" required />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="menuLink" placeholder="Thêm link menu..." class="medium" required />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="number" name="menuPrioritize" placeholder="Độ ưu tiên menu..." class="medium" />
                            </td>
                        </tr>
                        <tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>