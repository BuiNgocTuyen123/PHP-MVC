<?php
include './View/header.php';
include './View/slider.php';
?>
<?php
if(isset($_GET['id'])){
    $customer_id = Session::get('customer_id');
    $id = $_GET['id'];
    $del_wlist = $sp->del_wlist($id, $customer_id);
}

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    h2 {
        text-align: center;
        color: brown;
    }

    thead {
        color: white;
    }

    .x_ne {
        color: blue;
    }

    .x_ne:hover {
        color: red;
    }
</style>
<h2>Sản phẩm yêu thích của bạn</h2>
<?php if (isset ($del_ct)) {
    echo $del_ct;
} ?>
<table class="table table-border" style="margin-top:100px;">
    <thead class="bg-dark">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Giá</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $customer_id = Session::get('customer_id');
        $get_wlist = $sp->get_wlist($customer_id);
        if ($get_wlist) {
            while ($result = $get_wlist->fetch_assoc()) {
                ?>
                <tr>
                    <td>
                        <?php echo $result['sanpham_Name'] ?>
                    </td>
                    <td><img style="width:50px; height:50px;" src="admin/upload/<?php echo $result['image'] ?>" alt="" /></td>
                    <td>
                        <?php echo number_format($result['price'], 0, ',', ',') ?>VNĐ
                    </td>
                    <td><a class="x_ne" href="?id=<?php echo $result['id'] ?>">Xoá</a> || <a class="" href="preview.php?proid=<?php echo $result['sanpham_ID'] ?>">Đặt hàng</a></td>

                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>

</div>
<?php
include './View/footer.php';
?>