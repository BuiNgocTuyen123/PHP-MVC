<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/menucha.php'; ?>
<?php include '../classes/thuonghieu.php'; ?>
<?php include '../classes/sanpham.php'; ?>

<?php
$sp = new sanpham();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $insertsp = $sp->chen_sanpham($_POST, $_FILES);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm sản phẩm</h2>
        <div class="block">
            <?php
            if (isset($insertsp)) {
                echo $insertsp;
            }
            ?>
            <form action="productadd.php" method="post" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td>
                            <label>Tên</label>
                        </td>
                        <td>
                            <input name="sanpham_Name" type="text" placeholder="Enter Product Name..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Danh mục</label>
                        </td>
                        <td>
                            <select id="select" name="menucon">
                                <option>Danh mục</option>
                                <?php
                                $menucon = new menucha();
                                $menuconlist = $menucon->show_menucon();
                                if ($menuconlist) {
                                    while ($result_con = $menuconlist->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $result_con['menucon_ID']; ?>">
                                            <?php echo $result_con['menucon_Name']; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Thương hiệu</label>
                        </td>
                        <td>
                            <select id="select" name="thuonghieu">
                                <option>Thương hiệu</option>
                                <?php
                                $brand = new thuonghieu();
                                $brandlist = $brand->show_thuonghieu();
                                if ($brandlist) {
                                    while ($result = $brandlist->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $result['brand_ID']; ?>">
                                            <?php echo $result['brand_Name']; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Loại sản phẩm</label>
                        </td>
                        <td>
                            <select id="productType" name="type">
                                <option>Danh sách loại sản phẩm</option>
                                <option value="0">Không nổi bật</option>
                                <option value="1">Sản phẩm nổi bật</option>
                                <option value="2">Sản phẩm giảm giá</option>
                                <option value="3">Sản phẩm mới</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Giá gốc</label>
                        </td>
                        <td>
                            <input id="giaGoc" name="giagoc" type="text" placeholder="Enter Price..." class="medium" style="display:none;" />
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Thông tin chi tiết</label>
                        </td>
                        <td>
                            <textarea name="ttsanpham" class="tinymce"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Upload Image 1</label>
                        </td>
                        <td>
                            <input type="file" name="image" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Upload Image 2</label>
                        </td>
                        <td>
                            <input type="file" name="image2" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Upload Image 3</label>
                        </td>
                        <td>
                            <input type="file" name="image3" />
                        </td>
                    </tr>
                   <tr>
                        <td>
                            <label>Chọn size</label>
                        </td>
                        <td>
                            <select id="selectSizeType" name="size_type" onchange="toggleSizeFields(this.value)">
                                <option value="">Chọn loại size</option>
                                <option value="áo">Size áo</option>
                                <option value="quần">Size quần</option>
                            </select>
                        </td>
                    </tr>

                    <!-- Trường nhập số lượng cho size áo -->
                    <tr id="sizeAoFields" style="display:none;">
                        <td>
                            <label>Size Áo</label>
                        </td>
                        <td>
                            <input type="number" id="quantity_S" name="quantity_S" placeholder="Số lượng S..." class="medium" />
                            <input type="number" id="quantity_M" name="quantity_M" placeholder="Số lượng M..." class="medium" />
                            <input type="number" id="quantity_L" name="quantity_L" placeholder="Số lượng L..." class="medium" />
                            <input type="number" id="quantity_XL" name="quantity_XL" placeholder="Số lượng XL..." class="medium" />
                        </td>
                    </tr>

                    <!-- Trường nhập số lượng cho size quần -->
                    <tr id="sizeQuanFields" style="display:none;">
                        <td>
                            <label>Size Quần</label>
                        </td>
                        <td>
                            <input type="number" id="quantity_28" name="quantity_28" placeholder="Số lượng 28..." class="medium" />
                            <input type="number" id="quantity_29" name="quantity_29" placeholder="Số lượng 29..." class="medium" />
                            <input type="number" id="quantity_30" name="quantity_30" placeholder="Số lượng 30..." class="medium" />
                            <input type="number" id="quantity_31" name="quantity_31" placeholder="Số lượng 31..." class="medium" />
                            <input type="number" id="quantity_32" name="quantity_32" placeholder="Số lượng 32..." class="medium" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Giá bán</label>
                        </td>
                        <td>
                            <input name="price" type="text" placeholder="Enter Price..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Save" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    setupTinyMCE();
    setDatePicker('date-picker');
    $('input[type="checkbox"]').fancybutton();
    $('input[type="radio"]').fancybutton();
});

function clearSizeFields() {
    document.getElementById('quantity_S').value = "";
    document.getElementById('quantity_M').value = "";
    document.getElementById('quantity_L').value = "";
    document.getElementById('quantity_XL').value = "";
    document.getElementById('quantity_28').value = "";
    document.getElementById('quantity_29').value = "";
    document.getElementById('quantity_30').value = "";
    document.getElementById('quantity_31').value = "";
    document.getElementById('quantity_32').value = "";
}

function toggleSizeFields(value) {
    var sizeAoFields = document.getElementById('sizeAoFields');
    var sizeQuanFields = document.getElementById('sizeQuanFields');
    clearSizeFields(); // Clear all fields when changing the size type

    if (value === 'áo') {
        sizeAoFields.style.display = 'table-row';
        sizeQuanFields.style.display = 'none';
    } else if (value === 'quần') {
        sizeQuanFields.style.display = 'table-row';
        sizeAoFields.style.display = 'none';
    } else {
        sizeAoFields.style.display = 'none';
        sizeQuanFields.style.display = 'none';
    }
}

document.getElementById('productType').addEventListener('change', toggleGiaGocField);
</script>
<script>

function toggleGiaGocField() {
    var productType = document.getElementById('productType');
    var giaGocField = document.getElementById('giaGoc');
    if (productType.value === '2') {
        giaGocField.style.display = 'block';
    } else {
        giaGocField.style.display = 'none';
        giaGocField.value = '';
    }
}

document.getElementById('productType').addEventListener('change', toggleGiaGocField);
</script>

<?php include 'inc/footer.php'; ?>
