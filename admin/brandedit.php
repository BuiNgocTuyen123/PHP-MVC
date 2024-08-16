<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/thuonghieu.php' ?>
<?php
    if(isset($_GET['brand_ID']) && $_GET['brand_ID']!=NULL){
        $id = $_GET['brand_ID'];
    }
    else {
        echo "<script>window.lobrandion ='brandlist.php'</script>";
    }
    $brand = new thuonghieu();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $brand_Name= $_POST['brand_Name'];
    
        $updatebrand= $brand-> update_thuonghieu($brand_Name,$id);
    }
?>
<?php 

?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Sửa danh mục</h2>
           
               <div class="block copyblock"> 
               <?php 
                if(isset($updatebrand)){
                    echo $updatebrand;
                }
                ?>
                <?php
                $get_brande_name = $brand->getbrandbyID($id);
                if($get_brande_name){
                    while($result = $get_brande_name->fetch_assoc()){

                ?>
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['brand_Name'] ?>" name="brand_Name" placeholder="Nhập tên danh mục sau khi sửa:..." class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Edit" />
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