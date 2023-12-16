<?php 
    function selectProductAll($sql) {
        try {
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

    function selectProduct($sql) {
        try {
            $conn = connectDB();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $query = $stmt->fetch(PDO::FETCH_ASSOC);

            return $query;
    
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function cudProduct($sql) {
        try {
            $conn = connectDB();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return true;
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            return false;
        }

    }

    function cudPro($sql, &$lastInsertId) {
        try {
            $conn = connectDB();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $lastInsertId = $conn->lastInsertId();
    
            return true;
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            return false;
        }
    }
?>