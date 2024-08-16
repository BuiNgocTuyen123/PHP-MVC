<?php
include './View/header.php';
?>
<?php
if (isset ($_GET['proid']) && $_GET['proid'] != NULL) {
	$id = $_GET['proid'];
} else {
	echo "<script>window.location ='404.php'</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['submit'])) {
	$quanly = $_POST['quanly'];
	$product_id = $_POST['product_id']; // Lấy id sản phẩm từ form
	$size = $_POST['size']; // Lấy giá trị size từ form
	$cart = new Cart();
	$addtocart = $cart->add_to_cart($quanly, $product_id, $size);

	if ($addtocart) {
		// Nếu thêm vào giỏ hàng thành công, có thể hiển thị thông báo hoặc chuyển hướng đến trang giỏ hàng
		echo "<script>window.location ='cart.php'</script>";
	} else {
		// Nếu có lỗi khi thêm vào giỏ hàng, có thể hiển thị thông báo cho người dùng
		echo "Có lỗi xảy ra khi thêm vào giỏ hàng.";
	}
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlist'])) {
    $product_id = $_POST['sanpham_ID'];
    // Lấy customer_id từ session
    $customer_id = Session::get('customer_id');
    $insertwlist = $sp->insertwlist($product_id, $customer_id);
	$show_cmt = $us->get_comments($product_id);

}
if(isset($_POST['cmt_submit'])){
	$insert_binhluan = $us->insert_cmt();
}

