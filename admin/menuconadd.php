<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/menucha.php';?>
<?php
$menucon = new menucha();
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
	$insertmenucon= $menucon-> chen_menucon($_POST);
}

?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm menu con</h2>
        <div class="block">  
        <?php
				if(isset($insertmenucon)){
                    echo $insertmenucon;
                }  
				?>             
         <form action="menuconadd.php" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Tên</label>
                    </td>
                    <td>
                        <input name="menucon_Name" type="text" placeholder="Enter Product Name..." class="medium" />
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>menu cha</label>
                    </td>
                    <td>
                        <select id="select" name="menucha">
                            <option>menu cha</option>
                            <?php
                            $menucha = new menucha();
                            $menuchalist = $menucha->show_menucha();
                            if($menuchalist){
                                while($result_con = $menuchalist->fetch_assoc()){

                            ?>
                            <option value="<?php echo $result_con['menucha_ID'] ?>"><?php echo $result_con['menucha_Name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
		
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Save" />
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>


