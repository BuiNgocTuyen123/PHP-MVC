<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
$fliepath = realpath(dirname(__FILE__));
include_once ($fliepath . '/../classes/cart.php');
include_once ($fliepath . '/../helpers/format.php');
?>

<?php
$ct = new cart();
if (isset ($_GET['placed_id'])) {
	$id = $_GET['placed_id'];
	$time = $_GET['time'];
	$shifted = $ct->shifted($id, $time);
}
?>
<div class="grid_10">
	<div class="box round first grid">
		<h2>Inbox</h2>
		<div class="block">
			<?php
			if (isset ($shifted)) {
				echo $shifted;
			}
			?>
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>STT</th>
						<th>Order time</th>
						<th>user_name</th>
						<th>View order</th>
						<th>Action</th>

					</tr>
				</thead>
				<tbody>
					<?php
					$ct = new cart();
					$fm = new Format();
					$get_inbox_cart = $ct->get_inbox_cart();
					if ($get_inbox_cart) {
						$i = 0;
						while ($result = $get_inbox_cart->fetch_assoc()) {
							$i++;
							?>
							<tr class="odd gradeX">
								<td>
									<?php echo $i; ?>
								</td>
								<td>
									<?php echo $fm->formatDate($result['date_placed']); ?>
								</td>
								<td>
									<?php echo $result['user_name']; ?>
								</td>
								<td>
								<a href="customer.php?customerid=<?php echo $result['user_id']; ?>&order_code=<?php echo $result['order_code']; ?>">View Order</a>
								</td>

								<td>
									<?php
									switch ($result['status']) {
										case 0:
											echo "<a href='?placed_id={$result['placed_id']}&time={$result['date_placed']}&status=1&user_id={$result['user_id']}&email={$result['user_email']}' style='background-color: #aaffd4'>Chờ xử lý</a>";
											break;
										case 1:
											echo "<a href='?placed_id={$result['placed_id']}&time={$result['date_placed']}&status=2&user_id={$result['user_id']}&email={$result['user_email']}' style='background-color: #aad4ff'>Đã xử lý</a>";
											break;
										case 2:
											echo "<a href='?placed_id={$result['placed_id']}&time={$result['date_placed']}&status=6&user_id={$result['user_id']}&email={$result['user_email']}' style='background-color: #ffaaff'>đã giao hàng</a>";
											break;
										case 3:
											echo "<a href='?placed_id={$result['placed_id']}&time={$result['date_placed']}&status=4&user_id={$result['user_id']}&email={$result['user_email']}' style='background-color: yellow'>đã hủy</a>";
											break;
										case 4:
											// Chỉ thêm sự kiện onclick cho trạng thái 4
											echo "<a href='?placed_id={$result['placed_id']}&time={$result['date_placed']}&confirm=yes' onclick='return confirm(\"Bạn có chắc chắn muốn xoá thông tin order này không?\");' style='background-color: #ffaaaa'>Xoá</a>";
											break;
										case 6:
											// Chỉ thêm sự kiện onclick cho trạng thái 4
											echo "<a href='?placed_id={$result['placed_id']}&time={$result['date_placed']}&confirm=yes' onclick='return confirm(\"Bạn có chắc chắn muốn xoá thông tin order này không?\");' style='background-color: #ffaaaa'>Xoá</a>";
											break;
									}
									?>
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
<?php include 'inc/footer.php'; ?>