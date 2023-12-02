<?php 
function statisticalProduct() {
    try {
        $sql = "SELECT c.category_name, COUNT(*) AS quantity
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        GROUP BY p.category_id;";
        $conn = connectDB(); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
      
        // Lấy kết quả trả về dưới dạng một mảng liên kết
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function statisticalOrder() {
    $sql = "SELECT COUNT(*) AS total_order FROM invoices WHERE order_status != 'Hủy đơn hàng'";
    return selectInvoice($sql);
}

function statisticalOrder_2() {
    $sql = "SELECT COUNT(*) AS total_order FROM invoices WHERE order_status = 'Chờ xác nhận'";
    return selectInvoice($sql);
}

function statisticalOrder_3() {
    $sql = "SELECT COUNT(*) AS total_order FROM invoices WHERE order_status = 'Đang vận chuyển'";
    return selectInvoice($sql);
}

function statisticalOrder_4() {
    $sql = "SELECT COUNT(*) AS total_order FROM invoices WHERE order_status = 'Hoàn tất đơn hàng'";
    return selectInvoice($sql);
}
?>