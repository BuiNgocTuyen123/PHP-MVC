<?php
// Lấy đường dẫn thư mục hiện tại
$filepath = realpath(dirname(__FILE__));
include_once ($filepath . '/../lib/database.php');
// include_once ($filepath . '/../helpers/format.php');
// include ($filepath . '/../lib/session.php');

// Tạo kết nối database
$db = new Database();

// Xử lý khi có dữ liệu POST
if (isset($_POST['index'])) {
    // Lấy dữ liệu từ POST
    $index = $_POST['index'];
    $product_id = $_POST['product_id'];
    $customerId = $_POST['customer_id'];

    // Trước khi thêm đánh giá mới, kiểm tra xem người dùng đã đánh giá sản phẩm này chưa
    $checkQuery = "SELECT * FROM tbl_rating WHERE sanpham_ID = '$product_id' AND user_id = '$customerId'";
    $checkResult = $db->select($checkQuery);

    if ($checkResult) {
        // Nếu đã tồn tại đánh giá từ người dùng này cho sản phẩm này
        echo "<script>alert('Bạn đã đánh giá sản phẩm này rồi.');</script>";
    } else {
        // Nếu chưa có đánh giá, thêm đánh giá mới vào database
        $insertQuery = "INSERT INTO tbl_rating(sanpham_ID, user_id, rating) VALUES ('$product_id', '$customerId', '$index')";
        $insertResult = $db->insert($insertQuery);
        if ($insertResult) {
            echo "<script>alert('Đánh giá $index sao thành công');</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi đánh giá.');</script>";
        }
    }
}
?>