?>
<style>
	.container {
		height: auto;
	}

	.img {
		width: 300px;
		height: 350px;
		border: 2px solid black;
		border-radius: 10px;
	}

	.sl {
		background-color: #555555;
		color: white;
		border: none;
		border-radius: 20px
	}

	.sl:hover {
		background-color: white;
		color: black;
		border: solid 2px black;
		box-shadow: 2px 2px 2px 2px rgb(#B7B7B7);
	}

	.buysubmit {
		border-radius: 20px;
		border: 2px brown solid;
		width: 100px;
		background-color: white;
	}

	.buysubmit:hover {
		background-color: brown;
		color: white;
		border: 2px solid aqua;
	}

	.giagoc {
		text-decoration: line-through;
	}

	.size-quantity {
		display: flex;
		/* Sử dụng flexbox để các phần tử con hiển thị trên cùng một dòng */
		align-items: center;
		/* Căn giữa các phần tử theo chiều dọc */
		margin-top: 15px;
	}

	.size-quantity form {
		display: inline-block;
		/* Đặt form để nó không chiếm toàn bộ chiều rộng */
		margin-left: 10px;
		/* Khoảng cách giữa nút và phần tử bên cạnh */
	}

	.imgmini {
		width: 100px;
		height: 100px;
		border: 2px black solid;
		margin-top: 10px;
		border-radius: 10px;
	}

	.imgmini:hover {
		border: 3px green solid;

	}

	.tag {
		color: black;
	}

	.tag:hover {
		color: brown;
		font-weight: bold;
		/* Làm đậm khi hover */
	}

	.tagg {
		color: brown;
		font-weight: bold;
		/* Làm đậm khi hover */
	}

	.size_span {
		color: brown;
	}

	.quantity {
		margin-left: 0px;
	}

	h5 {
		border: 2px solid black;
		padding: 10px;
		/* Add some padding inside the border */
		margin: 10px 0;
		/* Add some margin for spacing */
		word-wrap: break-word;
		overflow-wrap: break-word;
	}

	.size-quantity input[type='number'] {
		margin-right: 100px;
		width: 60px;
		color: brown;
		border: none;
		/* Set viền thành không có */
		background: transparent;
		/* Set nền trong suốt */
		text-align: center;
		/* Căn giữa text */
	}
	.wishlist-btn {
  background: none;
  border: none;
  cursor: pointer;
}

.wishlist-btn i {
  color: #ff0000; /* Màu trái tim */
  font-size: 24px; /* Kích thước trái tim */
}

.wishlist-btn:hover i {
  animation: heartBeat 1s ease-in-out infinite;
}

@keyframes heartBeat {
  0% {
    transform: scale(1);
  }
  14% {
    transform: scale(1.3);
  }
  28% {
    transform: scale(1);
  }
  42% {
    transform: scale(1.3);
  }
  70% {
    transform: scale(1);
  }
}


</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="main">
	<hr style="margin-top:0px;">
	<div class="content" style="z-index:4000; margin-top:150px;">
		<div class="section group">
		<?php
if(Session::get('customer_id')){
$customer_id = Session::get('customer_id');
$totalStars = 0;
$totalRatings = 0;

// Lấy tổng số sao đã đánh giá
$get_star = $sp->get_star($id, $customer_id);
if ($get_star) {
    while ($result_start = $get_star->fetch_assoc()) {
        $totalStars += $result_start['rating'];
        $totalRatings++; // Đếm số lần đánh giá
    }
}

// Tính trung bình cộng
$averageRating = 0;
if ($totalRatings > 0) {
    $averageRating = $totalStars / $totalRatings;
}
}
?>

		<?php
			$get_chitietsanpham = $sp->get_chitiet($id,);
			if ($get_chitietsanpham) {
				while ($result_chitiet = $get_chitietsanpham->fetch_assoc()) {
					?>
					<div class="container">
						<div class="row">
							<div class="col-md-4" style="margin-left:-40px;">
								<div class="images">
									<img class="img" src="admin/upload/<?php echo $result_chitiet['image'] ?>" alt="" />
								</div>
								<div>
									<img class="imgmini" src="admin/upload/<?php echo $result_chitiet['image'] ?>" alt="" />
									<img class="imgmini" style="margin-left:10px;"
										src="admin/upload/<?php echo $result_chitiet['image2'] ?>" alt="" />
								</div>
							</div>
							<div class="col-md-8">
								<h2>
									<?php echo $result_chitiet['sanpham_Name']; ?>
									<?php 		if(Session::get('customer_id')){
 ?>
									<ul id="ratingList" data-temp-rating="0"> <!-- Thêm thuộc tính data-temp-rating để lưu đánh giá tạm thời -->
<?php

    for ($count = 1; $count <= 5; $count++) {
        // Kiểm tra nếu $count nhỏ hơn hoặc bằng $count_rating
        if ($count <= round(number_format($averageRating, 1), 1)) {
            // Gán màu cho $color
            $color = 'color:#ffcc00;';
        } else {
            // Gán màu mặc định cho $color
            $color = 'color:#ccc;';
        }
        ?>
		<?php
		if(Session::get('customer_id')){
		?>
      <li class="rating" style="cursor:pointer; font-size:30px; display: inline-block; <?php echo $color; ?>"
    id="<?php echo $result_chitiet['sanpham_ID'].'-'.$count; ?>"
    data-product_id="<?php echo $result_chitiet['sanpham_ID']; ?>"
    data-index="<?php echo $count; ?>" data-customer_id="<?php echo Session::get('customer_id') ?>"
    data-rating="0">&#9733;</li>

	<?php
	}
	else{
		?>
	<li class="rating_login" style="cursor:pointer;font-size:40px;color:#ccc; display:inline-block;">&#9733;</li>

		<?php
	}
	?>
        <?php
    }
    ?>
	<li style="font-size:12px;">Đã đánh giá: <?php echo round(number_format($averageRating, 1), 1) ?>/5</li>
</ul>
<?php
									}
?>
									<form action="" method="post">
										<input type="hidden" name="sanpham_ID"
											value="<?php echo $result_chitiet['sanpham_ID'] ?>">
										<?php
										$customer_id = Session::get('customer_id');
										$login_check = Session::get('customer_login');
										if ($login_check) {
											?>
<button type="submit" name="wishlist" class="wishlist-btn"><i class="fa fa-heart"></i></button>
										<?php } ?>
										<?php if (isset ($insertwlist)) {
											echo $insertwlist;
										} ?>
									</form>
								</h2>



								<?php
								if ($result_chitiet['type'] == 2) {
									?>
									<p style="color:red;">Giá gốc: <span class="giagoc">
											<?php echo number_format( $result_chitiet['giagoc'], 0, ',', ',') ?>
										</span> VNĐ</p>
									<?php
								}
								?>

								<div class="price">
									<p>Giá: <span>
											<?php echo number_format( $result_chitiet['price'], 0, ',', ',') ?>
										</span> VNĐ</p>

									<p class="tagg">tag: <a
											href="productbymenucon.php?menucon_ID=<?php echo $result_chitiet['menucon_ID']; ?>"
											class="tag">
											<?php echo $result_chitiet['menucon_Name'] ?>
										</a></p>
									<p class="tagg">Thương hiệu: <a
											href="productbybrand.php?brand_ID=<?php echo $result_chitiet['brand_ID']; ?>"
											class="tag">
											<?php echo $result_chitiet['brand_Name'] ?>
										</a></p>
								</div>
								<?php
								$sizesQuantities = $sp->getSizesAndQuantities($id);
								if ($sizesQuantities) {
									?>
									<div class='sizes'>
										<?php
										foreach ($sizesQuantities as $size => $quantity) {
											?>
											<div class="size-quantity" style="margin-top:15px;">
												<b class="size">Size:</b> <span class="size_span">
													<?php echo $size ?>
												</span>
												<?php if($quantity !=0) {?>
												<b class="quantity" style="margin-left:200px;">CH còn: </b>
												<input style="margin-right:200px; margin-left:10px;" type="number"
													name="quantity[<?php echo $size; ?>]" value="<?php echo $quantity ?>"
													style="width: 60px; color: brown; border:none;" readonly />

												<form action="" method="post">
													<input type="hidden" name="product_id" value="<?php echo $id; ?>" />
													<input type="hidden" name="quanly" value="1" />
													<input type="hidden" name="size" value="<?php echo $size; ?>" />
													<input type="submit" class="buysubmit" name="submit" value="Buy Now" />
												</form>

												<?php }else{ ?>

														<b style="margin-left:200px;">Hết hàng</b>
														<?php } ?>

												<?php
												if (isset ($addtocart)) {
													echo '<span style ="color:red;font-size:18px;">Sản phẩm này đã có trong giỏ hàng của bạn</span>';
												}
												?>
											</div>
											<hr style="border: none;height: 2px;background-color: brown; width: 100%;">
											<?php
										}
										?>
									</div>
									<?php
								}
								?>
							<?php

?>


							</div>
						</div>

						<div class="row" style="margin-top:30px;">
							<div class="col-md-6" style="margin-left:-100px;">
								<h2 style="color:brown;text-align:center; ">Thiết kế: </h2>
								<img class="thietke" src="admin/upload/<?php echo $result_chitiet['image3'] ?>" alt="" />
							</div>
							<style>
								.thietke {
									width: 600px;
									height: 600px;
								}
							</style>
							<div class="col-md-6" style="margin-left:100px;">
								<h2 style="color:brown;text-align:center; ">Mô tả sản phẩm: </h2>
								<h5 style="border:3px solid brown; border-radius:20px;">
									<?php echo $result_chitiet['ttsanpham'] ?>
								</h5>
							</div>

							<?php
										$customer_id = Session::get('customer_id');
										$login_check = Session::get('customer_login');
										if ($login_check) {
											?>
							
							<div class="col-md-6" style="margin-left:400px; margin-top:50px; border:solid 2px black;" height="500px">
							<?php
									if(isset($insert_binhluan)){
										echo $insert_binhluan;
									}
								?>
								<h2 style="color:brown; text-align: center;">Bình luận </h2>
								<?php
								$get_cmt = $us->get_comments($id);
									if($get_cmt){
										while($result = $get_cmt->fetch_assoc()){
								?>
								<div style="border:solid 2px black; margin-top:10px;">
									<b>Tên người bình luận: <?php echo $result['cmt_user'] ?></b>
									<br>
									<b>nội dung bình luận: <?php echo $result['cmt'] ?></b>
								</div>
							<?php 
							} 
									}
							?>
							<button id="loadMore" data-id="<?php echo $id; ?>" data-start="5">Xem thêm</button>

								<form action="" method="POST" style="margin-top:40px;">
									<input type="hidden" value="<?php echo $result_chitiet['sanpham_ID'] ?>" name="pro_id_cmt">
								<input placeholder="điền têm" type="text" class="form-control" name="user_cmt" style="width:50%;">
								<textarea placeholder="bình luận" name="cmt" id="" cols="70" rows="2" style="border:3px solid brown; border-radius:20px; margin-top:20px;">
								</textarea>
								<br>
								<input type="submit" name="cmt_submit" class="btn btn-danger" value="Gửi bình luận">
								</form>
							</div>
							<?php
										}
							?>

						</div>

					</div>
					<?php
				}
			}
			?>

		</div>
	</div>
</div>
<div style="margin-top:100px;">
	<h1>hi</h1>
</div>
<script type="text/javascript">
	window.onload = function () {
		// Lấy hình ảnh lớn
		var mainImage = document.querySelector('.img');

		// Lấy tất cả hình ảnh mini
		var miniImages = document.querySelectorAll('.imgmini');

		// Thêm sự kiện 'click' cho mỗi hình ảnh mini
		miniImages.forEach(function (miniImage) {
			miniImage.addEventListener('click', function () {
				// Cập nhật hình ảnh lớn bằng hình ảnh được click
				mainImage.src = this.src;
			});
		});
	};
</script>
<script>
				  function remove_background(product_id) {
        for(var count = 1; count <= 5; count++) {
            $('#' + product_id + '-' + count).css('color', '#ccc');
        }
    }
	function set_temporary_rating(product_id, rating) {
        remove_background(product_id);
        for(var count = 1; count <= rating; count++) {
            $('#' + product_id + '-' + count).css('color', '#ffcc00');
        }
        // Update the temporary rating attribute
        $('#ratingList').attr('data-temp-rating', rating);
    }
	
					//hover chuột đánh giá sao
				    $(document).on('mouseenter', '.rating', function(){
        var index = $(this).data("index");
        var product_id = $(this).data('product_id');
        
        set_temporary_rating(product_id, index);
    });
					  //nhả chuột ko đánh giá
					  $(document).on('mouseleave', '.rating', function(){
        var product_id = $(this).data('product_id');
        var tempRating = $('#ratingList').attr('data-temp-rating'); // Use the temporary rating
        
        set_temporary_rating(product_id, tempRating);
    });
	$('.rating').click(function(){
        var index = $(this).data("index");
        var product_id = $(this).data('product_id');

        $('#ratingList').attr('data-temp-rating', index); // Update the temporary rating on click
    });

				</script>
				<script>
					 $('.rating').click(function(){
						var index = $(this).data("index"); //3
						var product_id = $(this).data('product_id');
						var customer_id = $(this).data('customer_id');
						$.ajax(
								{ url: 'ajax/rating.php',
									data: {index:index, product_id:product_id, customer_id:customer_id},
									type: 'POST',
									success: function(data) {
										
											alert('Đánh giá '+index+' sao thành công');
										
											

											}
							});
					})
					$('.rating_login').click(function(){
						alert('Làm ơn đăng nhập để đánh giá sao.');
					})
				</script>