<?php
$fliepath = realpath(dirname(__FILE__));
include_once ($fliepath . '/../classes/dashboard.php');
include_once ($fliepath . '/../helpers/format.php');

$tk = new dashboard();
$data = $tk->get_order_code_type_2();
?>
<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Dashboard</h2>
        <table class="data display datatable" id="example">
            <thead>
                <tr>
                    <th>Order Code</th>
                    <th>Date Placed</th>
                    <th>sub toltal</th>
                    <!-- Bạn có thể thêm các tiêu đề cột khác tùy thuộc vào cấu trúc của bảng 'tbl_order' -->
                </tr>
            </thead>
            <tbody>
    <?php if ($data): ?>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo $row['order_code']; ?></td>
                <td><?php echo date("d-m-Y", strtotime($row['date_placed'])); ?></td>
                <!-- Định dạng số để bỏ 2 số 00 sau cùng và thêm đơn vị tiền tệ -->
                <td><?php echo number_format($row['subtotal'], 0); ?> VND</td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">Không tìm thấy dữ liệu hoặc có lỗi xảy ra.</td>
        </tr>
    <?php endif; ?>
</tbody>
<a href="dashboard.php" style="margin-right:20px;">Tất cả các ngày </a>
 <a href="loctheothang.php" style="margin-right:20px;">Tất cả các tháng </a>
       <a href="loctheonam.php">Tất cả các năm</a>

<div class="chart-container" style="position: relative; height:40vh; width:80vw">
    <canvas id="myChart"></canvas>
</div>


        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<script>
    var rawData = <?php echo json_encode($data); ?>;
    rawData.sort(function(a, b) {
        return new Date(a.date_placed) - new Date(b.date_placed);
    });
    
    var labels = rawData.map(function(item) {
        return new Date(item.date_placed).toLocaleDateString();
    });
    
    var subtotals = rawData.map(function(item) {
        return item.subtotal;
    });
    var labels = [];
    var subtotals = [];

    rawData.forEach(function(item) {
        labels.push(item.date_placed);
        subtotals.push(item.subtotal);
    });
</script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels, // Sử dụng dữ liệu từ PHP
            datasets: [{
                label: 'Subtotal qua các ngày',
                data: subtotals, 
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            x: {
                    type: 'time',
                    time: {
                        // Định dạng để chỉ hiển thị ngày, tháng, năm
                        tooltipFormat: 'DD/MM/YYYY',
                        displayFormats: {
                            day: 'DD/MM/YYYY'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Ngày'
                    },
                    ticks: {
                        // Đảo ngược trục để thời gian xa nhất nằm bên phải
                        reverse: true
                    }
                },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


<?php include 'inc/footer.php'; ?>