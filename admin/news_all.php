<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/sanpham.php';?>
<?php include_once '../helpers/format.php';?>
<?php 
		$news = new sanpham();
		$fm = new Format();
if(isset($_GET['id']) ){
	$id = $_GET['id'];
	$del_news= $news-> xoa_news($id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách tin tức</h2>
        <div class="block">  
			<?php
			if(isset($del_news)){
				echo $del_news;
			}
			
			?>
            <table class="data display datatable" id="example">
			<thead>
				<tr>
				<th>ID</th>
				<th>Tiêu đề</th>
				<th>hình ảnh</th>
				<th>nội dung</th>
				<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$news_list = $news->show_news();
				if($news_list){
					while($result = $news_list->fetch_assoc()){
				?>
				<tr class="odd gradeX">
					<td><?php echo $result['id'] ?></td>
					<td><?php echo $result['tieu_de'] ?></td>
					<td><img src="upload/<?php echo $result['image'] ?>" width="40px" height="40px"></td>
					<td><?php echo $result['content'] ?></td>
					<td><a href="news_edit.php?id=<?php echo $result['id'] ?>">Edit</a> || <a onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="?id=<?php echo $result['id'] ?>">Delete</a></td>
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
