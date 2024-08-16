<?php 
include './View/header.php';
?>
<?php 
$login_check = Session::get('customer_login');
if($login_check==false){
    echo '<script type="text/javascript">window.location.href = "login.php";</script>';
}
?>
<style>
    h3{
        text-align:center;
        color:brown;
    }
    .button-group {
    text-align: center; /* Căn giữa các nút */
    margin-top: 20px; /* Khoảng cách từ nội dung trên */
    margin-bottom: 20px; /* Khoảng cách từ nội dung dưới */
}

.btn {
    padding: 10px 20px; /* Kích thước padding cho nút */
    margin: 0 10px; /* Khoảng cách giữa các nút */
}

/* Bạn có thể thêm các style khác tùy ý */

</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="main">
	<hr style="margin-top:0px;">
	<div class="content" style="z-index:4000; margin-top:150px;">
		<div class="section group">
    <h3>Thông tin tài khoản</h3>
    <table class="table table-border" >
    <thead class="bg-dark">
        <tr style="color:white;">
            <th>Tên</th>
            <th>email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>edit</th>
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
            <td><?php echo $result['user_name'] ?></td>
            <td><?php echo $result['user_email'] ?></td>
            <td><?php echo $result['user_phone'] ?></td>
            <td><?php echo $result['address'] ?></td>
            <td><a href="editprofile.php">Update Profile</a></td>
        </tr>
        <?php
                  }
                }
        ?>
    </tbody>
    </table>
		</div>
	</div>
    <div class="button-group">
    <a href="index.php" class="btn btn-warning">Quay lại mua sắm</a>
    <a href="historyorder.php" class="btn btn-info">Lịch sử mua hàng</a>
    <a href="wishlist.php" class="btn btn-danger">Sản Phẩm yêu thích</a>
</div>
</div>
<div style="margin-top:600px;">
<?php 
include './View/footer.php';
?>
</div>