<?php
$fliepath = realpath(dirname(__FILE__));
include_once ($fliepath.'/../classes/dashboard.php');
include_once ($fliepath.'/../helpers/format.php');

$tk = new dashboard();
$data = $tk->get_order_summary_by_year();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter by Year</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Đảm bảo rằng các link tới CSS và JavaScript của DataTables cũng được thêm vào đây -->
</head>
<body>
    <?php include 'inc/header.php'; ?>
    <?php include 'inc/sidebar.php'; ?>
    <div class="grid_10">
        <div class="box round first grid">
            <h2>Filter by Year</h2>
            <a href="dashboard.php" style="margin-right:20px;">Tất cả các ngày </a>
 <a href="loctheothang.php" style="margin-right:20px;">Tất cả các tháng </a>
       <a href="loctheonam.php">Tất cả các năm</a>
            <div class="block">
            <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                <canvas id="myChart"></canvas>
            </div>
                <!-- Bảng dữ liệu tổng hợp theo năm -->
                <table class="data display datatable" id="example">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data): ?>
                            <?php foreach ($data as $row): ?>
                                <tr>
                                    <td><?php echo $row['year']; ?></td>
                                    <td><?php echo number_format($row['subtotal'], 0); ?> VND</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No data found or an error occurred.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Biểu đồ tổng hợp theo năm -->

        </div>
    </div>
    <?php include 'inc/footer.php'; ?>

    <script type="text/javascript">
        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
            setSidebarHeight();
        });

        var rawData = <?php echo json_encode($data); ?>;
        var labels = rawData.map(function(item) {
            return item.year;
        });
        var subtotals = rawData.map(function(item) {
            return item.subtotal;
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // Dùng biểu đồ cột để hiển thị dữ liệu
            data: {
                labels: labels,
                datasets: [{
                    label: 'Subtotal by Year',
                    data: subtotals,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
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
