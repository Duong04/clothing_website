<?php 
    require "../../config/connectDB.php";
    require "../../model/dao-users.php";
    require "../../model/dao-products.php";
    require "../../model/dao-categories.php";
    require "../../model/dao-comment.php";
    require "../../model/dao-blogs.php";
    session_start();

    if (isset($_GET['product_id'])) {
        $id = $_GET['product_id'];
    }

    cudProduct("UPDATE products SET view = view + 1 WHERE product_id = $id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    if (isset($_GET['product_id'])) {
        $id = $_GET['product_id'];
    }
    $name = selectProduct("SELECT * FROM products WHERE product_id = $id");
    ?>
    <title><?=$name['product_name']?> - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
      />
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/productDetail.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/productDetail.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ----------------Article---------------- -->
        <article>
            <?php 
            if (isset($_GET['product_id'])) {
                $id = $_GET['product_id'];
            }
            $row = selectProduct("SELECT * FROM products WHERE product_id = $id");
            ?>
            <div class="breadcrumb-arrows">
                <a href="./home.php">Trang chủ /</a>
                <span><?=$row['product_name']?></span>
            </div>
            <!-- ------------------------------------- -->
            <div class="container-fluid">
                <div class="list-img">
                    <div id="main-carousel" class="splide" aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel.">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <?php
                                $listImage = selectProductAll("SELECT * FROM library_image WHERE product_id = $id ORDER BY image_id DESC");
                                foreach ($listImage as $list){
                                ?>
                                <li class="splide__slide">
                                    <img src="<?=$list['image']?>" alt="">
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!-- ----------------------- -->
                    <div id="thumbnail-carousel" class="splide" aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel.">
                        <div class="splide__track">
                            <ul class="splide__list">
                            <?php
                                $listImage = selectProductAll("SELECT * FROM library_image WHERE product_id = $id ORDER BY image_id DESC");
                                foreach ($listImage as $list){
                                ?>
                                <li class="splide__slide">
                                    <img src="<?=$list['image']?>" alt="">
                                </li>
                             <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="product-content-desc">
                    <h3><?=$row['product_name']?></h3>
                    <div class="element-total">
                        <?php 
                        $price = number_format($row['price'], 0,',','.');
                        if ($row['sale'] > 0){
                            $priceNew = $row['price'] - ($row['price'] * ($row['sale'] / 100));
                            $priceNewF = number_format($priceNew, 0,',','.');
                        ?>
                            <div class="price">
                                <span><?=$priceNewF?><sup>đ</sup></span>
                                <del><?=$price?><sup>đ</sup></del>
                            </div>
                            <?php }else { ?>
                                <div class="price">
                                    <span><?=$price?><sup>đ</sup></span>
                                </div>
                        <?php } ?>
                        <div class="product-sold">
                            Đã bán: <span>200</span>
                        </div>
                        <?php if ($row['sale'] > 0){ 
                            $priceNew = $row['price'] - ($row['price'] * ($row['sale'] / 100));
                            $savePrice = $row['price'] - $priceNew; 
                            $savePriceF = number_format($savePrice, 0,',','.');   
                        ?>
                        <div class="price-save">Tiết kiệm <?=$savePriceF?> <sup>đ</sup></div>
                        <?php } ?>
                    </div>
                    <div class="info-promotion2">Freeship cho đơn 500K</div>
                    <form class="btn-cart" id="quantityForm" action="../cart/cart.php" method="POST">
                        <div class="quantity">
                            <button class="decrease" type="button">-</button>
                            <input type="number" oninput="validateDiscount(this)" name="quantity" id="quantityInput" min="1" max="<?=$row['quantity_product']?>" class="count" value="1">
                            <button class="increase" type="button">+</button>
                        </div>
                        <div class="add-cart">
                            <input type="hidden" name="product_id" value="<?=$row['product_id']?>">
                            <button name="add-cart"><span><i class="fa-solid fa-cart-shopping"></i> Thêm sản phẩm vào giỏ hàng</span></button>
                        </div>
                    </form>
                    <div class="add-cart-favorite">
                        <form method="POST" class="add-favorite" action="../heart/heart.php">
                            <input type="hidden" name="product_id" value="<?=$row['product_id']?>">
                            <button><i class="fa-regular fa-heart"></i> Thêm vào sản phẩm yêu thích</button>
                        </form>
                    </div>
                    <div class="description">
                        <h3>Thông tin sản phẩm</h3>
                        <div class="content-description"><?=$row['description']?></div>
                    </div>
                    <div class="brand">
                        <h3>Câu chuyện thương hiệu</h3>
                        <div class="content-brand">
                            <div class="brand-item">
                                <img src="../../assets/img/brand/policy-ship.webp" alt="">
                                <span>Miễn phí giao hàng với đơn hàng từ 500.000₫</span>
                            </div>
                            <hr>
                            <div class="brand-item">
                                <img src="../../assets/img/brand/phone-call.webp" alt="">
                                <a href="tel:0815416086">0815416086</a>
                            </div>
                            <hr>
                            <div class="brand-item">
                                <img src="../../assets/img/brand/policy-return.webp" alt="">
                                <span>Chính sách đổi trả hàng</span>
                            </div>
                            <hr>
                            <div class="brand-item">
                                <img src="../../assets/img/brand/policy-membership.webp" alt="">
                                <span>Membership</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ------------------------------------- -->
            <div class="comment-product">
                <h4>Bình luận sản phẩm</h4>
                <div class="form-comment">
                    <?php 
                    if (isset($_SESSION['user_id'])){
                    ?>
                        <form id="comment" action="" method="POST">
                            <textarea required name="content" id="" cols="50" rows="2" placeholder="Bình luận tại đây"></textarea>
                            <button name="submit" id="submit">Đăng</button>
                        </form>
                    <?php } else { ?>
                        <form id="comment" action="" method="POST">
                            <textarea disabled name="content" id="" cols="50" rows="2" placeholder="Vui lòng đăng nhập để bình luận"></textarea>
                        </form>
                    <?php } ?>
                    <div class="comment" id="comment-section">
                        <?php
                        $listComment = selectCommentAll("SELECT * FROM comments AS C INNER JOIN users AS U ON C.user_id = U.user_id WHERE product_id =" . $row['product_id']);
                        foreach ($listComment as $comment) {
                            include '../controller/comment.php'; 
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- ------------------------------------- -->
            <hr>
            <hr>
            <!-- ------------------------------------- -->
            <div class="product-suggest">
                <h3>Sản phẩm cùng phong cách</h3>
                <div class="slide-product">
                    <?php 
                    $listP = selectProductAll("SELECT * FROM products WHERE product_id != $id AND quantity_product != 0 ORDER BY RAND() limit 12");
                    foreach ($listP as $list){
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
                                <div class="price-2">
                                    <span><?=$formattedPrice?><sup>đ</sup></span>
                                    <del><?=$price?><sup>đ</sup></del>
                                </div>
                                <div class="sale">-<?=$list['sale']?>%</div>
                                <?php }else { 
                                ?>
                                <div class="price-2">
                                    <span><?=$price?><sup>đ</sup></span>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="info-promotion">Freeship cho đơn 500k</div>
                        </a>
                        <div class="cart-favorite">
                            <div class="btn-cart-favorite">
                                <form method="POST" action="../cart/cart.php" class="btn-cart-2">
                                    <input type="hidden" name="product_id" value="<?=$list['product_id']?>">
                                    <button><i class="fa-solid fa-cart-plus"></i></button>
                                </form>
                                <form method="POST" action="../heart/heart.php" class="btn-heart">
                                    <input type="hidden" name="product_id" value="<?=$list['product_id']?>">
                                    <button><i class="fa-regular fa-heart"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </article>
        <!-- ----------------footer----------------- -->
        <?php include "../footer.php"; ?>
    </main>
    
    <script>
        $(document).ready(function () {
            $('#submit').on('click', function (e) {
                e.preventDefault();

                var formData = $('#comment').serialize();

                $.ajax({
                    type: 'POST',
                    url: '../controller/handleComment.php?product_id=<?=$row['product_id']?>', 
                    data: formData,
                    success: function (response) {
                        $('#comment-section').append(response);
                        $('#comment')[0].reset(); // Reset the form
                    }
                });
            });
        });
        
        function validateDiscount(input) {
            if (input.value < 0) {
                input.value = 0;
            }

            if (input.value > <?=$row['quantity_product']?>) {
                input.value = <?=$row['quantity_product']?>; 
            }
        }
        
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
    </script>
   <script>
        function addCart() {
            Swal.fire({
                title: "Thành công!",
                text: "Thêm sản phẩm vào giỏ hàng thành công!",
                icon: "success",
                timer: 1000
            });
        }

        var form = document.querySelector('.btn-cart'); 

        form.addEventListener('submit', function (event) {
            event.preventDefault(); 
            addCart(); 
            setTimeout(function() {
                form.submit(); 
            }, 1000); 
        });

        var forms_2 = document.querySelectorAll('.btn-cart-2');

        forms_2.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); 
                addCart(); 
                setTimeout(function() {
                    form.submit(); 
                }, 1000); 
            });
        });

        // --------------------------
        function addHeart() {
            Swal.fire({
                title: "Thành công!",
                text: "Thêm sản phẩm yêu thích thành công!",
                icon: "success",
                timer: 1000
            });
        }

        var form2 = document.querySelector('.add-favorite'); 

        form2.addEventListener('submit', function (event) {
            event.preventDefault(); 
            addHeart();
            setTimeout(function() {
                form.submit(); 
            }, 1000); 
        });

        var forms_3 = document.querySelectorAll('.btn-heart');

        forms_3.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); 
                addHeart();
                setTimeout(function() {
                    form.submit(); 
                }, 1000); 
            });
        });
    </script>
    <script
      type="text/javascript"
      src="https://code.jquery.com/jquery-1.11.0.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"
    ></script>
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/slide.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="../../assets/js/detail.js"></script>
</body>
</html>