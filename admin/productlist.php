<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/menucha.php';?>
<?php include '../classes/thuonghieu.php';?>
<?php include '../classes/sanpham.php';?>
<?php include_once '../helpers/format.php';?>
<?php 
		$sp = new sanpham();
		$fm = new Format();
if(isset($_GET['sanpham_ID']) ){
	$id = $_GET['sanpham_ID'];
	$delsp= $sp-> xoa_sanpham($id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Product List</h2>
        <div class="block">  
			<?php
			if(isset($delsp)){
				echo $delsp;
			}
			
			?>
            <table class="data display datatable" id="example">
			<thead>
				<tr>
				<th>ID</th>
				<th>Tên sản phẩm</th>
				<th>Danh mục</th>
				<th>Thương hiệu</th>
					<th>Giá gốc</th>
					<th>Thông tin chi tiết</th>
					<th>loại</th>
					<th>giá</th>
					<th>hình ảnh</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$splist = $sp->show_sanpham();
				if($splist){
					$i =0;
					while($result = $splist->fetch_assoc()){
						$i++;
				?>
				<tr class="odd gradeX">
					<td><?php echo $i ?></td>
					<td><?php echo $result['sanpham_Name'] ?></td>
					<td><?php echo $result['menucon_Name'] ?></td>
					<td><?php echo $result['brand_Name'] ?></td>
					<td><?php echo $fm->textShorten($result['giagoc'],50) ?></td>
					<td><?php echo $fm->textShorten($result['ttsanpham'],200) ?></td>
					<td><?php
					if($result['type'] == 0){
					echo 'Feathered';
					}
					else{
					echo 'non-Feathered';
					}
					?>
					</td>
					<td><?php echo $result['price'] ?>VNĐ</td>
					<td><img src="upload/<?php echo $result['image'] ?>" width="40px" height="40px"></td>
					<td><a href="sanphamedit.php?sanpham_ID=<?php echo $result['sanpham_ID'] ?>">Edit</a> || <a onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="?sanpham_ID=<?php echo $result['sanpham_ID'] ?>">Delete</a></td>
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
