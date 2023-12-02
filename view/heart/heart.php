<?php 
    require "../../config/connectDB.php";
    require "../../model/dao-users.php";
    require "../../model/dao-products.php";
    require "../../model/dao-categories.php";
    require "../../model/dao-blogs.php";
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["product_id"])) {
            $product_id = $_POST["product_id"];
            $product = selectProduct("SELECT * FROM products WHERE product_id = $product_id");
            
            if (!isset($_SESSION['heart'])) {
                $_SESSION['heart'] = array();
            }

            $product_exists = false;

            foreach ($_SESSION['heart'] as $key => $heart_item) {
                if ($heart_item['product_id'] == $product_id) {
                    $product_exists = true;
                    break;
                }
            }
            
            if (!$product_exists) {
                $heart_item = array(
                    'product_id' => $product['product_id'],
                    'product_name' => $product['product_name'],
                    'price' => $product['price'],
                    'sale' => $product['sale'],
                    'product_image' => $product['product_image'],
                    'quantity_product' => $product['quantity_product'],
                );

                $_SESSION['heart'][] = $heart_item;
            }
        }
        $previous_page = $_SERVER['HTTP_REFERER'];
        header('Location: ' . $previous_page);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm yêu thích - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/heart.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/heart.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <article>
            <h3>Sản phẩm yêu thích</h3>
            <div class="section-product">
                <?php if (isset($_SESSION['heart']) && count($_SESSION['heart']) > 0) { ?>
                <div class="product-main">
                    <?php foreach ($_SESSION['heart'] as $row) { ?>
                    <div class="product-item">
                        <a href="../pages/productDetail.php?product_id=<?=$row['product_id']?>">
                            <div class="product-img">
                                <img src="<?=$row['product_image']?>" alt="">
                            </div>
                            <div class="color">
                                <span class="color-1"></span>
                                <span class="color-2"></span>
                                <span class="color-3"></span>
                            </div>
                            <h3><?=$row['product_name']?></h3>
                            <div class="price-sale">
                                <?php
                                $price = number_format($row['price'], 0, ',','.');
                                if ($row['sale'] > 0) { 
                                    $priceNew = $row['price'] - ($row['price'] * ($row['sale'] / 100));
                                    $formattedPrice = number_format($priceNew, 0,',','.');
                                    ?>
                                <div class="price">
                                    <span><?=$formattedPrice?><sup>đ</sup></span>
                                    <del><?=$price?><sup>đ</sup></del>
                                </div>
                                <div class="sale">-<?=$row['sale']?>%</div>
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
                                <?php
                                 $row_2 = selectProduct("SELECT * FROM products WHERE product_id = ".$row['product_id']);
                                 if ($row_2['quantity_product'] > 0){ 
                                ?>
                                <form method="POST" action="../cart/cart.php" class="btn-cart">
                                    <input type="hidden" name="product_id" value="<?=$row['product_id']?>">
                                    <button><i class="fa-solid fa-cart-plus"></i></button>
                                </form>
                                <?php }else { ?>
                                <form onclick="sold_out(event)" method="POST" action="" class="sold_out">
                                    <button><i class="fa-solid fa-cart-plus"></i></button>
                                </form>
                                <?php } ?>
                                <form method="POST" action="../heart/removeHeart.php" class="btn-heart">
                                    <input type="hidden" name="product_id" value="<?=$row['product_id']?>">
                                    <button><i class="fa-solid fa-heart-circle-xmark"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php }else { ?>
                    <div class="heart-empty">
                        <div class="icon-heart">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <p>Bạn chưa có sản phẩm yêu thích</p>
                        <div class="return-home">
                            <a href="../pages/home.php">Quay về trang chủ</a>
                        </div>
                    </div>
                <?php } ?>
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

        function sold_out(e) {
            e.preventDefault();
            Swal.fire({
                title: "Xin lỗi bạn!",
                text: "Sản phẩm này hiện tại đã hết hàng!",
                icon: "error",
                timer: 4000
            });
        }
    </script>
    <script src="../../assets/js/header.js"></script>
</body>
</html>