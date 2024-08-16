<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/menucha.php' ?>
<?php
$menucha = new menucha();
if(isset($_GET['delid']) ){
	$id = $_GET['delid'];
	$delmenucha = $menucha-> xoa_menucha($id);
}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>danh sách menu cha</h2>
                <div class="block">      
					<?php
				if(isset($delmenucha)){
                    echo $delmenucha;
                }  
				?>
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Category Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$show_menucha = $menucha->show_menucha();
						if($show_menucha){
							$i = 0;
							while($result = $show_menucha->fetch_assoc()){
								
								$i++;						
						
						
						?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $result ['menucha_Name']  ?></td>
							<td><a href="menuchaedit.php?menucha_ID=<?php echo $result['menucha_ID']?>">Edit</a> || <a onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="?delid=<?php echo $result['menucha_ID'] ?>">Delete</a></td>
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
<?php include 'inc/footer.php';?>

