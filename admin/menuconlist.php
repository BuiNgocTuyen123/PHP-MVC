<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/menucha.php' ?>
<?php
$menucon = new menucha();
if(isset($_GET['delid']) ){
	$id = $_GET['delid'];
	$delmenucon = $menucon-> xoa_menucon($id);
}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Danh sách menu con</h2>
                <div class="block">      
					<?php
				if(isset($delmenucon)){
                    echo $delmenucon;
                }  
				?>
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên menu con</th>
                            <th>Tên menu cha</th>
							<th>cài đặt</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$show_menucon = $menucon->show_menucon();
						if($show_menucon){
							$i = 0;
							while($result_con = $show_menucon->fetch_assoc()){
								
								$i++;							
						?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $result_con ['menucon_Name']  ?></td>
                            <td><?php echo $result_con ['menucha_Name']  ?></td>
							<td><a href="menuconedit.php?menucon_ID=<?php echo $result_con['menucon_ID']?>">Edit</a> || <a onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="?delid=<?php echo $result['menucon_ID'] ?>">Delete</a></td>
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

