<?php
$fliepath = realpath(dirname(__FILE__));
include_once ($fliepath.'/../lib/database.php');
include_once ($fliepath.'/../helpers/format.php');
?>
<?php
class sanpham {
    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function chen_sanpham($data, $file) {
        $sanpham_Name = mysqli_real_escape_string($this->db->link, $data['sanpham_Name']);
        $menucon = mysqli_real_escape_string($this->db->link, $data['menucon']);
        $thuonghieu = mysqli_real_escape_string($this->db->link, $data['thuonghieu']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $giagoc = isset($data['giagoc']) ? mysqli_real_escape_string($this->db->link, $data['giagoc']) : null;
        $ttsanpham = mysqli_real_escape_string($this->db->link, $data['ttsanpham']);
        $size_type = isset($data['size_type']) ? mysqli_real_escape_string($this->db->link, $data['size_type']) : '';
        
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];
    
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(microtime()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "upload/" . $unique_image;
    
        $file_name2 = $_FILES['image2']['name'];
        $file_size2 = $_FILES['image2']['size'];
        $file_temp2 = $_FILES['image2']['tmp_name'];
    
        $div2 = explode('.', $file_name2);
        $file_ext2 = strtolower(end($div2));
        $unique_image2 = substr(md5(microtime()), 0, 10) . '2.' . $file_ext2;
        $uploaded_image2 = "upload/" . $unique_image2;

        $file_name3 = $_FILES['image3']['name'];
        $file_size3 = $_FILES['image3']['size'];
        $file_temp3 = $_FILES['image3']['tmp_name'];
    
        $div3 = explode('.', $file_name3);
        $file_ext3 = strtolower(end($div3));
        $unique_image3 = substr(md5(microtime()), 0, 10) . '3.' . $file_ext3;
        $uploaded_image3 = "upload/" . $unique_image3;
    
        if ($sanpham_Name == "" || $menucon == "" || $thuonghieu == "" || $ttsanpham == "" || $type == "" || $price == "" || ($file_name == "" && $file_name2 == "" && $file_name3 == "") || $size_type == "") {
            return "<b style='color:red' class='success'>Các trường không được để trống</b>";
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
            if ($file_name2 != "") {
                move_uploaded_file($file_temp2, $uploaded_image2);
            }
            if ($file_name3 != "") {
                move_uploaded_file($file_temp3, $uploaded_image3);
            }
            $query = "INSERT INTO sanpham(sanpham_Name, menucon_ID, brand_ID, giagoc, ttsanpham, type, price, image, image2, image3, size_type) VALUES ('$sanpham_Name', '$menucon', '$thuonghieu', '$giagoc', '$ttsanpham', '$type', '$price', '$unique_image', '$unique_image2','$unique_image3','$size_type')";            
            $result = $this->db->insert($query);
            $lastId = $this->db->link->insert_id;
    
            if($result) {
                if ($size_type == 'áo') {
                    $this->insertSizeQuantity($lastId, 'S', $data['quantity_S']);
                    $this->insertSizeQuantity($lastId, 'M', $data['quantity_M']);
                    $this->insertSizeQuantity($lastId, 'L', $data['quantity_L']);
                    $this->insertSizeQuantity($lastId, 'XL', $data['quantity_XL']);
                } else if ($size_type == 'quần') {
                    $this->insertSizeQuantity($lastId, '28', $data['quantity_28']);
                    $this->insertSizeQuantity($lastId, '29', $data['quantity_29']);
                    $this->insertSizeQuantity($lastId, '30', $data['quantity_30']);
                    $this->insertSizeQuantity($lastId, '31', $data['quantity_31']);
                    $this->insertSizeQuantity($lastId, '32', $data['quantity_32']);
                }
                return "<b style='color:green' class='success'>Thêm sản phẩm thành công</b>";
            } else {
                return "<b style='color:red' class='error'>Thêm sản phẩm không thành công</b>";
            }
        }
    }
    
    private function insertSizeQuantity($productId, $size, $quantity) {
        if (!empty($quantity) && $quantity > 0) {
            $query = "INSERT INTO product_size(sanpham_ID, size, quantity) VALUES ('$productId', '$size', '$quantity')";
            $result = $this->db->insert($query);
            if (!$result) {
                // Handle error - Log this to a file or database
                error_log("Failed to insert size quantity: Product ID - $productId, Size - $size, Quantity - $quantity");
            }
        }
    }
    

    public function update_sanpham($data, $files, $id) {
        $sanpham_Name = mysqli_real_escape_string($this->db->link, $data['sanpham_Name']);
        $menucon = mysqli_real_escape_string($this->db->link, $data['menucon']);
        $thuonghieu = mysqli_real_escape_string($this->db->link, $data['thuonghieu']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $giagoc = isset($data['giagoc']) ? mysqli_real_escape_string($this->db->link, $data['giagoc']) : null;
        $ttsanpham = mysqli_real_escape_string($this->db->link, $data['ttsanpham']);
        $size_type = isset($data['size_type']) ? mysqli_real_escape_string($this->db->link, $data['size_type']) : '';
    
        // Lấy thông tin ảnh cũ từ cơ sở dữ liệu
        $get_sanpham = $this->getsanphambyID($id);
        $sanpham_data = $get_sanpham->fetch_assoc();
        $old_image = $sanpham_data['image'];
        $old_image2 = $sanpham_data['image2'];
        $old_image3 = $sanpham_data['image3'];

        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];
    
        $file_name2 = $_FILES['image2']['name'];
        $file_size2 = $_FILES['image2']['size'];
        $file_temp2 = $_FILES['image2']['tmp_name'];
    
        $file_name3 = $_FILES['image3']['name'];
        $file_size3 = $_FILES['image3']['size'];
        $file_temp3 = $_FILES['image3']['tmp_name'];

        if (!empty($file_name)) {
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploaded_image = 'upload/' . $unique_image;
            move_uploaded_file($file_temp, $uploaded_image);
        } else {
            $unique_image = $old_image;
        }
    
        if (!empty($file_name2)) {
            $div2 = explode('.', $file_name2);
            $file_ext2 = strtolower(end($div2));
            $unique_image2 = substr(md5(time()), 0, 10) . '2.' . $file_ext2;
            $uploaded_image2 = 'upload/' . $unique_image2;
            move_uploaded_file($file_temp2, $uploaded_image2);
        } else {
            $unique_image2 = $old_image2;
        }
        if (!empty($file_name3)) {
            $div3 = explode('.', $file_name3);
            $file_ext3 = strtolower(end($div3));
            $unique_image3 = substr(md5(time()), 0, 10) . '2.' . $file_ext3;
            $uploaded_image3 = 'upload/' . $unique_image3;
            move_uploaded_file($file_temp3, $uploaded_image3);
        } else {
            $unique_image3 = $old_image3;
        }
        $query = "UPDATE sanpham SET 
                  sanpham_Name = '$sanpham_Name', 
                  menucon_ID = '$menucon', 
                  brand_ID = '$thuonghieu', 
                  giagoc = '$giagoc', 
                  ttsanpham = '$ttsanpham', 
                  type = '$type', 
                  price = '$price', 
                  image = '$unique_image', 
                  image2 = '$unique_image2', 
                  image3 = '$unique_image3', 
                  size_type = '$size_type' 
                  WHERE sanpham_ID = '$id'";
    
        $result = $this->db->update($query);
    
        // Không xóa size cũ, chỉ cập nhật hoặc thêm mới
        if (isset($data['quantity'])) {
            foreach ($data['quantity'] as $size => $quantity) {
                $this->updateSizeQuantity($id, $size, $quantity);
            }
        }
    
        if ($result) {
            return "<b style='color:green' class='success'>Sửa sản phẩm thành công</b>";
        } else {
            return "<b style='color:red' class='error'>Sửa sản phẩm không thành công</b>";
        }
    }
    
    private function updateSizeQuantity($productId, $size, $quantity) {
        // Kiểm tra xem size này đã tồn tại chưa
        $query = "SELECT * FROM product_size WHERE sanpham_ID = '$productId' AND size = '$size'";
        $result = $this->db->select($query);
        if ($result && $result->num_rows > 0) {
            // Cập nhật số lượng cho size hiện tại
            $updateQuery = "UPDATE product_size SET quantity = '$quantity' WHERE sanpham_ID = '$productId' AND size = '$size'";
            $this->db->update($updateQuery);
        } else {
            // Thêm size mới nếu nó chưa tồn tại
            $insertQuery = "INSERT INTO product_size(sanpham_ID, size, quantity) VALUES ('$productId', '$size', '$quantity')";
            $this->db->insert($insertQuery);
        }
    }
    
    
    public function xoa_sanpham($id) {
        $id = mysqli_real_escape_string($this->db->link, $id);
    
        // Bắt đầu transaction
        $this->db->link->begin_transaction();
    
        try {
            // Cập nhật type của sản phẩm thành 4 thay vì xóa
            $querySanpham = "UPDATE sanpham SET type='4' WHERE sanpham_ID = '$id'";
            $resultSanpham = $this->db->update($querySanpham);
    
            // Kiểm tra xem việc cập nhật đã thành công chưa
            if ($resultSanpham) {
                // Xóa các dòng trong bảng product_size có sanpham_ID tương ứng
                $querySize = "DELETE FROM product_size WHERE sanpham_ID = '$id'";
                $resultSize = $this->db->delete($querySize);
    
                // Nếu xóa thành công, commit transaction
                if($resultSize) {
                    $this->db->link->commit();
                    return "<b style='color:green' class='success'>Sản phẩm và các size tương ứng đã được xóa thành công.</b>";
                } else {
                    // Nếu xóa thất bại, rollback transaction
                    $this->db->link->rollback();
                    return "<b style='color:red' class='error'>Không thể xóa các size của sản phẩm.</b>";
                }
            } else {
                // Nếu cập nhật thất bại, rollback transaction
                $this->db->link->rollback();
                return "<b style='color:red' class='error'>Không thể cập nhật trạng thái sản phẩm.</b>";
            }
        } catch (Exception $e) {
            // Nếu có lỗi xảy ra, rollback transaction và trả về thông báo lỗi
            $this->db->link->rollback();
            return "<b style='color:red' class='error'>Lỗi khi xử lý: " . $e->getMessage() . "</b>";
        }
    }
    
    
    

    public function getsanphambyID($id) {
        $query = "SELECT * FROM sanpham where sanpham_ID = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_sanpham() {
        // Thêm điều kiện WHERE để loại trừ sản phẩm với type là 4
        $query = "SELECT sanpham.*, menucon.menucon_Name, thuonghieu.brand_Name FROM sanpham 
                  INNER JOIN menucon ON sanpham.menucon_ID = menucon.menucon_ID 
                  INNER JOIN thuonghieu ON sanpham.brand_ID = thuonghieu.brand_ID 
                  WHERE sanpham.type != '4' 
                  ORDER BY sanpham.sanpham_ID DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getProductsAndSizes() {
        $query = "SELECT sanpham.sanpham_Name, product_size.size, product_size.quantity, product_size.prosize_id ,product_size.sanpham_ID
                  FROM product_size
                  INNER JOIN sanpham ON product_size.sanpham_ID = sanpham.sanpham_ID";
        $result_con = $this->db->select($query); // Giả sử method select() thực thi truy vấn và trả về kết quả
        return $result_con;
    }

    public function phan_trang() {
        $sp_tungtrang = 4;
        if(!isset($_GET['trang'])){
            $trang = 1;
        }
        else{
            $trang = $_GET['trang'];
        }
        $tung_trang = ($trang -1 ) * $sp_tungtrang;
        // Thêm điều kiện WHERE type != 4 vào câu truy vấn
        $query = "SELECT * FROM sanpham WHERE type != 4 ORDER BY sanpham_ID desc LIMIT $tung_trang, $sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function getTotalProducts() {
        $query = "SELECT COUNT(*) as total FROM sanpham";
        $result = $this->db->select($query);
        if($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        } else {
            return 0;
        }
    }
    

    public function getsanpham_noibat() {
        $query = "SELECT * FROM sanpham where type = '0'";
        $result = $this->db->select($query);
        return $result;
    }
    public function getsanpham_giamgia() {
        $query = "SELECT * FROM sanpham where type = '2'";
        $result = $this->db->select($query);
        return $result;
    }
    public function getsanpham_new() {
        $query = "SELECT * FROM sanpham WHERE type != '4' ORDER BY sanpham_ID DESC LIMIT 6";
        $result = $this->db->select($query);
        return $result;
    }
    

    public function get_chitiet($id) {
        $query = "SELECT sanpham.*, menucon.menucon_Name, thuonghieu.brand_Name FROM sanpham INNER JOIN menucon ON sanpham.menucon_ID = menucon.menucon_ID INNER JOIN thuonghieu ON sanpham.brand_ID = thuonghieu.brand_ID where sanpham.sanpham_ID ='$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function getmenucha_by_ID($id) {
        $query = "SELECT menucha.menucha_Name FROM sanpham JOIN menucon ON sanpham.menucon_ID = menucon.menucon_ID JOIN menucha ON menucon.menucha_ID = menucha.menucha_ID WHERE sanpham.sanpham_ID = '$id'";
        $result_menucha = $this->db->select($query);
        return $result_menucha;
    }
    // Thêm phương thức này vào class sanpham
// Trong class sanpham
public function getSizesAndQuantities($id) {
    $sizesQuantities = array();
    // Lấy tất cả các size và số lượng hiện tại từ bảng product_size
    $query = "SELECT size, quantity FROM product_size WHERE sanpham_ID = '$id'";
    $result = $this->db->select($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $size = $row['size'];
            $soLuongKhoiDau = $row['quantity'];

            // Lấy tổng số lượng đã bán của size này, kết nối bảng tbl_order và tbl_placed thông qua order_code
            $queryOrder = "SELECT SUM(o.quanly) AS daBan FROM tbl_order AS o INNER JOIN tbl_placed AS p ON o.order_code = p.order_code WHERE o.sanpham_ID = '$id' AND o.size = '$size' AND p.status IN (1, 2)";
            $resultOrder = $this->db->select($queryOrder);
            $soLuongDaBan = 0; // Khởi tạo số lượng đã bán là 0

            if ($resultOrder && $orderData = $resultOrder->fetch_assoc()) {
                $soLuongDaBan = $orderData['daBan'] ? $orderData['daBan'] : 0;
            }

            // Tính toán số lượng còn lại và cập nhật vào mảng
            $soLuongConLai = $soLuongKhoiDau - $soLuongDaBan;
            $sizesQuantities[$size] = $soLuongConLai;
        }
    }

    return $sizesQuantities;
}


// Trong class sanpham
public function getSizeType($id) {
    $query = "SELECT size_type FROM sanpham WHERE sanpham_ID = '$id'";
    $result = $this->db->select($query);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['size_type'];
    }
    return null; // Hoặc có thể trả về một giá trị mặc định nếu không tìm thấy thông tin
}
public function getSanPhambyID_menu($id) {
    $query = "SELECT * FROM menucon where menucha_ID = '$id'";
    $result = $this->db->select($query);
    return $result;
}
public function getSanPhamByMenucon($menuconId) {
    $query = "SELECT * FROM sanpham WHERE menucon_ID = '$menuconId'";
    $result = $this->db->select($query);
    return $result;
}
public function getSanPhamBybrand($brand_id) {
    $query = "SELECT * FROM sanpham WHERE brand_ID = '$brand_id'";
    $result = $this->db->select($query);
    return $result;
}
public function insertwlist($product_id, $customer_id){
$product_id = mysqli_real_escape_string($this->db->link, $product_id);
$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);

$check_wlist = "SELECT * FROM tbl_wlist WHERE sanpham_ID = '$product_id' AND user_id = '$customer_id'";
$result_check_wlist = $this->db->select($check_wlist);

if($result_check_wlist){
    $msg = "<span style='color:red;font-size:16px;'>sản phẩm này đã tồn tại trong danh sách yêu thích</span>";
    return $msg;
}else{
    $query = "SELECT * FROM sanpham WHERE sanpham_ID = '$product_id'";
    $result = $this->db->select($query)->fetch_assoc();

    $productName = $result['sanpham_Name'];
    $price = $result['price'];
    $image = $result['image'];

    $query_insert = "INSERT INTO tbl_wlist(sanpham_ID,price,image,user_id,sanpham_Name) VALUES('$product_id', '$price', '$image', '$customer_id', '$productName')";
    $insert_wlist = $this->db->insert($query_insert);

    if($insert_wlist){
        $alert = "<span style='color:green;font-size:16px;'>Đã thêm vào sản phẩm yêu thích</span>";
        return $alert;
    }else{
        $alert = "<span style='color:red;font-size:16px;'>thêm ko thành công</span>";
        return $alert;
    }
}

}
public function get_wlist($customer_id){
    $query ="SELECT * FROM tbl_wlist WHERE user_id = '$customer_id' order by id desc";
    $result = $this->db->select($query);
    return $result;
}
public function del_wlist($proid, $customer_id){
    $query = "DELETE FROM tbl_wlist WHERE user_id = '$customer_id' AND id = '$proid'";
    $result = $this->db->delete($query); // Correct method to delete the record
    if($result){
        $msg = "<span style='color:green;font-size:16px;'>Sản phẩm đã được xóa khỏi danh sách yêu thích</span>";
    } else {
        $msg = "<span style='color:red;font-size:16px;'>Không thể xóa sản phẩm khỏi danh sách yêu thích</span>";
    }
    return $msg;
}

