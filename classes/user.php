<?php
$fliepath = realpath(dirname(__FILE__));
include_once ($fliepath.'/../lib/database.php');
include_once ($fliepath.'/../helpers/format.php');
?>

<?php
class user
{
    private $db;
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function add_user($data){
        $user_name = mysqli_real_escape_string($this->db->link, $data['user_name']);
        $user_pass = mysqli_real_escape_string($this->db->link, $data['user_pass']);
        $user_email = mysqli_real_escape_string($this->db->link, $data['user_email']);
        $user_phone = mysqli_real_escape_string($this->db->link, $data['user_phone']);
        $address = mysqli_real_escape_string($this->db->link, $data['address']);


        if($user_name=="" ||$user_pass==""||$user_email==""||$user_phone=="" || $address==""){
            $alert ="<b style='color:red' class='success'>Các trường ko được rỗng</b>";
            return $alert;
        }
        else{
            $emailCheckQuery = "SELECT * FROM user WHERE user_email = '$user_email'";
            $emailCheckResult = $this->db->select($emailCheckQuery);
            if($emailCheckResult != false){
                // Email already exists
                $alert ="<b style='color:red' class='error'>Email đã tồn tại trong hệ thống. Vui lòng sử dụng email khác.</b>";
                return $alert;
            } 
            
            else {
                // Insert the new user as email does not exist
                $query = "INSERT INTO user(user_name,user_pass,user_email,user_phone,address) VALUES ('$user_name','$user_pass ','$user_email','$user_phone','$address')";
                $result = $this->db->insert($query);
                if($result){
                    $alert ="<h5><b style='color:green' class='success'>Đăng ký tài khoản thành công</b></h5>";
                    return $alert;
                } else {
                    $alert ="<h5><b style='color:red' class='error'>Đăng ký tài khoản không thành công</b></h5>";
                    return $alert;
                }
            }
        }   
    }
    public function show_user(){
        $query = "SELECT *FROM user order by user_id desc";
        $result = $this->db->select($query);
        return $result;
    
    }
    public function xoa_user($id){
        $query = "DELETE FROM user where user = '$id'";
        $result = $this->db->delete($query);
        if($result){
            $alert ="<b style='color:green' class='success'>Xóa user thành công</b>";
            return $alert;
           }
           else{
            $alert ="<b style='color:red' class='erro'>Xóa user ko thành công</b>";
            return $alert;
        }
        return $result;
    }
    public function update_user($data, $id){
        $user_name = mysqli_real_escape_string($this->db->link, $data['user_name'] ?? "");
        $user_pass = mysqli_real_escape_string($this->db->link, $data['user_pass'] ?? "");
        $user_email = mysqli_real_escape_string($this->db->link, $data['user_email'] ?? "");
        $user_phone = mysqli_real_escape_string($this->db->link, $data['user_phone'] ?? "");       
        $address = mysqli_real_escape_string($this->db->link, $data['address'] ?? "");         
    
        if ($user_name == "" || $user_pass == "" || $user_email == "" || $user_phone == "" || $address == "") {
            $alert = "<b style='color:red' class='success'>Các trường không được để trống</b>";
            return $alert;
        } else {
            // Check if email exists for another user
            $emailCheckQuery = "SELECT * FROM user WHERE user_email = '$user_email' AND user_id != '$id'";
            $emailCheckResult = $this->db->select($emailCheckQuery);
            if($emailCheckResult != false){
                // Email already exists
                return "<b style='color:red'>Email đã tồn tại trong hệ thống, vui lòng chọn Email khác</b>";
            } else {
                // Proceed with the update
                $query = "UPDATE user SET 
                          user_name = '$user_name', 
                          user_pass = '$user_pass', 
                          user_email = '$user_email',
                          user_phone = '$user_phone',
                          address = '$address'
                          WHERE user_id = '$id'";
                $result = $this->db->update($query); // Use the update method
                if($result){
                    return "<b style='color:green' class='success'>Cập nhật tài khoản thành công</b>";
                } else {
                    return "<b style='color:red' class='error'>Cập nhật tài khoản không thành công</b>";
                }
            }   
        }
    }
    
    
    public function getuserbyID($id){
        $id = mysqli_real_escape_string($this->db->link, $id);
        $query = "SELECT * FROM user WHERE user_id = '$id' LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function login_user($data) {
        $username = mysqli_real_escape_string($this->db->link, $data['username']);
        // Mã hóa mật khẩu nhập vào bằng MD5 trước khi so sánh
        $password = mysqli_real_escape_string($this->db->link, $data['password']);
        
        if($username == "" || $password == ""){
            $alert = "<b style='color:red' class='error'>Không được bỏ trống tài khoản hoặc mật khẩu</b>";
            return $alert;
        }
        else{
            // Cập nhật câu truy vấn để so sánh mật khẩu đã mã hóa
            $check_user = "SELECT * FROM user WHERE user_name = '$username' AND user_pass = '$password' LIMIT 1";
            $result_check = $this->db->select($check_user);
            if($result_check != false){
                $value = $result_check->fetch_assoc();
                Session::set('customer_login', true);
                Session::set('customer_id', $value['user_id']);
                Session::set('customer_name', $value['user_name']);
                return true;
            }
            else{
                $alert = "<b style='color:red' class='error'>Tài khoản hoặc mật khẩu không đúng</b>";
                return $alert;
            }
        }
    }
    
    public function show_one_cus($id){
        $query = "SELECT *FROM user WHERE user_id = '$id' LIMIT 1";
        $result = $this->db->select($query);
        return $result;    }
        function checkEmail($email){
            $query= "SELECT * FROM user where email ='$email'";
            $result = $this->db->select($query);
            return $result;
        }
        // Bình luận
        public function insert_cmt(){
            $product_id = $_POST['pro_id_cmt'];
            $tenbinhluan = $_POST['user_cmt'];
            $binhluan = mysqli_real_escape_string($this->db->link, $_POST['cmt']);
            if($tenbinhluan == "" || $binhluan == ""){
                $alert = "<b style='color:red' class='error'>Bạn phải điền đầy đủ trước ghi bấm gửi</b>";
                return $alert;
            }
            else{
                $query = "INSERT INTO tbl_cmt(cmt_user,cmt,sanpham_ID) VALUES ('$tenbinhluan','$binhluan ','$product_id')";
                $result = $this->db->insert($query);
                if($result){
                 $alert ="<h5><b style='color:green' class='success'>Gửi bình luận thành công</b></h5>";
                 return $alert;
                }
                else{
                 $alert ="<h5><b style='color:red' class='erro'>Gửi bình luận ko thành công</b></h5>";
                 return $alert;
                }
             }   
        }

        public function get_comments($product_id, $start = 0, $limit = 5) {
            $product_id = mysqli_real_escape_string($this->db->link, $product_id);
            $query = "SELECT * FROM tbl_cmt WHERE sanpham_ID = '$product_id' ORDER BY cmt_id DESC LIMIT $start, $limit";
            $result = $this->db->select($query);
            return $result;
        }
        
 }
?>