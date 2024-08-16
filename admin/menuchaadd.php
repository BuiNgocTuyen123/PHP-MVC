<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/menucha.php' ?>
<?php
$menucha = new menucha();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$menucha_Name= $_POST['menucha_Name'];

	$insertmenucha= $menucha-> chen_menucha($menucha_Name);
}

?>
<?php 

?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Thêm Menu cha</h2>
           
               <div class="block copyblock"> 
               <?php 
                if(isset($insertmenucha)){
                    echo $insertmenucha;
                }
                ?>
                 <form action="menuchaadd.php" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="menucha_Name" placeholder="Nhập tên menucha:..." class="medium" />
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