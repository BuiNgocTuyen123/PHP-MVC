<?php
$fliepath = realpath(dirname(__FILE__));
include_once ($fliepath.'/../lib/database.php');
include_once ($fliepath.'/../helpers/format.php');
?>

<?php
class thuonghieu
{
    private $db;
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function chen_thuonghieu($brand_Name) {
        $brand_Name = $this->fm->validation($brand_Name);

        $brand_Name = mysqli_real_escape_string($this->db->link, $brand_Name);

        if(empty($brand_Name)){
            $alert ="<b style='color:red' class='success'>Hãy điền thương hiệu</b>";
            return $alert;
        }
        else{
           $query = "INSERT INTO thuonghieu(brand_Name) VALUES ('$brand_Name')";
           $result = $this->db->insert($query);
           if($result){
            $alert ="<b style='color:green' class='success'>Thêm thương hiệu thành công</b>";
            return $alert;
           }
           else{
            $alert ="<b style='color:red' class='erro'>Thêm thương hiệu ko thành công</b>";
            return $alert;
           }
        }   
    }
    public function show_thuonghieu(){
        $query = "SELECT *FROM thuonghieu order by brand_ID desc";
        $result = $this->db->select($query);
        return $result;
    
    }
    public function getbrandbyID($id){
        $query = "SELECT *FROM thuonghieu where brand_ID = '$id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_thuonghieu($brand_Name,$id){
        $brand_Name = $this->fm->validation($brand_Name);

        $brand_Name = mysqli_real_escape_string($this->db->link, $brand_Name);
        $id = mysqli_real_escape_string($this->db->link, $id);
        if(empty($brand_Name)){
            $alert ="<b style='color:red' class='success'>Hãy điền danh mục</b>";
            return $alert;
        }
        else{
           $query = "UPDATE thuonghieu SET brand_Name = '$brand_Name'WHERE brand_ID='$id'";
           $result = $this->db->update($query);
           if($result){
            $alert ="<b style='color:green' class='success'>Sửa danh mục thành công</b>";
            return $alert;
           }
           else{
            $alert ="<b style='color:red' class='erro'>Sửa danh mục ko thành công</b>";
            return $alert;
           }
        }   
    }
    public function xoa_thuonghieu($id){
        $query = "DELETE FROM thuonghieu where brand_ID = '$id'";
        $result = $this->db->delete($query);
        if($result){
            $alert ="<b style='color:green' class='success'>Xóa danh mục thành công</b>";
            return $alert;
           }
           else{
            $alert ="<b style='color:red' class='erro'>Xóa danh mục ko thành công</b>";
            return $alert;
        }
        return $result;
    }
}
?>