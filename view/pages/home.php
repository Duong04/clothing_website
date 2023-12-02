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
    <title>SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/home.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/home.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ------------ Banner -------------- -->
        <div class="banner">
            <a href=""><img src="../../assets/img/banner/banner-item.jpg" alt=""></a>
        </div>
        <!-- ------------- Section category --------------- -->
        <section class="section-category">
            <div class="row-category">
                <div class="row-category-item">
                    <a href="">
                        <div class="row-category-item-1"><img src="../../assets/img/icon-category/img_category_1.webp" alt=""></div>
                        <h5>Áo Thun</h5>
                    </a>
                </div>
                <div class="row-category-item">
                    <a href="">
                        <div class="row-category-item-1"><img src="../../assets/img/icon-category/img_category_2.webp" alt=""></div>
                        <h5>Áo Khoác Hoodie</h5>
                    </a>
                </div>
                <div class="row-category-item">
                    <a href="">
                        <div class="row-category-item-1"><img src="../../assets/img/icon-category/img_category_3.webp" alt=""></div>
                        <h5>Áo Sơ Mi</h5>
                    </a>
                </div>
                <div class="row-category-item">
                    <a href="">
                        <div class="row-category-item-1"><img src="../../assets/img/icon-category/img_category_4.webp" alt=""></div>
                        <h5>Quần</h5>
                    </a>
                </div>
            </div>
        </section>
        <!-- --------------- Section product ------------------ -->
        <section class="section-product">
            <div class="tabs">
                <div class="tab-item active">Sản phẩm mới nhất</div>
                <div class="tab-item">Sản phẩm nổi bật</div>
                <div class="tab-item">Gợi ý cho bạn</div>
                <div class="line"></div>
            </div>
            <div class="tab-products">
                <div class="tab-pane-product active">
                    <div class="tab-product-child">
                        <?php
                        $sql = "SELECT * FROM products ORDER BY create_date DESC LIMIT 8";  
                        $row = selectProductAll($sql);
                        foreach($row as $list) {
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
                        <?php } ?>
                    </div>
                    <div class="view-all">
                        <a href="../pages/categories.php">Xem thêm <i class="fa-solid fa-chevron-down"></i></a>
                    </div>
                </div>

                <!-- ------------------- -->
                <div class="tab-pane-product">
                    <div class="tab-product-child">
                        <?php 
                        $sql = "SELECT * FROM products ORDER BY view DESC LIMIT 8";
                        $row = selectProductAll($sql);
                        foreach($row as $list) {
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
                        <?php } ?>
                    </div>
                </div>

                <div class="tab-pane-product">
                    <div class="tab-product-child">
                    <?php 
                        $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 8";
                        $row = selectProductAll($sql);
                        foreach($row as $list) {
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
                    <?php } ?>
                    </div>
                </div>
            </div>
        </section>

        <!----------- Section banner -------------------->
        <section class="section-banner">
            <a href="">
                <img src="../../assets/img/banner/banner-item2.jpg" alt="">
            </a>
        </section>

        <!----------- Section-outfit --------------------->
        <section class="section-outfit">
            <h2>BỘ PHỐI SUGAR</h2>
            <div class="outfit-grid">
                <div class="outfit-grid-item">
                    <img src="../../assets/img/outfit/lookbook_1_image.webp" alt="">
                </div>
                <div class="outfit-grid-item">
                    <img src="../../assets/img/outfit/lookbook_2_image.webp" alt="">
                </div>
                <div class="outfit-grid-item">
                    <img src="../../assets/img/outfit/lookbook_3_image.webp" alt="">
                </div>
                <div class="outfit-grid-item">
                    <img src="../../assets/img/outfit/lookbook_4_image.webp" alt="">
                </div>
                <div class="outfit-grid-item">
                    <img src="../../assets/img/outfit/lookbook_5_image.webp" alt="">
                </div>
                <div class="outfit-grid-item">
                    <img src="../../assets/img/outfit/lookbook_6_image.webp" alt="">
                </div>
                <div class="outfit-grid-item">
                    <img src="../../assets/img/outfit/lookbook_7_image.webp" alt="">
                </div>
                <div class="outfit-grid-item">
                    <img src="../../assets/img/outfit/lookbook_8_image.webp" alt="">
                </div>
            </div>
        </section>
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
    <script src="../../assets/js/home.js"></script>
</body>
</html>