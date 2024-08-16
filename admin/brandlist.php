<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/thuonghieu.php' ?>
<?php
$brand = new thuonghieu();
if(isset($_GET['delid']) ){
	$id = $_GET['delid'];
	$delbrand= $brand-> xoa_thuonghieu($id);
}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>brandegory List</h2>
                <div class="block">      
					<?php
				if(isset($delbrand)){
                    echo $delbrand;
                }  
				?>
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>brandegory Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$show_thuonghieu= $brand->show_thuonghieu();
						if($show_thuonghieu){
							$i = 0;
							while($result = $show_thuonghieu->fetch_assoc()){
								
								$i++;
							
						
						
						
						?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $result ['brand_Name']  ?></td>
							<td><a href="brandedit.php?brand_ID=<?php echo $result['brand_ID']?>">Edit</a> || <a onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="?delid=<?php echo $result['brand_ID'] ?>">Delete</a></td>
						</tr>
						<?php
							}}
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

