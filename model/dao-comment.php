<?php 
    function selectCommentAll($sql) {
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

    function selectComment($sql) {
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

    function cudComment($sql, &$lastInsertId) {
        try {
            $conn = connectDB();

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

    function cudComments($sql) {
        try {
            $conn = connectDB();

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $stmt = $conn->prepare($sql);
            $stmt->execute();
    
            return true;
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            return false;
        }
    }
?>