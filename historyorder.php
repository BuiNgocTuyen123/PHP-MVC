<?php
include './View/header.php';
include './View/slider.php';

$customer_id = Session::get('customer_id');
$order_codes = $ct->getOrderCodesByUserId($customer_id);
$orders_data = []; // This array will store order information by order_code

if (!empty($order_codes)) {
    foreach ($order_codes as $order_code) {
        $orders = $ct->getPlacedOrdersByOrderCodes([$order_code]);
        if (!empty($orders)) {
            $first_order = reset($orders); // Get the first record from the orders array
            $orders_data[$order_code] = [
                'date_placed' => $first_order['date_placed'],
                'status' => $ct->getStatusText($first_order['status']),
                'orders' => $orders
            ];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'cancel_order') {
        $order_code = $_POST['order_code']; // Lấy mã đơn hàng từ form
        // Thực hiện truy vấn để cập nhật trạng thái đơn hàng
        $result = $ct->shiftedToCancel($order_code); // Giả sử bạn đã có hoặc thêm phương thức này vào class cart để thực hiện cập nhật
        if ($result) {
            echo "<script>alert('Hủy đơn hàng thành công'); window.location.href='historyorder.php';</script>";
            echo "<script>alert('tải lại trang'); window.location.href='historyorder.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra, không thể hủy đơn hàng'); window.location.href='historyorder.php';</script>";
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete_order') {
        $order_code = $_POST['order_code']; // Lấy mã đơn hàng từ form
        // Thực hiện truy vấn để cập nhật giá trị type
        $result = $ct->updateOrderType($order_code, 1); // Giả sử phương thức này được thêm vào class cart để cập nhật giá trị type
        if ($result) {
            echo "<script>alert('Đơn hàng sẽ được xóa ngay sau khi được admin kiểm duyệt'); window.location.href='historyorder.php';</script>";
            echo "<script>alert('tải lại trang'); window.location.href='historyorder.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra, không thể xóa đơn hàng'); window.location.href='historyorder.php';</script>";
        }
    }
    
    
    // Sort the orders by date_placed in descending order
    uasort($orders_data, function ($a, $b) {
        return strtotime($b['date_placed']) - strtotime($a['date_placed']);
    });
}

?>


<style>
    .order-container table {
    width: 100%;
    border-collapse: collapse;
}

.order-container th, .order-container td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
}

.text-right {
    text-align: right;
}

</style>
<div class="main">
    <div class="content">
        <h2 style="text-align:center;">Lịch Sử Đơn Hàng</h2>
        <?php if (!empty($orders_data)): ?>
            <?php foreach ($orders_data as $order_code => $data): ?>
                <div class='order-container'>
                    <table style="margin-top:50px;">
                        <thead>
                            <tr>
                                <th colspan="1">Mã Hóa Đơn: <?php echo htmlspecialchars($order_code); ?></th>
                                <th colspan="4">Ngày thực hiện: <?php echo htmlspecialchars($data['date_placed']); ?></th>
                                <th colspan="1">Trạng thái: <?php echo htmlspecialchars($data['status']); ?>
    <?php if ($data['status'] == 'Chờ xử lý' || $data['status'] == 'Đã xử lý'): ?>
        <form action="historyorder.php" method="post" style="float:right;">
            <input type="hidden" name="action" value="cancel_order">
            <input type="hidden" name="order_code" value="<?php echo $order_code; ?>">
            <button type="submit" style="width:50px; height:50px; border:solid 2px blue; background-color:blue; color:white; padding:5px 10px;" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">
                Hủy
            </button>
        </form>
    <?php elseif ($data['status'] == 'Đã giao hàng' || $data['status'] == 'Đã hủy'): ?>
        <form action="historyorder.php" method="post" style="float:right;">
            <input type="hidden" name="action" value="delete_order">
            <input type="hidden" name="order_code" value="<?php echo $order_code; ?>">
            <button type="submit" style="width:50px; height:50px; border:solid 2px red; background-color:red; color:white; padding:5px 10px;" onclick="return confirm('Đơn hàng của bạn sẽ được xóa ngay sau khi được admin kiểm duyệt?');">
                Xóa
            </button>
        </form>
    <?php endif; ?>
</th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            <?php foreach ($data['orders'] as $order): ?>
                                <?php $total += $order['price'] * $order['quanly']; ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['sanpham_Name']); ?></td>
                                    <td><img src='admin/upload/<?php echo htmlspecialchars($order['image']); ?>' alt='Product Image' class='product-image'></td>
                                    <td>Size: <?php echo htmlspecialchars($order['size']); ?></td>
                                    <td>Số lượng: <?php echo htmlspecialchars($order['quanly']); ?></td>
                                    <td>Giá: <?php echo number_format($order['price'], 0, ',', '.'); ?> VNĐ</td>
                                    <td>Tổng: <?php echo number_format($order['price'] * $order['quanly'], 0, ',', '.'); ?> VNĐ</td>
                                </tr>
                            <?php endforeach; ?>
                            <?php
                                $vat = $total * 0.1;
                                $grandTotal = $total + $vat;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right">Subtotal:</td>
                                <td><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">VAT:</td>
                                <td><?php echo number_format($vat, 0, ',', '.'); ?> VNĐ</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Tổng cộng:</strong></td>
                                <td><strong><?php echo number_format($grandTotal, 0, ',', '.'); ?> VNĐ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>Không có đơn hàng nào.</p>
        <?php endif; ?>
    </div>
</div>

<script>
function cancelOrder(orderCode) {
    if (confirm('Bạn có chắc muốn hủy đơn hàng này?')) {
        // Gửi yêu cầu AJAX đến server
        $.ajax({
            url: 'historyorder.php', // URL của trang xử lý yêu cầu, ở đây chính là trang hiện tại
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'cancel_order', // Hành động cần thực hiện
                order_code: orderCode // Mã đơn hàng cần hủy
            },
            success: function(response) {
                if (response.success) {
                    alert('Hủy đơn hàng thành công');
                    // Cập nhật trạng thái đơn hàng trên trang
                    $('#status-' + orderCode).text('Đã hủy');
                    // Cập nhật nút hủy để không thể click nữa hoặc ẩn đi
                    $('#cancel-btn-' + orderCode).hide();
                } else {
                    alert('Có lỗi xảy ra, không thể hủy đơn hàng');
                }
            }
        });
    }
}


</script>
