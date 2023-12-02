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
    <title>Tìm kiếm - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/search.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/search.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <article>
            <h3>Tìm kiếm</h3>
            <div class="section-product">
                <?php 
                if (isset($_POST['search'])) {
                    $data = $_POST['search'];
                ?>
                <h4>Kết quả tìm kiếm "<?=$data?>"</h4>
                <div class="product-main">
                    <?php 
                    $sql = "SELECT * FROM products AS P INNER JOIN categories AS C ON P.category_id = C.category_id WHERE product_name like '%$data%' || category_name like '%$data%'";
                    $result = selectProductAll($sql);
                    if ($result != null) {
                    foreach ($result as $row) {
                    ?>
                    <div class="product-item">
                        <a href="./productDetail.php?product_id=<?=$row['product_id']?>">
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
                                <form method="POST" action="../cart/cart.php" class="btn-cart">
                                    <input type="hidden" name="product_id" value="<?=$row['product_id']?>">
                                    <button><i class="fa-solid fa-cart-plus"></i></button>
                                </form>
                                <form method="POST" action="../heart/heart.php" class="btn-heart">
                                    <input type="hidden" name="product_id" value="<?=$list['product_id']?>">
                                    <button><i class="fa-regular fa-heart"></i></button>
                                </form>
                            </div>
                        </div>
                        <?php 
                        if ($row['quantity_product'] == 0) {
                        ?>
                        <div class="sold-out"><img src="../../assets/img/product/icon/c2821078c1ed0205f21db54adb7ae8f4-removebg-preview.png" alt=""></div>
                         <?php } ?>
                    </div>
                    <?php } }else { ?>
                        <h3>Không tìm thấy kết quả!</h3>
                    <?php } ?>
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