<?php
$fliepath = realpath(dirname(__FILE__));
include ($fliepath.'/../lib/session.php');
Session::checkLogin();
include_once ($fliepath.'/../lib/database.php');
include_once ($fliepath.'/../helpers/format.php');
?>

<?php
class adminlogin
{
    private $db;
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function login_admin($admin_USER,$admin_PASS) {
        $admin_USER = $this->fm->validation($admin_USER);
        $admin_PASS = $this->fm->validation($admin_PASS);

        $admin_USER = mysqli_real_escape_string($this->db->link, $admin_USER);
        $admin_PASS = mysqli_real_escape_string($this->db->link, $admin_PASS);

        if(empty($admin_USER) || empty($admin_PASS)){
            $alert ="Hãy điền đủ tài khoản và mật khẩu";
            return $alert;
        }
        else{
            $query = "SELECT * FROM table_admin WHERE admin_USER = '$admin_USER' AND admin_PASS ='$admin_PASS' LIMIT 1";
            $result = $this->db->select($query);

            if($result !== FALSE){
                $value = $result->fetch_assoc();
                Session::set('adminlogin',true);
                Session::set('admin_ID',$value['admin_ID']);
                Session::set('admin_USER',$value['admin_USER']);
                Session::set('admin_NAME',$value['admin_NAME']);
                header("Location:index.php");

            }
            else{
                $alert = "Tên tài khoản hoặc mật khẩu ko đúng";
                return $alert;
            }
        }   
    }
    public function login_check() {
        
    }
}


?>