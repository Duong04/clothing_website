<?php 
session_start();

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['heart']) && is_array($_SESSION['heart'])) {
        foreach ($_SESSION['heart'] as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION['heart'][$key]);
                break;
            }
        }
    }
}

header("Location: heart.php");
?>