<?php
include './View/header.php';
include './View/slider.php';
?>
<?php
$login_check = Session::get('customer_login');
if($login_check==false){
    echo '<script type="text/javascript">window.location.href = "login.php";</script>';
}

if(isset($_GET['order_id']) && $_GET['order_id']=='order'){
    $customer_id = Session::get('customer_id');
    $insertOrder = $ct->insertOrder($customer_id);
    $delCart = $ct->del_all_data_cart();
    echo '<script type="text/javascript">
    window.location = "./success.php"
</script>';

}
?>
<style>
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
    .box_left, .box_right {
        box-sizing: border-box;
    }
    .box_left{
        width: 50%;
        border: solid 1px #666;
        float: left;
        padding: 4px;
    }
    .box_right{
        width: 45%;
        border: solid 1px #666;
        float: right;
        padding: 4px;
    }
    .product-info {
        margin-bottom: 20px;
    }
    .product {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 20px;
    }
/* CSS cho nút Order */
.order-button {
    background-color: brown; /* Màu nền */
    color: white; /* Màu chữ */
    padding: 10px 20px; /* Độ lớn của nút */
    border: none; /* Không viền */
    border-radius: 5px; /* Bo tròn góc */
    cursor: pointer; /* Con trỏ */
    transition: background-color 0.3s, color 0.3s; /* Hiệu ứng chuyển đổi màu nền và màu chữ trong 0.3 giây */
    font-size: 16px; /* Kích thước chữ */
    text-decoration: none; /* Không gạch chân */
}

/* Hover effect */
.order-button:hover {
    background-color: #6b4226; /* Màu nền khi hover */
    color: #fff; /* Màu chữ khi hover */
}

/* Margin và căn giữa */
.order-button-container {
    text-align: center; /* Căn giữa */
    margin-top: 20px; /* Khoảng cách với phần trên */
}

</style>

<div class="main" style="margin-top:100px;">
    <form action="" method="post" class="content">
        <div class="cartoption">		
            <div class="cartpage">
                <div class="not_found">
                    <h3 style="margin-left:560px;">Thông tin khách hàng</h3>
                </div>
                <div class="clear" style="margin-top:50px;"></div>
                <?php
                // Lấy thông tin của khách hàng từ cơ sở dữ liệu
                $customer_id = Session::get('customer_id');
                $customer_info = $us->show_one_cus($customer_id);
                
                // Tính toán subtotal và VAT
                $subtotal = 0;
                $get_sanpham_cart = $ct->get_sanpham_cart();
                if ($get_sanpham_cart) {
                    while ($result = $get_sanpham_cart->fetch_assoc()) {
                        $total = $result['price'] * $result['quanly'];
                        $subtotal += $total;
                    }
                }
                $vat = $subtotal * 0.1;
                $grandTotal = $subtotal + $vat;
                ?>
                <div class="box_left">
                    <h2>Thông tin sản phẩm đã đặt</h2>
                    <div class="product-info">
                        <?php
                        $get_sanpham_cart = $ct->get_sanpham_cart();
                        if ($get_sanpham_cart) {
                            while ($result = $get_sanpham_cart->fetch_assoc()) {
                                $total = $result['price'] * $result['quanly'];
                        ?>
                        <div class="product">
                            <b><?php echo $result['sanpham_Name']?></b>
                            <p><img style="width:50px; height:50px;" src="admin/upload/<?php echo $result['image']?>" alt=""/></p>
                            <p><strong>Size:</strong> <?php echo $result['size'] ?></p>
                            <p><strong>Giá:</strong> <?php echo number_format($result['price'], 0, ',', ',')?> VNĐ</p>
                            <p><strong>Số lượng:</strong> <?php echo $result['quanly']; ?></p>
                            <p><strong>Tổng giá:</strong> <?php echo number_format($total, 0, ',', ',')?> VNĐ</p>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- Hiển thị Subtotal và VAT -->
                    <div>
                        <p><strong>Tạm tính:</strong> <?php echo number_format($subtotal, 0, ',', ',')?> VNĐ</p>
                        <p><strong>VAT:</strong> <?php echo number_format($vat, 0, ',', ',')?> VNĐ</p>
                        <p><strong>Tổng cộng:</strong> <?php echo number_format($grandTotal, 0, ',', ',')?> VNĐ</p>
                    </div>
                </div>
                <div class="box_right" >
                    <h2>Thông tin của bạn</h2>
                    <?php
                    if ($customer_info && $customer_info->num_rows > 0) {
                        $customer = $customer_info->fetch_assoc();
                    ?>
                    <p><strong>Tên:</strong> <?php echo $customer['user_name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $customer['user_email']; ?></p>
                    <p><strong>Số điện thoại:</strong> <?php echo $customer['user_phone']; ?></p>
                    <p><strong>địa chỉ:</strong> <?php echo $customer['address']; ?></p>
                    <p style="margin-left:260px;"><a href="editprofile.php">Cập nhật thông tin</a></p>
                    <?php
                    }
                    ?>
                </div>
            
            </div>
        </div>  
        <div style="margin-top:550px;">
                    .
        </div>
        <div class="order-button-container">
    <a href="?order_id=order" class="order-button">Order</a>
</div>

                <div style="margin-top:100px;">
                .
        </div>
    </form>
</div>


