<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/menucha.php'; ?>
<?php include '../classes/thuonghieu.php'; ?>
<?php include '../classes/sanpham.php'; ?>
<?php
$sp = new sanpham();
if(isset($_GET['sanpham_ID']) && $_GET['sanpham_ID'] != NULL){
    $id = $_GET['sanpham_ID'];
} else {
    echo "<script>window.location ='productlist.php'</script>";
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    $updatesp = $sp->update_sanpham($_POST, $_FILES, $id);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa sản phẩm</h2>
        <div class="block">
            <?php if(isset($updatesp)){ echo $updatesp; } ?>
            <?php
            $get_sanpham_by_id = $sp->getsanphambyID($id);
            if($get_sanpham_by_id){
                while($result_sanpham = $get_sanpham_by_id->fetch_assoc()){
                    ?>     
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Tên</label>
                    </td>
                    <td>
                        <input name="sanpham_Name" type="text" value="<?php echo $result_sanpham['sanpham_Name'] ?>" class="medium" />
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Danh mục</label>
                    </td>
                    <td>
                        <select id="select" name="menucon">
                            <option>Danh mục</option>
                            <?php
                            $menucon = new menucha();
                            $menuconlist = $menucon->show_menucon();
                            if($menuconlist){
                                while($result = $menuconlist->fetch_assoc()){

                            ?>
                            <option
                            <?php if($result['menucon_ID']==$result_sanpham['menucon_ID']){echo'selected';} ?>
                            value="<?php echo $result['menucon_ID'] ?>"><?php echo $result['menucon_Name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Thương hiệu</label>
                    </td>
                    <td>
                        <select id="select" name="thuonghieu">
                            <option>Thương hiệu</option>
                            <?php
                            $brand = new thuonghieu();
                            $brandlist = $brand->show_thuonghieu();
                            if($brandlist){
                                while($result = $brandlist->fetch_assoc()){

                            ?>
                            <option
                            <?php if($result['brand_ID']==$result_sanpham['brand_ID']){echo'selected';} ?>
                            value="<?php echo $result['brand_ID'] ?>"><?php echo $result['brand_Name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
				<select id="productType" name="type" onchange="toggleGiaGocField()">
    <option value="0" <?php echo $result_sanpham['type'] == 0 ? 'selected' : ''; ?>>Không nổi bật</option>
    <option value="1" <?php echo $result_sanpham['type'] == 1 ? 'selected' : ''; ?>>Sản phẩm nổi bật</option>
    <option value="2" <?php echo $result_sanpham['type'] == 2 ? 'selected' : ''; ?>>Sản phẩm giảm giá</option>
    <option value="3" <?php echo $result_sanpham['type'] == 3 ? 'selected' : ''; ?>>Sản phẩm mới</option>
</select>
                    </td>
                </tr>
				 <tr>
                    <td>
                        <label>Giá gốc</label>
                    </td>
                    <td>
                        <input id="giagoc" name="giagoc" value="<?php echo $result_sanpham['giagoc'] ?>" type="text" placeholder="Enter Price..." class="mediun">
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Price</label>
                    </td>
                    <td>
                        <input name="price" value="<?php echo $result_sanpham['price'] ?>" type="text" placeholder="Enter Price..." class="medium" />
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Description</label>
                    </td>
                    <td>
                        <textarea name="ttsanpham" class="tinymce"><?php echo $result_sanpham['ttsanpham'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Upload Image 1</label>
                    </td>
                    <td>
                    <img src="upload/<?php echo $result_sanpham['image'] ?>" width="40px" height="40px">
                        <input type="file" name="image" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Upload Image 2</label>
                    </td>
                    <td>
                    <img src="upload/<?php echo $result_sanpham['image2'] ?>" width="40px" height="40px">
                        <input type="file" name="image2" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Upload Image 3</label>
                    </td>
                    <td>
                    <img src="upload/<?php echo $result_sanpham['image3'] ?>" width="40px" height="40px">
                        <input type="file" name="image3" />
                    </td>
                </tr>
				<tr>
                        <td>
                            <label>loại size:</label>
                        </td>
                        <td>
<b>  <?php echo $result_sanpham['size_type'] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Size và Số lượng</label>
                        </td>
                        <td>
                            <?php
                            $sizesQuantities = $sp->getSizesAndQuantities($id);
                            foreach ($sizesQuantities as $size => $quantity) {
                                echo "<div><label>Size $size: </label><input type='number' name='quantity[$size]' value='$quantity' class='medium' /></div>";
                            }
                            ?>
                        </td>
                    </tr>

            
				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
        toggleSizeFields(); // Call this function on page load
    });
</script>
<script type="text/javascript">
    // JavaScript để xử lý việc hiển thị các trường nhập số lượng
    function toggleGiaGocField() {
        var productTypeSelect = document.getElementById('productType');
        var giaGocField = document.getElementById('giagoc');
        if (productTypeSelect.value === '2') {
            giaGocField.style.display = 'block';
        } else {
            giaGocField.style.display = 'none';
        }
    }

    function toggleSizeFields() {
        var sizeType = document.getElementById('selectSizeType').value;
        var sizeAoFields = document.getElementById('sizeAoFields');
        var sizeQuanFields = document.getElementById('sizeQuanFields');
        if (sizeType === 'áo') {
            sizeAoFields.style.display = 'table-row';
            sizeQuanFields.style.display = 'none';
        } else if (sizeType === 'quần') {
            sizeQuanFields.style.display = 'table-row';
            sizeAoFields.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleGiaGocField();
        document.getElementById('productType').addEventListener('change', toggleGiaGocField);

        // Khi trang tải xong, kiểm tra và thiết lập trạng thái hiển thị cho các trường liên quan đến size
        toggleSizeFields();
        document.getElementById('selectSizeType').addEventListener('change', toggleSizeFields);
    });
</script>


<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>


