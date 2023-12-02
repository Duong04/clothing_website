<?php
require "../../config/connectDB.php";
require "../../model/dao-users.php";
require "../../model/dao-products.php";
require "../../model/dao-categories.php";
require "../../model/dao-comment.php";
require "../../model/dao-blogs.php";
session_start();


if(!empty($_POST['content'])) {
    $content = $_POST['content'];
    $product_id = $_GET['product_id'];
    $user_id  = $_SESSION['user_id'];

    cudComment("INSERT INTO comments (content, product_id, user_id, comment_date) VALUES('$content', $product_id, $user_id, NOW())",$lastInsertId);

    // Retrieve the new comment
    $comment = selectComment("SELECT * FROM comments AS C INNER JOIN users AS U ON C.user_id = U.user_id WHERE C.comment_id = $lastInsertId");

    // Check if $comment is an array before including the HTML template
    if (is_array($comment) && count($comment) > 0) {
        include '../controller/comment.php';
        exit;
    } else {
        echo "Error: Unable to retrieve the new comment.";
        exit;
    }
}else {
    echo '<script>
        Swal.fire({
            title: "Lỗi!",
            text: "Bạn cần phải nhập mới có thể gửi được!",
            icon: "error",
            timer: 5000
        });
        </script>';
}



?>