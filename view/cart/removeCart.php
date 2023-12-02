<?php 
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Tìm vị trí sản phẩm trong giỏ hàng và xóa nó
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
    }
}

header("Location: cart.php"); // Chuyển người dùng trở lại trang giỏ hàng
 
?>