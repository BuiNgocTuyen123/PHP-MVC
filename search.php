<?php
include './View/header.php';
include './View/slider.php';
?>

<style>
    .khung-san-pham {
        transition: transform 0.3s ease;
        /* Thêm hiệu ứng transition */
    }

    .khung-san-pham:hover {
        transform: scale(0.9);
        /* Scale lớn hơn khi hover */
    }

    .khung-san-pham {
        border: solid black 1px;
        border-radius: 26px;
    }

    /* CSS cho nút "Chi tiết" */
    .button {
        display: inline-block;
        overflow: hidden;
        position: relative;
    }

    .aaa {
        margin-left: 60px;
        margin-bottom: -30px;
        position: relative;
        display: inline-block;
        color: black;
        text-decoration: none;
        text-transform: uppercase;
        overflow: hidden;
        transition: .5s;
        letter-spacing: 4px;
    }

    .aaa:hover {
        background: black;
        color: black;
        text-decoration: none;
        border-radius: 30px;
        box-shadow: 0 0 5px black,
            0 0 25px black,
            0 0 50px black,
            0 0 100px black;
    }

    .aaa span {
        position: absolute;
        display: block;
    }

    .aaa span:nth-child(1) {
        top: 0;
        left: -100%;
        width: 100%;
        height: 2px;
        background: linear-gradient(to right, transparent, black);
        animation: btn-anim1 1s linear infinite;
    }

    .aaa span:nth-child(2) {
        top: -100%;
        right: 0;
        height: 100%;
        width: 2px;
        background: linear-gradient(to bottom, transparent, black);
        animation: btn-anim2 1s linear infinite;
    }

    .aaa span:nth-child(3) {
        bottom: 0;
        right: -100%;
        width: 100%;
        height: 2px;
        background: linear-gradient(to left, transparent, black);
        animation: btn-anim3 1s linear infinite;
    }

    .aaa span:nth-child(4) {
        top: 100%;
        left: 0;
        height: 2px;
        width: 100%;
        background: linear-gradient(to top, transparent, black);
        animation: btn-anim4 1s linear infinite;
    }

    @keyframes btn-anim1 {
        from {
            left: -100%;
        }

        to {
            left: 100%;
        }
    }

    @keyframes btn-anim2 {
        from {
            top: -100%;
            3
        }

        to {
            top: 100%;
        }
    }

    @keyframes btn-anim3 {
        from {
            right: -100%;
        }

        to {
            right: 100%;
        }
    }

    @keyframes btn-anim4 {
        from {
            top: 100%;
        }

        to {
            top: -100%;
        }
    }

    body {
        overflow-x: hidden;
    }

    .content_bottom {
        margin-top: 90px;
    }

    .giagoc {
        text-decoration: line-through;
    }

    body {
        background-image: url('./bg.jpg');
    }

    .card-img-top {
        border-radius: 20px;
        width: 100%;
        height: 100%;
    }
</style>
<div class="row" style="margin-top:50px;">
    <div class="col-md-3">
        <?php
        include './View/sidebar.php';
        ?>
    </div>
    <div class="col-md-9">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tu_khoa = $_POST['tu_khoa'];
            $search_product = $sp->search_product($tu_khoa);
        }
        ?>
            <h2>TU KHOA TIM KIEM <?php echo $tu_khoa ?></h2>
        <div class="row">
            <?php
            if($search_product){
                while($product = $search_product->fetch_assoc()){
            ?>
            <div class='col-md-4'>
                <div class="card khung-san-pham" style="margin-left:10px; margin-top:60px; width: 16rem; height:27rem;">
                    <a href="preview.php?proid=<?php echo $product['sanpham_ID'] ?>"><img style="height:80%;"
                            src="admin/upload/<?php echo $product['image'] ?>" class="card-img-top" alt="..."></a>
                    <div style="margin-top:-80px;" class="card-body">
                        <b>
                            <?php echo $product['sanpham_Name'] ?>
                        </b>
                        <?php
                        if ($product['type'] == 2) {
                            ?>
                            <p style="color:red;">Giá gốc: <span class="giagoc">
                                    <?php echo number_format($product['giagoc'], 0, ',', ',') ?>
                                </span> VNĐ</p>
                            <?php
                        }
                        ?>
                        <p><span class="price">Giá sale
                                <?php echo number_format($product['price'], 0, ',', ',') ?>
                            </span> VNĐ</p>
                        <a style="background-color: white;" class="aaa"
                            href="preview.php?proid=<?php echo $product['sanpham_ID'] ?>">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            Chi tiết</a>
                    </div>
                </div>
            </div>
            <?php
                
            }
        }
            ?>
        </div>
    </div>
</div>