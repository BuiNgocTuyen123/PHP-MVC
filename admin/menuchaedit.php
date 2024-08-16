<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/menucha.php' ?>
<?php
    if(isset($_GET['menucha_ID']) && $_GET['menucha_ID']!=NULL){
        $id = $_GET['menucha_ID'];
    }
    else {
        echo "<script>window.location ='menuchalist.php'</script>";
    }
    $menucha = new menucha();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $menucha_Name= $_POST['menucha_Name'];
    
        $updatemenucha= $menucha-> update_menucha($menucha_Name,$id);
    }
?>
<?php 

?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Sửa menucha</h2>
           
               <div class="block copyblock"> 
               <?php 
                if(isset($updatemenucha)){
                    echo $updatemenucha;
                }
                ?>
                <?php
                $get_menucha_name = $menucha->getcatbyID($id);
                if($get_menucha_name){
                    while($result = $get_menucha_name->fetch_assoc()){

                ?>
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['menucha_Name'] ?>" name="menucha_Name" placeholder="Nhập tên danh mục sau khi sửa:..." class="medium" />
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
<?php include 'inc/footer.php';?>