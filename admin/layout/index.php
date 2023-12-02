<?php 
    require "../../config/connectDB.php";
    require "../../model/dao-users.php";
    require "../../model/dao-blogs.php";
    require "../../model/dao-categories.php";
    require "../../model/dao-products.php";
    require "../../model/dao-comment.php";
    require "../../model/dao-statistical.php";
    require "../../model/dao-invoice.php";
    session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <title>Admin</title>
</head>
<body>
    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Nhân viên') { ?>
    <main>
        <div class="nav-des">
            <div class="nav-des-left">
                <a class="nav-link active" aria-current="page" href="../../view/pages/home.php"><img src="../../assets/img/logo.png" alt=""></a>
            </div>
            <div class="nav-des-right">
                <div class="language"><img src="../../assets/img/flag-vie2.webp" alt=""></div>
                <?php 
                if (isset($_SESSION['user_id'])) {
                    $id = $_SESSION['user_id'];
                    $row = selectUsers("SELECT * FROM users WHERE user_id = $id");    
                    $img = '../../assets/img/143086968_2856368904622192_1959732218791162458_n.png';
                    $image = $row['user_image'] != null ? $row['user_image'] : $img;
                ?>
                <div class='user-img'><a href="../../view/accounts/user-account.php"><img src="<?=$image?>" alt=""></a></div>
                <?php } ?>
            </div>
        </div>
        <div class="containerq">
            <div class="menu">
                <?php include 'menu.php'; ?>
                <div class="btn-logout">
                    <a href="../../view/accounts/logout.php">Đăng xuất &nbsp;<i class="fa-solid fa-right-from-bracket"></i></a>
                </div>
            </div>
            <div class="content">
                <?php 
                if (isset($_GET['action'])) {
                    $act = $_GET['action'];
                    switch ($act) {
                        // --------------------- statistical ------------------
                        case 'statistical':
                            include '../statistical/statistical.php';
                            break;
                        // -------------------- Product ----------------------
                        case 'products':
                            $sql = "SELECT P.*, C.*, U.*, P.create_date as product_create_date
                            FROM products as P
                            INNER JOIN users as U ON P.user_id = U.user_id
                            INNER JOIN categories as C ON P.category_id = C.category_id WHERE 1";
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['filter'])) {
                                    $idC = $_POST['category_id'];
                                    $data = trim($_POST['search']);
                                    $price = $_POST['price'];
                                    if ($data != '') {
                                        $sql .= " AND P.product_name LIKE '%$data%' OR C.category_name LIKE '%$data%'";
                                    }
                                    if ($idC > 0) {
                                        $sql .= " AND C.category_id = $idC";
                                    }

                                    if ($price > 0) {
                                        $sql .= " AND P.price > 0 ";
                                        
                                        switch ($price) {
                                            case 100000:
                                                $sql .= "AND P.price <= 100000";
                                                break;
                                            case 200000:
                                                $sql .= "AND P.price > 100000 AND P.price <= 200000";
                                                break;
                                            case 300000:
                                                $sql .= "AND P.price > 200000 AND P.price <= 300000";
                                                break;
                                            case 400000:
                                                $sql .= "AND P.price > 300000 AND P.price <= 400000";
                                                break;
                                            case 500000:
                                                $sql .= "AND P.price > 400000";
                                                break;
                                        }
                                    }

                                    if ($_POST["filter-2"] == 'nameAsc') {
                                        $sql .= " ORDER BY P.product_name ASC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'nameDesc') {
                                        $sql .= " ORDER BY P.product_name DESC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'productOld') {
                                        $sql .= " ORDER BY P.create_date ASC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'productNew') {
                                        $sql .= " ORDER BY P.create_date DESC";
                                    }
                                }
                            }
                            $result = selectProductAll($sql);
                            include '../products/list.php';
                            break;
                        case 'add-product':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['add'])) {
                                    if(isset($_SESSION['user_id'])) {
                                        $id = $_SESSION['user_id'];
                                    }
                                    $product_name = $_POST['product_name'];
                                    $price = $_POST['price'];
                                    $sale = $_POST['sale'];
                                    $quantity = $_POST['quantity'];
                                    $category_id = $_POST['category'];
                                    $description = $_POST['description'];
                                    $target_dir = '../../upload_img/';
                                    $target_file = $target_dir . basename($_FILES['image_product']['name']);
                                    move_uploaded_file($_FILES['image_product']['tmp_name'], $target_file);
                                    $files = $_FILES['images'];
                                    $filesNames = $files['name'];

                                    
                                    // Kiểm tra xem $filesNames có phải là mảng
                                    if (is_array($filesNames)) {
                                        $sql = "INSERT INTO products (product_name, product_image, price, sale, quantity_product, category_id, description, user_id, create_date)
                                                VALUES ('$product_name', '$target_file', $price, $sale, $quantity, $category_id, '$description', $id, NOW())";
                            
                                        $result = cudPro($sql, $lastInsertId);
                            
                                        if ($result) {
                                            foreach ($filesNames as $key => $value) {
                                                $target_file2 = $target_dir . basename($value);
                                                move_uploaded_file($files['tmp_name'][$key], $target_file2);
                                                $query = cudProduct("INSERT INTO library_image (product_id, image) VALUES ($lastInsertId, '$target_file2')");
                                                if ($query) {
                                                    echo '<script>
                                                            Swal.fire({
                                                                title: "Thành công!",
                                                                text: "Thêm sản phẩm thành công!",
                                                                icon: "success",
                                                                timer: 1000
                                                            });
                                                        </script>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            include '../products/add.php';
                            break;
                        case 'delete-product':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $result = cudProduct("DELETE FROM products WHERE product_id = $id");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Xóa sản phẩm thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }
                            }
                            $sql = "SELECT P.*, C.*, U.*, P.create_date as product_create_date
                            FROM products as P
                            INNER JOIN users as U ON P.user_id = U.user_id
                            INNER JOIN categories as C ON P.category_id = C.category_id";
                            $result = selectProductAll($sql);
                            include '../products/list.php';
                            break;
                        case 'update-product':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                            }
                            $sql = "SELECT P.*, C.*, U.*, P.create_date as product_create_date
                            FROM products as P
                            INNER JOIN users as U ON P.user_id = U.user_id
                            INNER JOIN categories as C ON P.category_id = C.category_id
                            WHERE P.product_id = $id";
                            $row = selectProduct($sql);
                            $row2 = selectProductAll("SELECT * FROM library_image WHERE product_id = $id");
                            include '../products/update.php';
                            break;
                        case 'handle-productC':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if(isset($_SESSION['user_id'])) {
                                    $user_id = $_SESSION['user_id'];
                                }
                                if (isset($_POST['update'])) {
                                    $id = $_POST['id'];
                                    $product_name = $_POST['product_name'];
                                    $price = $_POST['price'];
                                    $sale = $_POST['sale'];
                                    $quantity = $_POST['quantity'];
                                    $category_id = $_POST['category'];
                                    $description = $_POST['description'];
                                    $files = $_FILES['images'];
                                    $filesNames = $files['name'];
                                    if (is_uploaded_file($_FILES['image_product']['tmp_name'])) {
                                        $target_dir = '../../upload_img/';
                                        $target_file = $target_dir . basename($_FILES['image_product']['name']);
                                        move_uploaded_file($_FILES['image_product']['tmp_name'], $target_file);
                                        $sql = "UPDATE products SET product_name = '$product_name', price = $price, sale = $sale , quantity_product = $quantity, category_id = $category_id, user_id = $user_id, description = '$description', create_date = NOW(), product_image = '$target_file' WHERE product_id = $id";
                                        $query = cudProduct($sql);
                                        foreach ($filesNames as $key => $value){
                                            $tmpName = $files['tmp_name'][$key];
                                    
                                            if (is_uploaded_file($tmpName)) {
                                                $target_file2 = $target_dir . basename($value);
                                                move_uploaded_file($tmpName, $target_file2);
                                    
                                                $existingImage = selectUsersAll("SELECT image FROM library_image WHERE product_id = $id AND image = '$target_file2'");
                                    
                                                if ($existingImage == null) {
                                                    cudProduct("INSERT INTO library_image (product_id, image) VALUES ($id, '$target_file2')");
                                                }
                                            } 
                                        }
                                    } else {
                                        $sql = "UPDATE products SET product_name = '$product_name', price = $price, sale = $sale , quantity_product = $quantity, category_id = $category_id, user_id = $user_id, description = '$description', create_date = NOW() WHERE product_id = $id";
                                        $query = cudProduct($sql);
                                        foreach ($filesNames as $key => $value) {
                                            $target_dir = '../../upload_img/';
                                            $tmpName = $files['tmp_name'][$key];
                                    
                                            if (is_uploaded_file($tmpName)) {
                                                $target_file2 = $target_dir . basename($value);
                                                move_uploaded_file($tmpName, $target_file2);
                                    
                                                $existingImage = selectUsersAll("SELECT image FROM library_image WHERE product_id = $id AND image = '$target_file2'");
                                    
                                                if ($existingImage == null) {
                                                    cudProduct("INSERT INTO library_image (product_id, image) VALUES ($id, '$target_file2')");
                                                }
                                            } 
                                        }
                                    }
                                }
                            }
                            $sql = "SELECT P.*, C.*, U.*, P.create_date as product_create_date
                            FROM products as P
                            INNER JOIN users as U ON P.user_id = U.user_id
                            INNER JOIN categories as C ON P.category_id = C.category_id";
                            $result = selectProductAll($sql);
                            include '../products/list.php';
                            echo '<script>
                                        Swal.fire({
                                        title: "Thành công!",
                                        text: "Cập nhật sản phẩm thành công!",
                                        icon: "success",
                                        timer: 1000
                                        });
                                    </script>';
                            break;
                        // ------------------------------- Library image ----------------------------
                        case 'library-images':
                            $sql = "SELECT * FROM products as P INNER JOIN users as U ON P.user_id = U.user_id WHERE 1";
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['submit'])) {
                                    $data = trim($_POST['search']);
                                    if ($data != '') {
                                        $sql .= " AND (P.product_name like '%$data%' OR U.user_name like '%$data%')";
                                    }

                                    if ($_POST["filter-2"] == 'nameAsc') {
                                        $sql .= " ORDER BY P.product_name ASC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'nameDesc') {
                                        $sql .= " ORDER BY P.product_name DESC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'productOld') {
                                        $sql .= " ORDER BY P.create_date ASC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'productNew') {
                                        $sql .= " ORDER BY P.create_date DESC";
                                    }
                                }
                            }
                            $result = selectProductAll($sql);
                            include '../library-images/list.php';
                            break;
                        case 'list-detail':
                            if (isset($_GET['idP'])) {
                                $idP = $_GET['idP'];
                                $sql = "SELECT * FROM library_image as L INNER JOIN products as P ON L.product_id = P.product_id WHERE P.product_id = $idP";
                                $result = selectProductAll($sql);
                            } 
                            include '../library-images/list-detail.php';
                            break;
                        case 'add-image':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['add'])) {
                                    if (isset($_GET['idP'])) {
                                        $idP = $_GET['idP'];
                                        $target_dir = '../../upload_img/';
                                        $files = $_FILES['images'];
                                        $filesNames = $files['name'];
                                        foreach ($filesNames as $key => $value) {
                                            $target_file = $target_dir . basename($value);
                                            move_uploaded_file($files['tmp_name'][$key], $target_file);
                                            $existingImage = selectUsersAll("SELECT image FROM library_image WHERE product_id = $idP AND image = '$target_file'");
                                    
                                                if ($existingImage == null) {
                                                    $query = cudProduct("INSERT INTO library_image (product_id, image) VALUES ($idP, '$target_file')");
                                                    if ($query) {
                                                        echo '<script>
                                                                Swal.fire({
                                                                    title: "Thành công!",
                                                                    text: "Thêm ảnh thành công!",
                                                                    icon: "success",
                                                                    timer: 1000
                                                                });
                                                            </script>';
                                                    }
                                                }
                                        }
                                    }
                                }
                            }
                            include '../library-images/add.php';
                            break;
                        case 'delete-image':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $query = cudProduct("DELETE FROM library_image WHERE image_id = $id");
                                if ($query) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Xóa ảnh thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }
                            }
                            if (isset($_GET['idP'])) {
                                $idP = $_GET['idP'];
                            }
                            
                            $result = selectProductAll("SELECT * FROM library_image as L INNER JOIN products as P ON L.product_id = P.product_id WHERE L.product_id = $idP");
                            include '../library-images/list-detail.php';
                            break;
                        case 'update-image':
                            if ($_GET['id']) {
                                $id = $_GET['id'];
                                $row = selectProduct("SELECT * FROM library_image WHERE image_id = $id");
                            }
                            include '../library-images/update.php';
                            break;
                        case 'handle-image':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['update'])) {
                                    $id = $_POST['id'];
                                    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                                        $target_dir = '../../upload_img/';
                                        $target_file = $target_dir . basename($_FILES['image']['name']);
                                        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                                        $sql = "UPDATE library_image SET image = '$target_file' WHERE image_id = $id";         
                                        cudProduct($sql);                  }
                                }
                            }
                            
                            if (isset($_GET['idP'])) {
                                $idP = $_GET['idP'];
                            }
                            
                            $result = selectProductAll("SELECT * FROM library_image as L INNER JOIN products as P ON L.product_id = P.product_id WHERE L.product_id = $idP");
                            
                            include '../library-images/list-detail.php';
                            echo '<script>
                                        Swal.fire({
                                        title: "Thành công!",
                                        text: "Cập nhật ảnh thành công!",
                                        icon: "success",
                                        timer: 1000
                                        });
                                    </script>';
                            break;
                        // --------------------------------- Categories ---------------------------------
                        case 'categories':
                            $sql = "SELECT C.*, U.*, C.create_date as category_create_date
                            FROM categories as C
                            INNER JOIN users as U ON C.user_id = U.user_id where 1";
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['submit'])) {
                                    $data = trim($_POST['search']);
                                    if ($data != '') {
                                        $sql .= " AND (C.category_name LIKE '%$data%' OR U.user_name LIKE '%$data%')";
                                    }
                                }

                                if ($_POST["filter-2"] == 'nameAsc') {
                                    $sql .= " ORDER BY C.category_name ASC";
                                }
                        
                                if ($_POST["filter-2"] == 'nameDesc') {
                                    $sql .= " ORDER BY C.category_name DESC";
                                }
                        
                                if ($_POST["filter-2"] == 'old') {
                                    $sql .= " ORDER BY C.create_date ASC";
                                }
                        
                                if ($_POST["filter-2"] == 'new') {
                                    $sql .= " ORDER BY C.create_date DESC";
                                }

                            }
                            $result = selectCategoryAll($sql);
                            include '../categories/list.php';
                            break;
                        case 'add-category':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['add'])) {
                                    if(isset($_SESSION['user_id'])) {
                                        $id = $_SESSION['user_id'];
                                    }
                                    $category_name = $_POST['category_name'];
                                    $sql = "INSERT INTO categories(category_name, create_date, user_id) 
                                            VALUES('$category_name',NOW(), $id)";
                                    $query = cudCategory($sql);
                                    if ($query){
                                        echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Thêm danh mục thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>  ';
                                    }
                                }
                            }
                            include '../categories/add.php';
                            break;
                        case 'update-category':
                            if(isset($_GET['id'])) {
                                $id = $_GET['id'];
                            }
                            $row = selectCategory("SELECT * FROM  categories WHERE category_id = $id");
                            include '../categories/update.php';
                            break;
                        case 'handle-updateC':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['update'])) {
                                    if (isset($_SESSION['user_id'])) {
                                        $user_id = $_SESSION['user_id'];
                                    }
                                    $id = $_POST['id'];
                                    $category_name = $_POST['category_name'];
                                    $sql = "UPDATE categories SET category_name = '$category_name',
                                            create_date = NOW(), user_id = $user_id 
                                            WHERE category_id = $id";
                                    $query = cudCategory($sql);
                                    
                                }
                            }
                            $sql = "SELECT C.*, U.*, C.create_date as category_create_date
                            FROM categories as C
                            INNER JOIN users as U ON C.user_id = U.user_id";
                            $result = selectCategoryAll($sql);
                            include '../categories/list.php';
                            echo '<script>
                                        Swal.fire({
                                        title: "Thành công!",
                                        text: "Cập nhật danh mục thành công!",
                                        icon: "success",
                                        timer: 1000
                                        });
                                    </script>';
                            break;
                        case 'delete-category':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $result = cudCategory("Delete FROM categories WHERE category_id=$id");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Xóa danh mục thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }
                            }
                            $sql = "SELECT C.*, U.*, C.create_date as category_create_date
                            FROM categories as C
                            INNER JOIN users as U ON C.user_id = U.user_id";
                            $result = selectCategoryAll($sql);
                            include '../categories/list.php';
                            break;
                        // ------------------------------ USER ------------------------------
                        case 'users':

                            $sql = "SELECT * FROM users WHERE 1";
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['submit'])) {
                                    $data = trim($_POST['search']);
                                    if ($data != '') {
                                        $sql .= " AND (user_name LIKE '%$data%' OR email LIKE '%$data%' OR phone_number LIKE '%$data%')";
                                    }
                                }

                                if ($_POST["filter-2"] == 'nameAsc') {
                                    $sql .= " ORDER BY user_name ASC";
                                }
                        
                                if ($_POST["filter-2"] == 'nameDesc') {
                                    $sql .= " ORDER BY user_name DESC";
                                }
                        
                                if ($_POST["filter-2"] == 'old') {
                                    $sql .= " ORDER BY create_date ASC";
                                }
                        
                                if ($_POST["filter-2"] == 'new') {
                                    $sql .= " ORDER BY create_date DESC";
                                }
                            }
                            $result = selectUsersAll($sql);
                            include '../users/list.php';
                            break;
                        case 'client':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $result = cudUsers("UPDATE users SET role = 'Khách hàng' WHERE user_id = $id");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Cập nhật khách hàng thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }
                            }
                            $result = selectUsersAll("SELECT * FROM users");
                            include '../users/list.php';
                            break;
                        case 'staff':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $result = cudUsers("UPDATE users SET role = 'Nhân viên' WHERE user_id = $id");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Cập nhật nhân viên thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }
                            }
                            $result = selectUsersAll("SELECT * FROM users");
                            include '../users/list.php';
                            break;
                        case 'activated':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $result = cudUsers("UPDATE users SET status = 'Đã kích hoạt' WHERE user_id = $id");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Kích hoạt thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }
                            }
                            $result = selectUsersAll("SELECT * FROM users");
                            include '../users/list.php';
                            break;
                        case 'disable':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $result = cudUsers("UPDATE users SET status = 'Vô hiệu hóa' WHERE user_id = $id");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Tài khoản đã bị vô hiệu hóa!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }
                            }
                            $result = selectUsersAll("SELECT * FROM users");
                            include '../users/list.php';
                            break;
                        case 'add-user':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['add'])) {
                                    $user_name = $_POST['user_name'];
                                    $email = $_POST['email'];
                                    $psw = $_POST['psw'];
                                    $role = $_POST['role'];
                                    $status = $_POST['status'];
                                    $hashPsw = password_hash($psw, PASSWORD_DEFAULT);
                                    $result = cudUsers("INSERT INTO users (user_name, email, password, role, status, create_date)
                                                VALUES ('$user_name', '$email', '$hashPsw', '$role', '$status', NOW())");
                                    if ($result) {
                                        echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Thêm tài khoản thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                    }
                                }
                            }
                            include '../users/add.php';
                            break;
                        // --------------------------- COMMENTS ---------------
                        case 'comments':
                            $sql = "SELECT * FROM comments AS C INNER JOIN products AS P ON C.product_id = P.product_id WHERE 1";
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['submit'])) {
                                    $data = trim($_POST['search']);

                                    if ($data != "") {
                                        $sql .= " AND P.product_name like '%$data%'";
                                    }

                                    if ($_POST["filter-2"] == 'nameAsc') {
                                        $sql .= " ORDER BY P.product_name ASC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'nameDesc') {
                                        $sql .= " ORDER BY P.product_name DESC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'old') {
                                        $sql .= " ORDER BY P.product_name ASC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'new') {
                                        $sql .= " ORDER BY P.product_name DESC";
                                    }

                                }
                            }

                            $result = selectCommentAll($sql);
                            include '../comments/list.php';
                            break;
                        case 'comment-detail':
                            if (isset($_GET['idP'])) {
                                $id = $_GET['idP'];
                                $sql = "SELECT * FROM comments AS C 
                                        INNER JOIN products AS P ON C.product_id = P.product_id 
                                        INNER JOIN users AS U ON C.user_id = U.user_id
                                        WHERE P.product_id = $id";

                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    if (isset($_POST['submit'])) {
                                        $data = trim($_POST['search']);
    
                                        if ($data != "") {
                                            $sql .= " AND P.product_name like '%$data%' OR U.user_name like '%$data%'";
                                        }
    
                                        if ($_POST["filter-2"] == 'nameAsc') {
                                            $sql .= " ORDER BY U.user_name ASC";
                                        }
                                
                                        if ($_POST["filter-2"] == 'nameDesc') {
                                            $sql .= " ORDER BY U.user_name DESC";
                                        }
                                
                                        if ($_POST["filter-2"] == 'old') {
                                            $sql .= " ORDER BY C.comment_date ASC";
                                        }
                                
                                        if ($_POST["filter-2"] == 'new') {
                                            $sql .= " ORDER BY C.comment_date DESC";
                                        }
    
                                    }
                                }
                                $result = selectCommentAll($sql);
                            }
                            include '../comments/list-detail.php';
                            break;
                        case 'delete-comment':
                            if (isset($_GET['idCM'])) {
                                $idCm = $_GET['idCM'];
                                $result = cudComments("DELETE FROM comments WHERE comment_id = $idCm");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Xóa bình luận thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }                            
                            }
                            if (isset($_GET['idP'])) {
                                $id = $_GET['idP'];
                            }
                            $sql = "SELECT * FROM comments AS C 
                                        INNER JOIN products AS P ON C.product_id = P.product_id 
                                        INNER JOIN users AS U ON C.user_id = U.user_id
                                        WHERE P.product_id = $id";
                            $result = selectCommentAll($sql);
                            include '../comments/list-detail.php';
                            break;
                        case 'rep-comment':
                            if (isset($_GET['idCM'])) {
                                $idCm = $_GET['idCM'];
                                $content = $_POST['content'];
                                $user_id = $_SESSION['user_id'];
                                $result = cudComments("INSERT INTO 
                                                        comment_reply (content, user_id, comment_id, comment_date) 
                                                        VALUES ('$content', $user_id, $idCm, NOW())");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Đã trả lời bình luận!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }                            
                            }

                            if (isset($_GET['idP'])) {
                                $id = $_GET['idP'];
                            }
                            $sql = "SELECT * FROM comments AS C 
                                        INNER JOIN products AS P ON C.product_id = P.product_id 
                                        INNER JOIN users AS U ON C.user_id = U.user_id
                                        WHERE P.product_id = $id";
                            $result = selectCommentAll($sql);
                            include '../comments/list-detail.php';
                            break;
                        case 'list-rep':
                            if (isset($_GET['idCM'])) {
                                $id = $_GET['idCM'];
                                $sql = "SELECT CR.*, U.*,P.*,C.*, CR.content AS content_reply, CR.comment_date AS comment_reply_date FROM comment_reply AS CR 
                                        INNER JOIN comments AS C ON CR.comment_id = C.comment_id 
                                        INNER JOIN products AS P ON C.product_id = P.product_id
                                        INNER JOIN users AS U ON CR.user_id = U.user_id
                                        WHERE CR.comment_id = $id";
                                $result = selectCommentAll($sql);
                            }
                            include '../comments/list-rep.php';
                            break;
                        case 'delete-reply':
                            if (isset($_GET['idR'])) {
                                $idR = $_GET['idR'];
                                $result = cudComments("DELETE FROM comment_reply WHERE id = $idR");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Xóa bình luận thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }
                            }
                            if (isset($_GET['idCM'])) {
                                $id = $_GET['idCM'];
                                $sql = "SELECT CR.*, U.*,P.*,C.*, CR.content AS content_reply, CR.comment_date AS comment_reply_date FROM comment_reply AS CR 
                                        INNER JOIN comments AS C ON CR.comment_id = C.comment_id 
                                        INNER JOIN products AS P ON C.product_id = P.product_id
                                        INNER JOIN users AS U ON CR.user_id = U.user_id
                                        WHERE CR.comment_id = $id";
                                $result = selectCommentAll($sql);
                            }
                            include '../comments/list-rep.php';
                            break;
                        case 'update-reply':
                            if (isset($_GET['idR'])) {
                                $idR = $_GET['idR'];
                                $content = $_POST['content'];
                                $result = cudComments("UPDATE comment_reply SET content='$content', comment_date=NOW() WHERE id=$idR");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Cập nhật bình luận thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                }
                            }
                            if (isset($_GET['idCM'])) {
                                $id = $_GET['idCM'];
                                $sql = "SELECT CR.*, U.*,P.*,C.*, CR.content AS content_reply, CR.comment_date AS comment_reply_date FROM comment_reply AS CR 
                                        INNER JOIN comments AS C ON CR.comment_id = C.comment_id 
                                        INNER JOIN products AS P ON C.product_id = P.product_id
                                        INNER JOIN users AS U ON CR.user_id = U.user_id
                                        WHERE CR.comment_id = $id";
                                $result = selectCommentAll($sql);
                            }
                            include '../comments/list-rep.php';
                            break;
                        // ---------------------- blogs ---------------------
                        case 'blog_category':
                            $sql = "SELECT * FROM blog_category AS B INNER JOIN users AS U ON B.user_id = U.user_id WHERE 1";
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['submit'])) {
                                    $data = trim($_POST['search']);

                                    if ($data != "") {
                                        $sql .= " AND B.category_name like '%$data%' OR U.user_name like '%$data%'";
                                    }

                                    if ($_POST["filter-2"] == 'nameAsc') {
                                        $sql .= " ORDER BY B.category_name ASC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'nameDesc') {
                                        $sql .= " ORDER BY B.category_name DESC";
                                    }
                                }
                            }
                            $result = selectBlogsAll($sql);
                            include '../blog_category/list.php';
                            break;
                        case 'add-blogCategory':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['add'])) {
                                    if(isset($_SESSION['user_id'])) {
                                        $id = $_SESSION['user_id'];
                                    }
                                    $category_name = $_POST['category_name'];
                                    $query = cudBlog("INSERT INTO blog_category(category_name, user_id) VALUES ('$category_name',$id)");
                                    if ($query) {
                                        echo '<script>
                                                Swal.fire({
                                                    title: "Thành công!",
                                                    text: "Thêm danh mục thành công!",
                                                    icon: "success",
                                                    timer: 1000
                                                });
                                            </script>';
                                    }
                                }
                            }
                            include '../blog_category/add.php';
                            break;
                        case 'delete-Blogcategory':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $result = cudBlog("DELETE FROM blog_category WHERE blog_categoryId =$id");
                                if ($result) {
                                    echo '<script>
                                            Swal.fire({
                                                title: "Thành công!",
                                                text: "Xóa danh mục thành công!",
                                                icon: "success",
                                                timer: 1000
                                            });
                                        </script>';
                                } 
                            }
                            $sql = "SELECT * FROM blog_category AS B INNER JOIN users AS U ON B.user_id = U.user_id";
                            $result = selectBlogsAll($sql);
                            include '../blog_category/list.php';
                            break;
                        case 'update-Blogcategory':
                            if(isset($_GET['id'])){
                                $id = $_GET['id'];
                                $row = selectBlog("SELECT * FROM blog_category WHERE blog_categoryId = $id");
                            }

                            include '../blog_category/update.php';
                            break;
                        case 'handle-updateBC':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['update'])) {
                                    $id = $_POST['id'];
                                    $category_name = $_POST['category_name'];
                                    $result = cudBlog("UPDATE blog_category SET category_name = '$category_name' WHERE blog_categoryId = $id");
                                }
                            }
                            $sql = "SELECT * FROM blog_category AS B INNER JOIN users AS U ON B.user_id = U.user_id";
                            $result = selectBlogsAll($sql);
                            include '../blog_category/list.php';
                            echo '<script>
                                        Swal.fire({
                                            title: "Thành công!",
                                            text: "Cập nhật danh mục thành công!",
                                            icon: "success",
                                            timer: 1000
                                        });
                                    </script>';
                            break;
                        case 'blogs':
                            $sql = "SELECT B.*, U.*, C.*, B.create_date as blog_create_date  FROM blogs AS B INNER JOIN users AS U ON B.user_id = U.user_id INNER JOIN blog_category AS C ON B.blog_categoryId = C.blog_categoryId WHERE 1";
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['submit'])) {
                                    $data = trim($_POST['search']);

                                    if ($data != "") {
                                        $sql .= " AND C.category_name like '%$data%' OR B.title like '%$data%' OR U.user_name like '%$data%'" ;
                                    }

                                    if ($_POST["filter-2"] == 'nameAsc') {
                                        $sql .= " ORDER BY B.title ASC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'nameDesc') {
                                        $sql .= " ORDER BY B.title DESC";
                                    }

                                    if ($_POST["filter-2"] == 'asc') {
                                        $sql .= " ORDER BY B.create_date ASC";
                                    }
                            
                                    if ($_POST["filter-2"] == 'desc') {
                                        $sql .= " ORDER BY B.create_date DESC";
                                    }
                                }
                            }
                            $result = selectBlogsAll($sql);
                            include "../blogs/list.php";
                            break;
                        case 'add-blog':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['add'])) {
                                    if (isset($_SESSION['user_id'])) {
                                        $id = $_SESSION['user_id'];
                                    }
                                    $title = $_POST['blog_name'];
                                    $description = $_POST['description'];
                                    $category_id = $_POST['category'];
                                    $content = $_POST['content'];
                                    $target_dir = '../../upload_img/';
                                    $target_file = $target_dir . basename($_FILES['image_blog']['name']);
                                    move_uploaded_file($_FILES['image_blog']['tmp_name'], $target_file);
                                    $sql = "INSERT INTO blogs (title, blog_description, blog_categoryId, blog_content, blog_image, user_id, create_date)
                                            VALUES ('$title', '$description', $category_id, '$content', '$target_file', $id, NOW())";
                                    $result = cudBlog($sql);
                                    if ($result) {
                                        echo '<script>
                                        Swal.fire({
                                            title: "Thành công!",
                                            text: "Thêm bài viết thành công!",
                                            icon: "success",
                                            timer: 1000
                                        });
                                        </script>';
                                    }
                                }
                            }
                            include '../blogs/add.php';
                            break;
                        case 'update-blog':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $row = selectBlog("SELECT * FROM blogs WHERE blog_id = $id");
                            }
                            include '../blogs/update.php';
                            break;
                        case 'handle-blog':
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['update'])) {
                                    $id = $_POST['id'];
                                    $title = $_POST['blog_name'];
                                    $description = $_POST['description'];
                                    $content = $_POST['content'];
                                    $category_id = $_POST['category'];
                                    if (isset($_SESSION['user_id'])) {
                                        $user_id = $_SESSION['user_id']; 
                                    }

                                    if (is_uploaded_file($_FILES['image_blog']['tmp_name'])) {
                                        $target_dir = '../../upload_img/';
                                        $target_file = $target_dir . basename($_FILES['image_blog']['name']);
                                        move_uploaded_file($_FILES['image_blog']['tmp_name'], $target_file);
                                        $sql = "UPDATE blogs 
                                                SET title='$title', 
                                                    blog_description='$description', 
                                                    blog_image='$target_file', 
                                                    user_id=$user_id, 
                                                    blog_content='$content', 
                                                    blog_categoryId=$category_id,  
                                                    create_date=NOW()
                                                WHERE blog_id=$id";
                                        cudBlog($sql);
                                    }else {
                                        $sql = "UPDATE blogs SET title='$title', blog_description='$description', user_id=$user_id, 
                                                                blog_content='$content', blog_categoryId=$category_id,  create_date=NOW()
                                                                where blog_id=$id";
                                        cudBlog($sql);
                                    }
                                }
                            }
                            $sql = "SELECT B.*, U.*, C.*, B.create_date as blog_create_date  FROM blogs AS B INNER JOIN users AS U ON B.user_id = U.user_id INNER JOIN blog_category AS C ON B.blog_categoryId = C.blog_categoryId";
                            $result = selectBlogsAll($sql);
                            include "../blogs/list.php";
                            echo '<script>
                                        Swal.fire({
                                            title: "Thành công!",
                                            text: "Cập nhật bài viết thành công!",
                                            icon: "success",
                                            timer: 1000
                                        });
                                    </script>';
                            break;
                        case 'delete-blog':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $result = cudBlog("DELETE FROM blogs WHERE blog_id = $id");
                                if ($result) {
                                    echo '<script>
                                        Swal.fire({
                                            title: "Thành công!",
                                            text: "Xóa bài viết thành công!",
                                            icon: "success",
                                            timer: 1000
                                        });
                                    </script>';
                                }
                            }
                            $sql = "SELECT B.*, U.*, C.*, B.create_date as blog_create_date  FROM blogs AS B INNER JOIN users AS U ON B.user_id = U.user_id INNER JOIN blog_category AS C ON B.blog_categoryId = C.blog_categoryId";
                            $result = selectBlogsAll($sql);
                            include "../blogs/list.php";
                            break;
                        //------------------------ invoice ---------------------
                        case 'invoices':
                            if (isset($_GET['invoice_id'])){
                                $id = $_GET['invoice_id'];
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    if (isset($_POST['update'])) {
                                        $status = $_POST['status'];
                                        $update = cudInvoice("UPDATE invoices SET order_status = '$status' WHERE invoice_id =$id");
                                        if ($update) {
                                            echo '<script>
                                                    Swal.fire({
                                                        title: "Cập nhật thành công!",
                                                        text: "Cập nhật trạng thái thành công!",
                                                        icon: "success",
                                                        timer: 1000
                                                    });
                                                </script>';
                                        }
                                    }
                                }
                            }
                            $sql = "SELECT * FROM invoices AS I INNER JOIN users AS U ON I.user_id = U.user_id WHERE 1";
                            
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['submit'])) {
                                    $data = trim($_POST['search']);

                                    if ($data != "") {
                                        $sql .= " AND I.invoice_id like '%$data%' OR U.user_name like '%$data%'";
                                    }
                                }
                            }

                            $sql .= " ORDER BY I.INVOICE_id desc";
                            $result = selectInvoicetAll($sql);
                            include "../invoices/list.php";
                            break;
                        case 'invoice_details':
                            if (isset($_GET['invoice_id'])){
                                $id = $_GET['invoice_id'];
                                $sql = "SELECT * FROM invoice_details AS I INNER JOIN products AS P ON I.product_id = P.product_id WHERE I.invoice_id = $id";
                                $result = selectInvoicetAll($sql);
                            }
                            include '../invoices/list-details.php';
                            break;
                        default: 
                            include '../statistical/statistical.php';
                            break;
                    }
                ?>
                <?php } ?>
            </div>
        </div>
    </main> 
    <?php } else { 
        header("Location: ../../view/accounts/login.php");
        exit(); 
    }
    ?>
    <script>
        function deleteC(event) {
            event.preventDefault();

            const deleteLink = event.currentTarget; // sử dụng this để lấy phần tử được kích hoạt
            const path = deleteLink.getAttribute('href');

            Swal.fire({
                title: "Bạn có chắc muốn xóa?",
                text: "Bạn sẽ không thể khôi phục điều này!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Hủy bỏ",
                confirmButtonText: "Xóa"
            }).then((result) => {
                if (result.value) {
                    document.location.href = path;
                }
            });
        }

        function showCommentForm() {
            var commentForm = document.getElementById('comment-form');
            commentForm.style.display = 'block';
        }

        function hideCommentForm() {
            var commentForm = document.getElementById('comment-form');
            commentForm.style.display = 'none';
        }

        const myForm = document.getElementById('myForm');

        myForm.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>
    <script>
        $('#description').summernote({
            placeholder: 'Mô tả sản phẩm',
            tabsize: 2,
            height: 100
        });
    </script>
    <script>
        $('#content').summernote({
            placeholder: 'Nội dung sản phẩm',
            tabsize: 2,
            height: 100
        });
    </script>
    <script>
    function validateDiscount(input) {
        if (input.value < 0) {
            input.value = 0;
        }

        if (input.value > 100) {
            input.value = 100; 
        }
    }

    function validatePrice(input) {
        if (input.value < 0) {
            input.value = 0;
        }
    }
</script>
</body>
</html>