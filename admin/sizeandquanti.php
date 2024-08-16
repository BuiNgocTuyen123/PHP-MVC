<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/sanpham.php' ?>
<?php
$hangton = new sanpham();

?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Danh sách size và số lượng</h2>
                <div class="block">      
			
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên san phẩm</th>
                            <th>size</th>
							<th>số lượng còn lại</th>
                            <th>action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$show_menucon = $hangton->getProductsAndSizes();
						if($show_menucon){
							$i = 0;
							while($result_con = $show_menucon->fetch_assoc()){
								
								$i++;							
						?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $result_con ['sanpham_Name']  ?></td>
                            <td><?php echo $result_con ['size']  ?></td>
                            <td><?php if($result_con['quantity']==0){
                                ?>
                                Hết hàng
                                <?php
                            } else{
                            
                            echo $result_con ['quantity']  ?></td> <?php }?>
                            <td><a href="sanphamedit.php?sanpham_ID=<?php echo $result_con['sanpham_ID']?>">Edit</a></td>
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

