<?php
// Đường dẫn tới các file cần thiết
$fliepath = realpath(dirname(__FILE__));
include_once($fliepath . '/../classes/dashboard.php');
include_once($fliepath . '/../helpers/format.php');

// Tạo một đối tượng dashboard
$tk = new dashboard();
// Lấy dữ liệu tổng hợp theo tháng
$data = $tk->get_order_summary_by_month();
?>
<!-- Bắt đầu mã HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Thêm các link tới CSS và JS nếu cần -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'inc/header.php'; ?>
    <?php include 'inc/sidebar.php'; ?>
    <div class="grid_10">
        <div class="box round first grid">
            <h2>Dashboard</h2>
            <a href="dashboard.php" style="margin-right:20px;">Tất cả các ngày </a>
 <a href="loctheothang.php" style="margin-right:20px;">Tất cả các tháng </a>
       <a href="loctheonam.php">Tất cả các năm</a>
            <!-- Biểu đồ -->
            <div class="chart-container" style="position: relative; height:60vh; width:80vw">
                <canvas id="myChart"></canvas>
            </div>
            <!-- Bảng dữ liệu -->
            <div>
                <table class="data display datatable" id="example">
                    <thead>
                        <tr>
                            <th>Tháng/Năm</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($data): ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?php echo $row['month_year']; ?></td>
                                <td><?php echo number_format($row['subtotal'], 0); ?> VND</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">Không tìm thấy dữ liệu hoặc có lỗi xảy ra.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include 'inc/footer.php'; ?>

    <!-- Phần script để xử lý DataTables và Chart.js -->
    <script type="text/javascript">
        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
            setSidebarHeight();
        });

        var rawData = <?php echo json_encode($data); ?>;

        var labels = rawData.map(function(item) {
            return item.month_year;
        });

        var subtotals = rawData.map(function(item) {
            return item.subtotal;
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // Chuyển đổi từ 'line' sang 'bar' nếu bạn muốn biểu đồ cột
            data: {
                labels: labels, // Labels được lấy từ dữ liệu PHP
                datasets: [{
                    label: 'Subtotal qua các tháng',
                    data: subtotals,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
