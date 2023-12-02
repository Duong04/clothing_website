<?php
require "../../config/connectDB.php";
require "../../model/dao-users.php";
require "../../model/dao-products.php";
require "../../model/dao-categories.php";
require "../../model/dao-comment.php";
require "../../model/dao-blogs.php";
session_start();

if (isset($_GET['comment_id'])) {
    if (isset($_GET['idR'])) {
        $query = cudComments('DELETE FROM comment_reply WHERE id = '. $_GET['idR']);
        if ($query) {
            header ('location: ../pages/productDetail.php?product_id='.$_GET['product_id']);
        }
    }else {
        $query = cudComments('DELETE FROM comments WHERE comment_id = '. $_GET['comment_id']);
        if ($query) {
            header ('location: ../pages/productDetail.php?product_id='.$_GET['product_id']);
        }
    }
}

?>