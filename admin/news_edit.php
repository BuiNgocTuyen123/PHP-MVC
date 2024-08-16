<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/sanpham.php'; ?>
<?php
$news = new sanpham();
if(isset($_GET['id']) && $_GET['id'] != NULL){
    $id = $_GET['id'];
} else {
    echo "<script>window.location ='news_all.php'</script>";
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    $update_news = $news->update_news($_POST, $_FILES, $id);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa tin tức</h2>
        <div class="block">
            <?php if(isset($update_news)){ echo $update_news; } ?>
            <?php
            $get_news_by_id = $news->getnewsbyID($id);
            if($get_news_by_id){
                while($result_news = $get_news_by_id->fetch_assoc()){
                    ?>     
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Tiêu đề</label>
                    </td>
                    <td>
                        <input name="tieu_de" type="text" value="<?php echo $result_news['tieu_de'] ?>" class="medium" />
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Nội dung</label>
                    </td>
                    <td>
                        <textarea name="content" class="tinymce"><?php echo $result_news['content'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                    <img src="upload/<?php echo $result_sanpham['image'] ?>" width="40px" height="40px">
                        <input type="file" name="image" />
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


