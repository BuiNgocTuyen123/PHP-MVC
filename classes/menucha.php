<?php
$fliepath = realpath(dirname(__FILE__));
include_once ($fliepath.'/../lib/database.php');
include_once ($fliepath.'/../helpers/format.php');
?>

<?php
class menucha
{
    private $db;
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function chen_menucha($menucha_Name) {
        $menucha_Name = $this->fm->validation($menucha_Name);

        $menucha_Name = mysqli_real_escape_string($this->db->link, $menucha_Name);

        if(empty($menucha_Name)){
            $alert ="<b style='color:red' class='success'>Hãy điền tên menu</b>";
            return $alert;
        }
        else{
           $query = "INSERT INTO menucha(menucha_Name) VALUES ('$menucha_Name')";
           $result_cha = $this->db->insert($query);
           if($result_cha){
            $alert ="<b style='color:green' class='success'>Thêm danh mục thành công</b>";
            return $alert;
           }
           else{
            $alert ="<b style='color:red' class='erro'>Thêm danh mục ko thành công</b>";
            return $alert;
           }
        }   
    }
    public function show_menucha(){
        $query = "SELECT *FROM menucha order by menucha_ID desc";
        $result_cha = $this->db->select($query);
        return $result_cha;
    
    }
    public function getcatbyID($id){
        $query = "SELECT *FROM menucha where menucha_ID = '$id'";
        $result_cha = $this->db->select($query);
        return $result_cha;
    }
    public function update_menucha($menucha_Name,$id){
        $menucha_Name = $this->fm->validation($menucha_Name);

        $menucha_Name = mysqli_real_escape_string($this->db->link, $menucha_Name);
        $id = mysqli_real_escape_string($this->db->link, $id);
        if(empty($menucha_Name)){
            $alert ="<b style='color:red' class='success'>Hãy điền tên menu</b>";
            return $alert;
        }
        else{
           $query = "UPDATE menucha SET menucha_Name = '$menucha_Name'WHERE menucha_ID='$id'";
           $result_cha = $this->db->update($query);
           if($result_cha){
            $alert ="<b style='color:green' class='success'>Sửa menu cha thành công</b>";
            return $alert;
           }
           else{
            $alert ="<b style='color:red' class='erro'>Sửa menucha ko thành công</b>";
            return $alert;
           }
        }   
    }
    public function xoa_menucha($id){
        $query = "DELETE FROM menucha where menucha_ID = '$id'";
        $result_cha = $this->db->delete($query);
        if($result_cha){
            $alert ="<b style='color:green' class='success'>Xóa danh mục thành công</b>";
            return $alert;
           }
           else{
            $alert ="<b style='color:red' class='erro'>Xóa danh mục ko thành công</b>";
            return $alert;
        }
        return $result_cha;
    }
    public function chen_menucon($data) {
        $menucon_Name = mysqli_real_escape_string($this->db->link, $data['menucon_Name']);
        $menucha_Name = mysqli_real_escape_string($this->db->link, $data['menucha']);
        if($menucha_Name=="" ||$menucon_Name==""){
            $alert ="<b style='color:red' class='success'>Các trường ko được rỗng</b>";
            return $alert;
        }
        else{
           $query = "INSERT INTO menucon(menucon_Name,menucha_ID) VALUES ('$menucon_Name','$menucha_Name')";
           $result_con = $this->db->insert($query);
           if($result_con){
            $alert ="<b style='color:green' class='success'>Thêm menucon thành công</b>";
            return $alert;
           }
           else{
            $alert ="<b style='color:red' class='erro'>Thêm menucon ko thành công</b>";
            return $alert;
           }
        }    
    }
    public function show_menucon(){
        $query = " SELECT menucon.*, menucha.menucha_Name
        FROM menucon INNER JOIN menucha ON menucon.menucha_ID = menucha.menucha_ID
        order by menucon.menucon_ID desc";
        $result_con = $this->db->select($query);
        return $result_con;
    }
    public function show_menuconn($menucha_ID){
        $query = "SELECT * FROM menucon WHERE menucha_ID = '$menucha_ID'";
        $result_con = $this->db->select($query);
        return $result_con;
    }
    
    public function getmenuconbyID($id){
        $query = "SELECT *FROM menucon where menucon_ID = '$id'";
        $result_con = $this->db->select($query);
        return $result_con;
    }
    public function update_menucon($data, $id) {
        $menucon_Name = mysqli_real_escape_string($this->db->link, $data['menucon_Name']);
        $menucha_Name = mysqli_real_escape_string($this->db->link, $data['menucha']);
    
        if (empty($menucon_Name) || empty($menucha_Name)) {
            $alert = "<b style='color:red' class='success'>Các trường không được rỗng</b>";
            return $alert;
        } else {
            $query = "UPDATE menucon SET
                menucon_Name = '$menucon_Name',
                menucha_ID = '$menucha_Name'
                WHERE menucon_ID = '$id'";
            $result_con = $this->db->update($query);
            if ($result_con) {
                $alert = "<b style='color:green' class='success'>Cập menucon phẩm thành công</b>";
                return $alert;
            } else {
                $alert = "<b style='color:red' class='error'>Cập nhật menucon không thành công</b>";
                return $alert;
            }
        }    
    }
    public function xoa_menucon($id){
        $query = "DELETE FROM menucon where menucon_ID = '$id'";
        $result_con = $this->db->delete($query);
        if($result_con){
            $alert ="<b style='color:green' class='success'>Xóa menu con thành công</b>";
            return $alert;
           }
           else{
            $alert ="<b style='color:red' class='erro'>Xóa menu con ko thành công</b>";
            return $alert;
        }
        return $result_con;
    }
    
}
?>