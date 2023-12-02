<?php 
    require "../../config/connectDB.php";
    require "../../model/dao-users.php";
    if(isset($_GET['token'])){
        $token = $_GET['token'];
        $sql = "UPDATE users SET status = 'Đã kích hoạt' WHERE token = '$token'"; 
        $query = cudUsers($sql);
        if($query){
            $updateToken = cudUsers("UPDATE users SET token = 0 WHERE token = '$token'");
            if ($updateToken) {
                header('Location: login.php');
            }
        }
    }
?>