<?php
include './View/header.php';
include './View/slider.php';
?>
<?php
if(isset($_GET['cart_ID'])){
	$cartId = $_GET['cart_ID'];
	$del_ct = $ct->del_product_cart($cartId);
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $quanly = $_POST['quanly'];
    $cartId = $_POST['cart_ID'];
    $update_quantity_cart = $ct->update_quantity_cart($quanly, $cartId);
}

?>
<style>
	h2{
		text-align: center;
		color: brown;
	}
	thead{
		color: white;
	}
	.x_ne{
		color:blue;
	}
	.x_ne:hover{
		color:red;
	}
</style>
		<h2>Giỏ hàng của bạn</h2>
		<?php if(isset($update_quantity_cart)){
			echo $update_quantity_cart;
		} ?>
			<?php if(isset($del_ct)){
			echo $del_ct;
		} ?>
		<table class="table table-border" >
    <thead class="bg-dark">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Size</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Total price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $subtotal = 0; // Khởi tạo biến $subtotal
        $get_sanpham_cart = $ct->get_sanpham_cart();
        if($get_sanpham_cart){
            while($result = $get_sanpham_cart->fetch_assoc()){
        ?>
        <tr>
            <td><?php echo $result['sanpham_Name']?></td>                                           
            <td><img style="width:50px; height:50px;" src="admin/upload/<?php echo $result['image']?>" alt=""/></td>
            <td><?php echo $result['size'] ?></td>
            <td><?php echo number_format( $result['price'], 0, ',', ',')?> VNĐ</td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="cart_ID" value="<?php echo $result['cart_ID']; ?>"/>
                    <input type="number" name="quanly" value="<?php echo $result['quanly']; ?>" min="1"/>
                    <input type="submit" name="submit" value="Update"/>
                </form>
            </td>
            <td><?php $total = $result['price'] * $result['quanly']; echo number_format( $total, 0, ',', ','); ?> VNĐ</td>
            <td><a class="x_ne" href="?cart_ID=<?php echo $result['cart_ID'] ?>">Xoa</a></td>
            <?php $subtotal += $total; ?>
        </tr>
        <?php
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Sub Total : </th>
            <td><?php echo number_format( $subtotal, 0, ',', ','); ?> VNĐ</td>
        </tr>
        <tr>
            <th>VAT : </th>
            <td>10%</td>
        </tr>
        <tr>
            <th>Grand Total :</th>
            <td><?php $vat = $subtotal * 0.1; $gtotal = $subtotal + $vat; echo number_format( $gtotal, 0, ',', ','); ?> VNĐ</td>
        </tr>
    </tfoot>
</table>

<div class="shopping">
    <div class="shopleft">
        <a href="index.php"> <img src="images/shop.png" alt="" /></a>
    </div>
    <?php
    $get_sanpham_cart = $ct->get_sanpham_cart();
    if ($get_sanpham_cart) {
        $subtotal = 0;
        while ($result = $get_sanpham_cart->fetch_assoc()) {
            $total = $result['price'] * $result['quanly'];
            $subtotal += $total;
        }
        if ($subtotal > 0) {
            echo '<button class="my-button"><a href="payment.php">Thanh toán</a></button>';
        }
    }
    ?>
</div>
						<style>
  .my-button {
    background-color: brown;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-left:650px;
  }
  .my-button:hover {
    background-color: white;
    color: brown;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-left: 650px;
    border: 2px solid brown; /* This should be the only border property in the hover state */
}
.my-button a {
        color: inherit;
        text-decoration: none;
        display: inline-block;
        width: 100%;
        height: 100%;
    }
</style>

					</div>
                    <?php
include './View/footer.php';
?>