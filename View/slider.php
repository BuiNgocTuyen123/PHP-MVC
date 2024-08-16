<?php
include_once './lib/database.php';
include_once './helpers/format.php';
spl_autoload_register(function($className){
	include_once "classes/".$className.".php";
});
$db = new Database();
$sp = new sanpham();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
    * {
        padding: 0;
        margin: 0;
    }

    body {
        width: 1403px;
    }

    #carouselId {
        padding-top: 101px;
        z-index: 10; /* Số này thấp hơn số z-index của sidebar */
    }
    .carousel-item img {
        height: 500px;
        object-fit: cover; /* Thêm dòng này để đảm bảo ảnh không bị méo khi được cố định chiều cao */
        width: 100%; /* Đảm bảo ảnh chiếm toàn bộ chiều rộng của carousel */
    }
</style>

</head>
<body>
<div id="carouselId" class="carousel slide pb-3" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php
        $getSliders = $sp->getActiveSliders();
        if ($getSliders) {
            $i = 0;
            while ($result = $getSliders->fetch_assoc()) {
                echo '<li data-target="#carouselId" data-slide-to="'.$i.'"'.($i == 0 ? ' class="active"' : '').'></li>';
                $i++;
            }
        }
        ?>
    </ol>
    <div class="carousel-inner">
        <?php
        $getSliders = $sp->getActiveSliders();
        if ($getSliders) {
            $i = 0;
            while ($result = $getSliders->fetch_assoc()) {
                echo '<div class="carousel-item'.($i == 0 ? ' active' : '').'">
                <img src="./admin/upload/'.$result['slider_image'].'" class="d-block">
                </div>';
                $i++;
            }
        }
        ?>
    </div>
    <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
