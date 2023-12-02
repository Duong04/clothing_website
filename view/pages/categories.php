<?php 
require "../../config/connectDB.php";
require "../../model/dao-users.php";
require "../../model/dao-products.php";
require "../../model/dao-categories.php";
require "../../model/dao-blogs.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        if (isset($_GET['category_id'])) {
            $id = $_GET['category_id'];
            $listC = selectCategory("SELECT * FROM categories WHERE category_id = $id");
        ?>
    <title><?=$listC['category_name']?> - SUGAR - Streetwear brand</title>
    <?php } else { ?>
    <title>Tất cả sản phẩm - SUGAR - Streetwear brand</title>
    <?php } ?>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/categories.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/categories.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ----------------Article---------------- -->
        <article>
            <?php 
            if (isset($_GET['category_id'])) {
                $id = $_GET['category_id'];
                $listC = selectCategory("SELECT * FROM categories WHERE category_id = $id");
            ?>
            <h3><?=$listC['category_name']?></h3>
            <?php }else { ?>
            <h3>Tất cả sản phẩm</h3>
            <?php } ?>
            <div class="collection-title">
                <form action="" method="POST">
                    <div class="collection-categories">
                        <select name="filter" id="">
                            <option value="0">Sắp xếp theo</option>
                            <option value="nameAsc">Tên A - Z</option>
                            <option value="nameDesc">Tên Z - A</option>
                            <option value="productNew">Sản phẩm mới nhất</option>
                            <option value="productOld">Sản phẩm cũ nhất</option>
                        </select>
                        <select name="price" class="form-select">
                            <option value="0" selected>Đơn giá</option>
                            <option value="100000">0 -> 100.000đ</option>
                            <option value="200000">100.000đ -> 200.000đ</option>
                            <option value="300000">200.00đ -> 300.000đ</option>
                            <option value="400000">300.000đ -> 400.000đ</option>
                            <option value="500000">500.000đ -> </option>
                        </select>
                        <button name="submit"><i class="fa-solid fa-filter"></i></button>
                    </div>
                </form>
            </div>
            <div class="product-main">
                <?php 
                if (isset($_GET['category_id'])) {
                    $id = $_GET['category_id'];
                    $sql = "SELECT * FROM products WHERE category_id = $id";
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['submit'])) {
                            $price = $_POST['price'];
                            if ($price > 0) {
                                if ($price > 0) {
                                    $sql .= " AND price > 0 ";
                                    
                                    switch ($price) {
                                        case 100000:
                                            $sql .= " AND price <= 100000";
                                            break;
                                        case 200000:
                                            $sql .= " AND price > 100000 AND price <= 200000";
                                            break;
                                        case 300000:
                                            $sql .= " AND price > 200000 AND price <= 300000";
                                            break;
                                        case 400000:
                                            $sql .= " AND price > 300000 AND price <= 400000";
                                            break;
                                        case 500000:
                                            $sql .= " AND price > 400000";
                                            break;
                                    }
                                }
                            }

                            if ($_POST["filter"] == 'nameAsc') {
                                $sql .= " ORDER BY product_name ASC";
                            }
                    
                            if ($_POST["filter"] == 'nameDesc') {
                                $sql .= " ORDER BY product_name DESC";
                            }
                    
                            if ($_POST["filter"] == 'productOld') {
                                $sql .= " ORDER BY create_date ASC";
                            }
                    
                            if ($_POST["filter"] == 'productNew') {
                                $sql .= " ORDER BY create_date DESC";
                            }
                        }

                    }
                $listP = selectProductAll($sql);
                if ($listP != null) {
                foreach ($listP as $list) {
                ?>
                <div class="tab-product-item">
                    <a href="./productDetail.php?product_id=<?=$list['product_id']?>">
                        <div class="product-img">
                            <img src="<?=$list['product_image']?>" alt="">
                        </div>
                        <div class="color">
                            <span class="color-1"></span>
                            <span class="color-2"></span>
                            <span class="color-3"></span>
                        </div>
                        <h3><?=$list['product_name']?></h3>
                        <div class="price-sale">
                            <?php
                            $price = number_format($list['price'], 0, ',','.');
                            if ($list['sale'] > 0) { 
                                $priceNew = $list['price'] - ($list['price'] * ($list['sale'] / 100));
                                $formattedPrice = number_format($priceNew, 0,',','.');
                                ?>
                            <div class="price">
                                <span><?=$formattedPrice?><sup>đ</sup></span>
                                <del><?=$price?><sup>đ</sup></del>
                            </div>
                            <div class="sale">-<?=$list['sale']?>%</div>
                            <?php }else { 
                            ?>
                            <div class="price">
                                <span><?=$price?><sup>đ</sup></span>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="info-promotion">Freeship cho đơn 500k</div>
                    </a>
                    <div class="cart-favorite">
                        <div class="btn-cart-favorite">
                            <form method="POST" action="../cart/cart.php" class="btn-cart">
                                <input type="hidden" name="product_id" value="<?=$list['product_id']?>">
                                <button><i class="fa-solid fa-cart-plus"></i></button>
                            </form>
                            <form method="POST" action="../heart/heart.php" class="btn-heart">
                                <input type="hidden" name="product_id" value="<?=$list['product_id']?>">
                                <button><i class="fa-regular fa-heart"></i></button>
                            </form>
                        </div>
                    </div>
                    <?php 
                    if ($list['quantity_product'] == 0) {
                    ?>
                    <div class="sold-out"><img src="../../assets/img/product/icon/c2821078c1ed0205f21db54adb7ae8f4-removebg-preview.png" alt=""></div>
                    <?php } ?>
                </div>
                <?php } } else { ?>
                <h2>Hiện phần này chưa có sản phẩm mong bạn thông cảm ❤️!!</h2>
                <?php } }else { 
                    $sql = "SELECT * FROM products WHERE 1";
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['submit'])) {
                            $price = $_POST['price'];
                            if ($price > 0) {
                                $sql .= " AND price > 0 ";
                                    
                                switch ($price) {
                                    case 100000:
                                        $sql .= " AND price <= 100000";
                                        break;
                                    case 200000:
                                        $sql .= " AND price > 100000 AND price <= 200000";
                                        break;
                                    case 300000:
                                        $sql .= " AND price > 200000 AND price <= 300000";
                                        break;
                                    case 400000:
                                        $sql .= " AND price > 300000 AND price <= 400000";
                                        break;
                                    case 500000:
                                        $sql .= " AND price > 400000";
                                        break;
                                }
                            }
                            if ($_POST["filter"] == 'nameAsc') {
                                $sql .= " ORDER BY product_name ASC";
                            }
                    
                            if ($_POST["filter"] == 'nameDesc') {
                                $sql .= " ORDER BY product_name DESC";
                            }
                    
                            if ($_POST["filter"] == 'productOld') {
                                $sql .= " ORDER BY create_date ASC";
                            }
                    
                            if ($_POST["filter"] == 'productNew') {
                                $sql .= " ORDER BY create_date DESC";
                            }
                        }
                    }
                    $listP = selectProductAll($sql);
                    foreach ($listP as $list) {
                ?>
                    <div class="tab-product-item">
                    <a href="./productDetail.php?product_id=<?=$list['product_id']?>">
                        <div class="product-img">
                            <img src="<?=$list['product_image']?>" alt="">
                        </div>
                        <div class="color">
                            <span class="color-1"></span>
                            <span class="color-2"></span>
                            <span class="color-3"></span>
                        </div>
                        <h3><?=$list['product_name']?></h3>
                        <div class="price-sale">
                            <?php
                            $price = number_format($list['price'], 0, ',','.');
                            if ($list['sale'] > 0) { 
                                $priceNew = $list['price'] - ($list['price'] * ($list['sale'] / 100));
                                $formattedPrice = number_format($priceNew, 0,',','.');
                                ?>
                            <div class="price">
                                <span><?=$formattedPrice?><sup>đ</sup></span>
                                <del><?=$price?><sup>đ</sup></del>
                            </div>
                            <div class="sale">-<?=$list['sale']?>%</div>
                            <?php }else { 
                            ?>
                            <div class="price">
                                <span><?=$price?><sup>đ</sup></span>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="info-promotion">Freeship cho đơn 500k</div>
                    </a>
                    <div class="cart-favorite">
                        <div class="btn-cart-favorite">
                            <form method="POST" action="../cart/cart.php" class="btn-cart">
                                <input type="hidden" name="product_id" value="<?=$list['product_id']?>">
                                <button><i class="fa-solid fa-cart-plus"></i></button>
                            </form>
                            <form method="POST" action="../heart/heart.php" class="btn-heart">
                                <input type="hidden" name="product_id" value="<?=$list['product_id']?>">
                                <button><i class="fa-regular fa-heart"></i></button>
                            </form>
                        </div>
                    </div>
                    <?php 
                    if ($list['quantity_product'] == 0) {
                    ?>
                    <div class="sold-out"><img src="../../assets/img/product/icon/c2821078c1ed0205f21db54adb7ae8f4-removebg-preview.png" alt=""></div>
                    <?php } ?>
                </div>
                <?php } } ?>
            </div>
        </article>
        <!-- ----------------footer----------------- -->
        <?php include "../footer.php"; ?>
    </main>
    <script>
        function addCart() {
            Swal.fire({
                title: "Thành công!",
                text: "Thêm sản phẩm vào giỏ hàng thành công!",
                icon: "success",
                timer: 1000
            });
        }


        var forms = document.querySelectorAll('.btn-cart');

        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); 
                addCart(); 
                setTimeout(function() {
                    form.submit(); 
                }, 1000); 
            });
        });

        // -----------------
        function addHeart() {
            Swal.fire({
                title: "Thành công!",
                text: "Thêm sản phẩm yêu thích thành công!",
                icon: "success",
                timer: 1000
            });
        }


        var forms = document.querySelectorAll('.btn-heart');

        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); 
                addHeart(); 
                setTimeout(function() {
                    form.submit(); 
                }, 1000); 
            });
        });
    </script>
    <script src="../../assets/js/header.js"></script>
</body>
</html>