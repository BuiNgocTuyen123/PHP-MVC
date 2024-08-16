<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/thuonghieu.php' ?>
<?php
$brand = new thuonghieu();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$brand_Name= $_POST['brand_Name'];

	$insertbrand= $brand-> chen_thuonghieu($brand_Name);
}

?>
<?php 

?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Thêm Thương hiệu</h2>
           
               <div class="block copyblock"> 
               <!-- <?php 
                if(isset($insertbrand)){
                    echo $insertbrand;
                }
                ?> -->
                 <form action="brandadd.php" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="brand_Name" placeholder="Nhập thương hiệu sản phẩm:..." class="medium" />
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
