<?php 
include './View/header.php';
?>
<?php 
$login_check = Session::get('customer_login');
if($login_check == false){
    echo '<script type="text/javascript">window.location.href = "login.php";</script>';
}
?>
<?php
$updateMessage = ""; // Initialize an empty message string
$id = Session::get('customer_id');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){
    $updateMessage = $us->update_user($_POST, $id); // Capture the update message
}
?>
<style>
    h3{
        text-align:center;
        color:brown;
    }
    .message {
        text-align: center;
        margin-bottom: 15px;
    }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="main">
    <hr style="margin-top:0px;">
    <div class="content" style="z-index:4000; margin-top:150px;">
        <div class="section group">
            <h3>Chỉnh sửa tài khoản</h3>
            <?php if (!empty($updateMessage)): ?>
                <div class="message">
                    <?php echo $updateMessage; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <table class="table table-border" >
                    <thead class="bg-dark">
                        <tr style="color:white;">
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Mật khẩu</th>
                            <th>Địac chỉ</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
    <tbody>
        <?php
        $id = Session::get('customer_id');
        $get_customers = $us->show_one_cus($id);
        if($get_customers){
            while($result = $get_customers->fetch_assoc()) {
  
        ?>
        <tr>
            <td><input type="text" name="user_name" value="<?php echo $result['user_name'] ?>"></td>
            <td><input type="email" name="user_email" value="<?php echo $result['user_email'] ?>"></td>
            <td><input type="text" name="user_phone" value="<?php echo $result['user_phone'] ?>"></td>
            <td><input type="text" name="user_pass" value="<?php echo $result['user_phone'] ?>"></td>
            <td><input type="text" name="address" value="<?php echo $result['address'] ?>"></td>
            <td><input type="submit" name="save" value="save" class="grey"></td>
        </tr>
        <?php
                  }
                }
        ?>
    </tbody>
    </table>
    </form>
		</div>
	</div>
</div>
