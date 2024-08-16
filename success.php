<?php
include './View/header.php';
include './View/slider.php';
?>
<style>
    .success_order {
        font-size: 24px;
        color: #333;
        margin-bottom: 10px;
    }

    .success_order p {
        font-size: 16px;
        color: #666;
        margin-bottom: 10px;
        line-height: 1.6;
    }

    .success_order a {
        color: brown;
        text-decoration: none;
        font-weight: bold;
    }

    .success_order a:hover {
        color: #6b4226;
    }
</style>

<div class="main" style="margin-top:100px;">
    <form action="" method="post" class="content">
        <div class="cartoption">
            <h2 class="success_order">Đơn hàng thành công</h2>
            <?php
            $customer_id = Session::get('customer_id');
            $get_order_details = $ct->getAmountPrice($customer_id);
            if ($get_order_details) {
                $amount = 0;
                while ($order_detail = $get_order_details->fetch_assoc()) {
                    $price = $order_detail['price'];
                    $amount += $price;
                }
                $vat = $amount * 0.1;
                $total = $vat + $amount;
            ?>
                <p>Tổng giá trị đơn hàng bạn đã mua trên trang web của tôi: <?php echo number_format($total, 0, ',', ',') ?> VNĐ</p>
                <p>Chúng tôi sẽ liên hệ với bạn sớm nhất có thể. Vui lòng xem chi tiết đơn hàng tại đây <a href="historyorder.php">Click here</a></p>
            <?php
            }
            ?>
        </div>
    </form>
</div>

<?php
include './View/footer.php';
?>
