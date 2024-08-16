<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/sanpham.php'; ?>

<?php
 $news = new sanpham();
 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) ){
    $insert_news = $news->insert_news($_POST, $_FILES);
 }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Add News</h2>
    <div class="block">      
    <?php 
                if(isset($insert_news)){
                    echo $insert_news;
                }
                ?>     
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">     
                <tr>
                    <td>
                        <label>Tiêu đề</label>
                    </td>
                    <td>
                        <input type="text" name="tieu_de" placeholder="Enter news Title..." class="medium" />
                    </td>
                </tr>           
    
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                        <input type="file" name="image"/>
                    </td>
                </tr>
               
                <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Nội dung</label>
                        </td>
                        <td>
                            <textarea name="content" class="tinymce"></textarea>
                        </td>
                    </tr>
				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="save" />
                    </td>
                </tr>
            </table>
            </form>
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
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>