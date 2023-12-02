<?php
    function connectDB(){
        $servername = "mysql:host=localhost;dbname=project_one;charset=utf8";
        $username = "root";
        $password = "";
    
        try {
        $conn = new PDO($servername, $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
        } catch(PDOException $e) {
        echo "Lỗi kết nối: " . $e->getMessage();
        }
    }
?>