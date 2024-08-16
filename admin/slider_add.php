<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/sanpham.php'; ?>

<?php
 $slider = new sanpham();
 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) ){
    $insert_slider = $slider->insert_slider($_POST, $_FILES);
 }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Slider</h2>
    <div class="block">      
    <?php 
                if(isset($insert_slider)){
                    echo $insert_slider;
                }
                ?>     
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">     
                <tr>
                    <td>
                        <label>Slider name</label>
                    </td>
                    <td>
                        <input type="text" name="slider_name" placeholder="Enter Slider Title..." class="medium" />
                    </td>
                </tr>           
    
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                        <input type="file" name="slider_image"/>
                    </td>
                </tr>
               
                <tr>
                    <td>
                        <label>Type</label>
                    </td>
                    <td>
                        <select name="slider_type">
                            <option value="0">On</option>
                            <option value="1">Off</option>
                        </select>
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