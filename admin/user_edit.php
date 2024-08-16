<?php include './inc/header.php';?>
<?php include './inc/sidebar.php';?>
<?php include '../classes/user.php' ?>
<?php
    if(isset($_GET['user_id']) && $_GET['user_id']!=NULL){
        $id = $_GET['user_id'];
    }
    else {
        echo "<script>window.location ='user_all.php'</script>";
    }
    $user = new user();
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
        $updateus = $user-> update_user($_POST,$id);
    }
?>
<?php 

?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Sửa user</h2>
           
               <div class="block copyblock"> 
               <?php 
                if(isset($updateus)){
                    echo $updateus;
                }
                ?>
                <?php
                $get_user = $user->getuserbyID($id);
                if($get_user){
                    while($result = $get_user->fetch_assoc()){

                ?>
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['user_name'] ?>" name="user_name" placeholder="Nhập tên danh mục sau khi sửa:..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['user_pass'] ?>" name="user_pass" placeholder="Nhập tên danh mục sau khi sửa:..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['user_email'] ?>" name="user_email" placeholder="Nhập tên danh mục sau khi sửa:..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['user_phone'] ?>" name="user_phone" placeholder="Nhập tên danh mục sau khi sửa:..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['address'] ?>" name="user_phone" placeholder="Nhập địa chỉ:..." class="medium" />
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