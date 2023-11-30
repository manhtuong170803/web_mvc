<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/menu.php';
    if(!isset($_GET['menuid']) || empty($_GET['menuid'])){
        echo "<script>'window.location = 'menulist.php'</script>";
    }else{
        $id = $_GET['menuid'];
    }
    $menu = new menu();
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
        if( !empty($_POST['menuName'])){
            $updatemenu = $menu->update_menu($_POST, $id);
        }else{
            $updatemenu = "<span class='error'>Menu must be not empty</span>";
        }
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa Menu</h2>
        <div class="block copyblock"> 
        <?php 
            if(isset($updatemenu)){
                echo $updatemenu;
            }

            $get_menu_name = $menu->getmenubyId($id);
            if($get_menu_name){
                while($result = $get_menu_name->fetch_assoc()){
                    //var_dump($result);
                    ?>
                    <form method='post'>
                        <table class="form">					
                            <tr>
                                <td>
                                    <input type="text" value="<?php echo $result['menuName'] ?>" name="menuName" placeholder="Thêm menu..." class="medium" required />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" value="<?php echo $result['menuLink'] ?>" name="menuLink" placeholder="Thêm link menu..." class="medium" required />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="number" value="<?php echo $result['menuPrioritize'] ?>" name="menuPrioritize" placeholder="Độ ưu tiên menu..." class="medium" />
                                </td>
                            </tr>
                            
                            <tr> 
                                <td>
                                    <input type="submit" name="submit" Value="Update" />
                                </td>
                            </tr>
                        </table>
                    </form>
                <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.php';?>