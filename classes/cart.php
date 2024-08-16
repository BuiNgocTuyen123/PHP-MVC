<?php
$fliepath = realpath(dirname(__FILE__));
include_once ($fliepath.'/../lib/database.php');
include_once ($fliepath.'/../helpers/format.php');
?>

<?php
class cart
{
    private $db;
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function add_to_cart($quanly, $id, $size) {
        $quanly = $this->fm->validation($quanly);
        $quanly = mysqli_real_escape_string($this->db->link, $quanly);
        $id = mysqli_real_escape_string($this->db->link, $id);
        $size = $this->fm->validation($size);
    $size = mysqli_real_escape_string($this->db->link, $size);
        $sld = session_id();
    
        // Kiểm tra xem sản phẩm với size này đã được thêm vào giỏ hàng chưa
        $check_cart_query = "SELECT * FROM cart WHERE sanpham_ID = '$id' AND size = '$size' AND sld = '$sld'";
        $check_cart_result = $this->db->select($check_cart_query);
        if($check_cart_result && $check_cart_result->num_rows > 0) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, thông báo cho người dùng
            $msg = "Sản phẩm với size này đã được thêm vào giỏ hàng.";
            return $msg;
        } else {
            // Nếu sản phẩm chưa tồn tại, tiếp tục thêm vào giỏ hàng
            $query = "SELECT * FROM sanpham WHERE sanpham_ID = '$id'";
            $result = $this->db->select($query)->fetch_assoc();
            if($result) {
                $image = $result["image"];
                $price = $result["price"];
                $sanpham_Name = $result["sanpham_Name"];
    
                $query_insert = "INSERT INTO cart(sanpham_ID, quanly, size, sld, image, price, sanpham_Name) VALUES ('$id', '$quanly', '$size', '$sld', '$image', '$price', '$sanpham_Name')";
                $insert_cart = $this->db->insert($query_insert);
                if($insert_cart) {
                    header('Location: cart.php');
                } else {
                    header('Location: 404.php');
                }
            }
        }
    }
    
    
    public function get_sanpham_cart(){
        $sld = session_id();
        $query = "SELECT * FROM cart WHERE sld = '$sld'";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_quantity_cart($quanly, $cartid){
        $quanly = mysqli_real_escape_string($this->db->link, $quanly);
        $cartid = mysqli_real_escape_string($this->db->link, $cartid);
    
        // Lấy thông tin sản phẩm trong giỏ hàng
        $cart_query = "SELECT * FROM cart WHERE cart_ID ='$cartid'";
        $cart = $this->db->select($cart_query)->fetch_assoc();
    
        // Lấy số lượng sản phẩm có trong kho từ bảng product_size
        $size_query = "SELECT * FROM product_size WHERE sanpham_ID = '".$cart['sanpham_ID']."' AND size = '".$cart['size']."'";
        $size = $this->db->select($size_query)->fetch_assoc();
    
        if ($quanly > $size['quantity']) {
            // Số lượng người dùng muốn mua vượt quá số lượng có trong kho
            $msg = "<b class='error' style='color:red;'>Số lượng bạn cần vượt quá số lượng hàng còn trong kho</b>";
            return $msg;
        } else {
            // Cập nhật số lượng trong giỏ hàng nếu không vượt quá số lượng có trong kho
            $query = "UPDATE cart SET quanly = '$quanly' WHERE cart_ID ='$cartid'";
            $result = $this->db->update($query);
            if($result){
                $msg = "<b class='success' style='color:green;'>Product Quantity Updated Successfully</b>";
                return $msg;
            } else {
                $msg = "<b class='error' style='color:red;'>Product Quantity Updated not Successfully</b>";
                return $msg;
            }
        }
    }
    
    public function del_product_cart($cartId){
        $cartId = mysqli_real_escape_string($this->db->link, $cartId);
        $query = "DELETE FROM cart WHERE cart_ID = $cartId";
        $result = $this->db->delete($query);
        if($result){
            $msg = "<b class='success' style='color:green;'>Xóa sản phẩm thành công</b>";
            return $msg;
        }
        else{
            $msg = "<b class='error' style='color:green;'>delete Product Quantity not Successfully</b>";
            return $msg;
        }
    }
    public function del_all_data_cart(){
        $sld = session_id();
        $query = "DELETE FROM cart WHERE sld = '$sld'";
        $result = $this->db->select($query);
        return $result;
    }
    public function insertOrder($customer_id){
        $sld = session_id();
        $query = "SELECT * FROM cart WHERE sld = '$sld'";
        $get_product = $this->db->select($query);
        $order_code = rand(0000,9999);
        $query_placed = "INSERT INTO tbl_placed(user_id,order_code) values('$customer_id','$order_code')";
        $insert_placed = $this->db->insert($query_placed);
        if($get_product){
            while($result = $get_product->fetch_assoc()){
                $product_id = $result['sanpham_ID'];
                $product_name = $result['sanpham_Name'];
                $quanly = $result['quanly'];
                $price = $result['price']; // Nhân giá với số lượng
                $image = $result['image'];
                $size = $result['size']; // Lấy size từ cart
    
                // Đảm bảo rằng cột size đã được thêm vào bảng tbl_order trong cơ sở dữ liệu
                $query_order = "INSERT INTO tbl_order(order_code,sanpham_ID, sanpham_Name, quanly, price, image, size, user_id) VALUES ('$order_code','$product_id', '$product_name', '$quanly', '$price', '$image', '$size', '$customer_id')";
                $insert_order = $this->db->insert($query_order);
            }
            // Xóa sản phẩm khỏi giỏ hàng sau khi chèn vào tbl_order
            $query_delete = "DELETE FROM cart WHERE sld = '$sld'";
            $this->db->delete($query_delete);
        }
    }
    public function getAmountPrice($customer_id){
        $sld = session_id();
        $query = "SELECT * FROM tbl_order WHERE user_id = '$customer_id'";
        $get_price = $this->db->select($query);
        return $get_price;
    }
    public function get_inbox_cart() {
        $query = "SELECT p.*, u.user_name ,u.user_email
                  FROM tbl_placed AS p
                  JOIN user AS u ON p.user_id = u.user_id
                  WHERE p.status NOT IN ('5', '7') 
                  ORDER BY p.date_placed DESC";
        $get_inbox_cart = $this->db->select($query);
        return $get_inbox_cart;
    }
    
    public function getProductsByOrderCode($orderCode) {
        $query = "SELECT * FROM tbl_order WHERE order_code = '$orderCode'";
        $result = $this->db->select($query);
        return $result;
    }
    
    
    
    public function getStatusText($status) {
        switch ($status) {
            case 0:
                return "Chờ xử lý";
            case 1:
                return "Đã xử lý";
            case 2:
                return "Đã giao hàng";
            case 3:
                return "Đã hủy";
            default:
                return "Không xác định";
        }
    }
    
    public function shiftedToCancel($order_code) {
        $order_code = mysqli_real_escape_string($this->db->link, $order_code);
        $query = "UPDATE tbl_placed SET status = 3 WHERE order_code = '$order_code'";
        $result = $this->db->update($query);
        return $result; // Trả về kết quả của truy vấn cập nhật
    }
    
    public function shifted($id, $time) {
        // Sử dụng mysqli_real_escape_string để ngăn chặn SQL Injection
        $id = mysqli_real_escape_string($this->db->link, $id);
        $time = mysqli_real_escape_string($this->db->link, $time);
    
        // Câu lệnh SQL với CASE để xử lý các trường hợp khác nhau của status
        $query = "UPDATE tbl_placed
                  SET status = CASE 
                      WHEN status = '0' THEN '1'
                      WHEN status = '1' THEN '2'
                      WHEN status = '2' THEN '6'
                      WHEN status = '3' THEN '4'
                      WHEN status = '4' THEN '5'
                      WHEN status = '6' THEN '7'
                      ELSE status 
                  END
                  WHERE placed_id = '$id' AND date_placed = '$time'";
    
        $result = $this->db->update($query); // Thực thi truy vấn
    
        // Kiểm tra kết quả và trả về thông báo phù hợp
        if ($result) {
            $msg = "<span style='color:green'>Update status successfully.</span>";
        } else {
            $msg = "<span style='color:red'>Update status not successfully. Or no change needed.</span>";
        }
        return $msg;
    }
    public function getOrderCodesByUserId($customer_id) {
        $query = "SELECT DISTINCT order_code FROM tbl_order WHERE user_id = ?";
        $stmt = $this->db->link->prepare($query);
        if (false === $stmt) {
            // Xử lý lỗi
            echo "Prepare failed: (" . $this->db->link->errno . ") " . $this->db->link->error;
            return [];
        }
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $orderCodes = [];
        while ($row = $result->fetch_assoc()) {
            $orderCodes[] = $row['order_code'];
        }
        $stmt->close();
        return $orderCodes;
    }
    
    
    
    public function getPlacedOrdersByOrderCodes($orderCodes) {
        if (empty($orderCodes)) {
            return [];
        }
        $in  = str_repeat('?,', count($orderCodes) - 1) . '?';
        // Thêm điều kiện p.type = 0 vào câu truy vấn để chỉ lấy các đơn hàng có type bằng 0
        $query = "SELECT o.*, p.status, p.date_placed, p.type FROM tbl_order AS o 
                  LEFT JOIN tbl_placed AS p ON o.order_code = p.order_code 
                  WHERE o.order_code IN ($in) AND p.type = 0"; // Chỉ hiển thị các đơn hàng với type = 0
        $stmt = $this->db->link->prepare($query);
        if (!$stmt) {
            // Xử lý lỗi
            echo "Prepare failed: (" . $this->db->link->errno . ") " . $this->db->link->error;
            return [];
        }
        $stmt->bind_param(str_repeat("s", count($orderCodes)), ...$orderCodes);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();
        return $orders;
    }
    
    public function updateOrderType($order_code, $type) {
        $order_code = mysqli_real_escape_string($this->db->link, $order_code);
        $type = (int) $type;
        $query = "UPDATE tbl_placed SET type = '$type' WHERE order_code = '$order_code'";
        $result = $this->db->update($query);
        return $result; // Trả về kết quả của truy vấn cập nhật
    }
    
    
}
?> 