// SLIDER 
public function insert_slider($data, $file){
         $slider_name = mysqli_real_escape_string($this->db->link, $data['slider_name']);
        $slider_type = mysqli_real_escape_string($this->db->link, $data['slider_type']);
        
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['slider_image']['name'];
        $file_size = $_FILES['slider_image']['size'];
        $file_temp = $_FILES['slider_image']['tmp_name'];
    
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(microtime()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "upload/" . $unique_image;
    
        if (($file_name == "") || $slider_type == "" || $slider_name == "") {
            return "<b style='color:red' class='success'>Các trường không được để trống</b>";
        } else {
            move_uploaded_file($file_temp, $uploaded_image);


            $query = "INSERT INTO tbl_slider(slider_image, slider_name, slider_type) VALUES ('$unique_image','$slider_name','$slider_type')";            
            $result = $this->db->insert($query);
            if($result){
                $msg = "<span style='color:green;font-size:16px;'>Thêm slider thành công</span>";
            } else {
                $msg = "<span style='color:red;font-size:16px;'>Không thể thêm slider</span>";
            }
            return $msg;
    
        }
}

public function getActiveSliders() {
    $query = "SELECT * FROM tbl_slider WHERE slider_type = '0'";
    $result = $this->db->select($query);
    return $result;
}
public function show_slider_list() {
    $query = "SELECT * FROM tbl_slider order by slider_id desc";
    $result = $this->db->select($query);
    return $result;
}
public function update_slider($id, $type) {
    $id = mysqli_real_escape_string($this->db->link, $id);
    $type = mysqli_real_escape_string($this->db->link, $type);
    $query = "UPDATE tbl_slider SET slider_type = '$type' WHERE slider_id = '$id'";
    $result = $this->db->update($query);
    return $result;
}
public function del_slider($id){
    $id = mysqli_real_escape_string($this->db->link, $id);
    $query = "DELETE from tbl_slider where slider_id = '$id'";
    $result = $this->db->update($query);
    return $result;
}
public function search_product($tu_khoa){
    $tu_khoa = $this->fm->validation($tu_khoa);
    $query = "SELECT * FROM sanpham WHERE sanpham_Name LIKE '%$tu_khoa%'";
    $result = $this->db->select($query);
    return $result;
}

//news
public function insert_news($data, $file){
    $tieu_de = mysqli_real_escape_string($this->db->link, $data['tieu_de']);
    $content = mysqli_real_escape_string($this->db->link, $data['content']);
    
    $permited = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_temp = $_FILES['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(microtime()), 0, 10) . '.' . $file_ext;
    $uploaded_image = "upload/" . $unique_image;

    if (($file_name == "") || $tieu_de == "" || $content == "") {
        return "<b style='color:red' class='success'>Các trường không được để trống</b>";
    } else {
        move_uploaded_file($file_temp, $uploaded_image);


        $query = "INSERT INTO tbl_new(image, tieu_de, content) VALUES ('$unique_image','$tieu_de','$content')";            
        $result = $this->db->insert($query);
        if($result){
            $msg = "<span style='color:green;font-size:16px;'>Thêm slider thành công</span>";
        } else {
            $msg = "<span style='color:red;font-size:16px;'>Không thể thêm slider</span>";
        }
        return $msg;

    }
}

public function show_news(){
    $query = "SELECT * FROM tbl_new order by id desc";
    $result = $this->db->select($query);
    return $result;
}

public function getnewsbyID($id){
    $query = "SELECT * FROM tbl_new WHERE id = '$id' LIMIT 1";
    $result = $this->db->select($query);
    return $result;
}

public function update_news($data, $files, $id){
    $tieu_de = mysqli_real_escape_string($this->db->link, $data['tieu_de']);
    $content = mysqli_real_escape_string($this->db->link, $data['content']);


    // Lấy thông tin ảnh cũ từ cơ sở dữ liệu
    $get_news = $this->getnewsbyID($id);
    $news_data = $get_news->fetch_assoc();
    $old_image = $news_data['image'];

    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_temp = $_FILES['image']['tmp_name'];

    if (!empty($file_name)) {
        // Nếu có file mới, thực hiện di chuyển và cập nhật đường dẫn hình ảnh mới
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = 'upload/'.$unique_image;
        move_uploaded_file($file_temp, $uploaded_image);
    } else {
        // Nếu không có file mới, giữ nguyên hình ảnh cũ
        $unique_image = $old_image;
    }
    

    $query = "UPDATE tbl_new SET 
              tieu_de = '$tieu_de', 
              content = '$content',  
              image = '$unique_image'
              WHERE id = '$id'";
    $result = $this->db->update($query);
    if ($result) {
        return "<b style='color:green' class='success'>Sửa tin tức thành công</b>";
    } else {
        return "<b style='color:red' class='error'>Sửa tin tức không thành công</b>";
    }
}


//đánh giá sao
public function get_star($id,$customer_id){
    $query = "SELECT * FROM tbl_rating WHERE sanpham_ID ='$id' AND user_id ='$customer_id'";
    $result = $this->db->select($query);
    return $result;
}
}

?>

