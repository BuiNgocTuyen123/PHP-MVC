<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/user.php' ?>
<?php
$user = new user();
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
	$insertuser = $user-> add_user($_POST);
}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Thêm tài khoản người dùng</h2>
           
               <div class="block copyblock"> 
               <?php 
                if(isset($insertuser)){
                    echo $insertuser;
                }
                ?>
                 <form action="user_add.php" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="user_name" placeholder="Nhập tên user" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="user_pass" placeholder="Nhập pass" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="email" name="user_email" placeholder="Nhập email" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="user_phone" placeholder="Nhập số điện thoại" class="medium" />
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