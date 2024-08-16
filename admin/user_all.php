<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include_once '../helpers/format.php';?>
<?php include '../classes/user.php' ?>
<?php 
		$user = new user();
if(isset($_GET['user_id']) ){
	$id = $_GET['user_ID'];
	$delus = $user-> xoa_user($id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách tất cả người dùng</h2>
        <div class="block">  
			<?php
			if(isset($delus)){
				echo $delus;
			}
			
			?>
            <table class="data display datatable" id="example">
			<thead>
				<tr>
				<th>ID</th>
				<th>Tên người dùng</th>
				<th>password</th>
				<th>email</th>
					<th>Số điện thoại</th>
					<th>Địa chỉ</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$uslist = $user->show_user();
				if($uslist){
					$i =0;
					while($result = $uslist->fetch_assoc()){
						$i++;
				?>
				<tr class="odd gradeX">
					<td><?php echo $i ?></td>
					<td><?php echo $result['user_name'] ?></td>
					<td><?php echo $result['user_pass'] ?></td>
					<td><?php echo $result['user_email'] ?></td>
                    <td><?php echo $result['user_phone'] ?></td>
					<td><?php echo $result['address'] ?></td>
					<td><a href="user_edit.php?user_id=<?php echo $result['user_id'] ?>">Edit</a> || <a onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="?user_id=<?php echo $result['user_id'] ?>">Delete</a></td>
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
