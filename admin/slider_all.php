<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/sanpham.php'; ?>
<?php
 $slider = new sanpham();
if(isset($_GET['slider_id']) && isset($_GET['slider_type'])){
	$id = $_GET['slider_id'];
	$type = $_GET['slider_type'];
	$update_slider = $slider->update_slider($id, $type);
		

}
if(isset($_GET['slider_del'])){
	$id = $_GET['slider_del'];
	$del_slider = $slider->del_slider($id);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Slider List</h2>
		<?php
?>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>No.</th>
					<th>Slider Title</th>
					<th>Slider Image</th>
					<th>Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				 $slider = new sanpham();
			$getSliders = $slider->show_slider_list();
        if ($getSliders) {
            $i = 0;
            while ($result = $getSliders->fetch_assoc()) {
				$i++;
				?>
				<tr class="odd gradeX">
					<td><?php echo $i ?></td>
					<td><?php echo $result['slider_name'] ?></td>
					<td><img src="upload/<?php echo $result['slider_image'] ?>" height="40px" width="60px"/></td>	
					<td>
	<?php
	if($result['slider_type'] == 0){
	?>
		<a href="?slider_id=<?php echo $result['slider_id']; ?>&slider_type=1">On</a>
	<?php
	} else {
	?>
		<a href="?slider_id=<?php echo $result['slider_id']; ?>&slider_type=0">Off</a>
	<?php
	}
	?>
</td>

				<td>
					<a href="?slider_del=<?php echo $result['slider_id'] ?>" onclick="return confirm('Are you sure to Delete!');" >Delete</a> 
				</td>
					</tr>	
					<?php
			}
		}
					?>
			</tbody>
		</table>

       </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
