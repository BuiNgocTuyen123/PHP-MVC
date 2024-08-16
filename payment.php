<?php 
include './View/header.php';
?>
<?php 
$login_check = Session::get('customer_login');
if($login_check == false) {
    echo '<script type="text/javascript">window.location.href = "login.php";</script>';
}
?>
<style>
    h3 {
        text-align: center;
        color: brown;
        margin-bottom: 20px;
    }

    .payment-options {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .payment-option {
        background-color: #f8f8f8;
        border: 1px solid #eaeaea;
        border-radius: 5px;
        padding: 10px 50px;
        margin: 10px 0;
        text-align: center;
        transition: background-color 0.3s, color 0.3s;
        text-decoration: none;
        font-weight: bold;
        color: #555;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .payment-option:hover {
        background-color: #555;
        color: white;
        text-decoration: none;
    }

    .content {
        padding-bottom: 150px; /* Adjust as needed for footer */
    }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="main">
    <hr style="margin-top:0px;">
    <div class="content">
        <div class="section group" style="margin-top:200px;">
            <h3>Thanh toán giỏ hàng</h3>
        </div>
        <div class="payment-options">
            <h3>Chọn phương thức để thanh toán</h3>
            <a href="offlinepayment.php" class="payment-option">Thanh toán sau khi nhận hàng</a>
            <a href="onlinepayment.php" class="payment-option">Thanh toán trực tuyến</a>
            <a href="cart.php" class="payment-option">Quay lại giỏ hàng</a>
        </div>
    </div>
</div>
<div style="margin-top:600px;">
<?php 
include './View/footer.php';
?>
</div>
