<?php
include 'inc/header.php';
include 'inc/sidebar.php';
require_once '../classes/user.php';
require_once '../classes/cart.php';
require_once '../helpers/format.php';

$us = new user();
$sp = new cart();

// Kiểm tra và lấy thông tin từ URL
if (!isset($_GET['customerid']) || $_GET['customerid'] == NULL || !isset($_GET['order_code']) || $_GET['order_code'] == NULL) {
    echo "<script>window.location ='inbox.php'</script>";
} else {
    $id = $_GET['customerid'];
    $orderCode = $_GET['order_code'];

    // Lấy thông tin khách hàng và sản phẩm
    $get_customer = $us->getuserbyID($id);
    $get_products = $sp->getProductsByOrderCode($orderCode);
}

$total = 0;
$vatRate = 0.1; // Giả sử VAT là 10%
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<div class="grid_10">
    <div class="box round first grid">
        <h2>Thông Tin Khách Hàng</h2>
        <div class="block copyblock">
            <?php if ($get_customer): ?>
                <?php $result = $get_customer->fetch_assoc(); ?>
                <table class="form">
                    <tr>
                        <td>Họ và Tên:</td>
                        <td><?= $result['user_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?= $result['user_email'] ?></td>
                    </tr>
                    <tr>
                        <td>Số Điện Thoại:</td>
                        <td><?= $result['user_phone'] ?></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ:</td>
                        <td><?= $result['address'] ?></td>
                    </tr>
                </table>
            <?php else: ?>
                <p class='error'>Không tìm thấy thông tin người dùng.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="box round grid">
        <h2>Thông tin đơn hàng</h2>
        <div class="block">
            <?php if ($get_products): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Hình Ảnh</th>
                            <th>Size</th>
                            <th>Số Lượng</th>
                            <th>Giá</th>
                            <th>Tổng Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        <?php while ($result = $get_products->fetch_assoc()): ?>
                            <?php $i++; ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $result['sanpham_Name'] ?></td>
                                <td><img src="upload/<?= $result['image'] ?>" alt="<?= $result['sanpham_Name'] ?>" style="width: 50px; height: auto;"></td>
                                <td><?= $result['size'] ?></td>
                                <td><?= $result['quanly'] ?></td>
                                <td><?= number_format($result['price'], 0, ',', '.') ?> VNĐ</td>
                                <td><?= number_format($result['quanly'] * $result['price'], 0, ',', '.') ?> VNĐ</td>
                            </tr>
                            <?php echo '<p>Debug - Quantity: '.$result['quanly'].', Price: '.$result['price'].', Total for this product: '.($result['quanly'] * $result['price']).'</p>'; ?>
                            <?php $total += $result['quanly'] * $result['price']; ?>
                        <?php endwhile; ?>
                        <tr>
                            <th colspan="6" style="text-align:right;">Total:</th>
                            <td><?= number_format($total, 0, ',', '.') ?> VNĐ</td>
                        </tr>
                        <tr>
                            <th colspan="6" style="text-align:right;">VAT (10%):</th>
                            <td><?= number_format($total * $vatRate, 0, ',', '.') ?> VNĐ</td>
                        </tr>
                        <tr>
                            <th colspan="6" style="text-align:right;">Grand Total:</th>
                            <td><?= number_format($total + ($total * $vatRate), 0, ',', '.') ?> VNĐ</td>
                        </tr>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
</div>
<?php
include 'inc/footer.php';
?>
