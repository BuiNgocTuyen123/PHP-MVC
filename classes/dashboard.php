<?php
$fliepath = realpath(dirname(__FILE__));
include_once ($fliepath.'/../lib/database.php');
include_once ($fliepath.'/../helpers/format.php');

?>
<?php
class dashboard {
    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function get_order_code_type_2(){
        $query = "SELECT o.order_code, p.date_placed, SUM(o.price * o.quanly) AS subtotal
                  FROM tbl_order AS o 
                  INNER JOIN tbl_placed AS p ON o.order_code = p.order_code 
                  WHERE p.status = 2 OR p.status = 7
                  GROUP BY o.order_code, p.date_placed";
        $result = $this->db->select($query);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false; // Trả về false nếu không có dữ liệu hoặc truy vấn không thành công
        }
    }
    public function get_order_summary_by_month() {
        $query = "SELECT DATE_FORMAT(p.date_placed, '%Y-%m') AS month_year, SUM(o.price * o.quanly) AS subtotal
                  FROM tbl_order AS o
                  INNER JOIN tbl_placed AS p ON o.order_code = p.order_code
                  GROUP BY month_year
                  ORDER BY month_year ASC"; // Sắp xếp kết quả theo tháng/năm tăng dần
        $result = $this->db->select($query);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false; // Trả về false nếu không có dữ liệu hoặc truy vấn không thành công
        }
    }
    public function get_order_summary_by_year() {
        $query = "SELECT DATE_FORMAT(p.date_placed, '%Y') AS year, SUM(o.price * o.quanly) AS subtotal
                  FROM tbl_order AS o
                  INNER JOIN tbl_placed AS p ON o.order_code = p.order_code
                  GROUP BY year
                  ORDER BY year ASC"; // Sắp xếp kết quả theo năm tăng dần
        $result = $this->db->select($query);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false; // Trả về false nếu không có dữ liệu hoặc truy vấn không thành công
        }
    }
    
    
    public function get_order_filtered($filterType, $value) {
        $query = "";
        // Chuyển đổi định dạng giá trị dựa vào filterType
        switch ($filterType) {
            case 'day':
                // Lọc theo ngày cụ thể
                $query = "SELECT o.order_code, p.date_placed, SUM(o.price * o.quanly) AS subtotal
                          FROM tbl_order AS o
                          INNER JOIN tbl_placed AS p ON o.order_code = p.order_code
                          WHERE DATE(p.date_placed) = '{$value}'
                          GROUP BY o.order_code, p.date_placed";
                break;
            case 'month':
                // Lọc theo tháng và năm
                $date = explode('-', $value); // giả sử value là 'YYYY-MM'
                $query = "SELECT o.order_code, p.date_placed, SUM(o.price * o.quanly) AS subtotal
                          FROM tbl_order AS o
                          INNER JOIN tbl_placed AS p ON o.order_code = p.order_code
                          WHERE YEAR(p.date_placed) = {$date[0]} AND MONTH(p.date_placed) = {$date[1]}
                          GROUP BY o.order_code, p.date_placed";
                break;
            case 'year':
                // Lọc theo năm
                $query = "SELECT o.order_code, p.date_placed, SUM(o.price * o.quanly) AS subtotal
                          FROM tbl_order AS o
                          INNER JOIN tbl_placed AS p ON o.order_code = p.order_code
                          WHERE YEAR(p.date_placed) = {$value}
                          GROUP BY o.order_code, p.date_placed";
                break;
        }
        $result = $this->db->select($query);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false; // Trả về false nếu không có dữ liệu hoặc truy vấn không thành công
        }
    }
    
    
    
    
}

?>

