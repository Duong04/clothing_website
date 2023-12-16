<?php 
    require "../../config/connectDB.php";
    require "../../model/dao-users.php";
    require "../../model/dao-products.php";
    require "../../model/dao-categories.php";
    require "../../model/dao-blogs.php";
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['update'])) {
            $quantity = $_POST['quantity-2'];
            $product_id = $_POST["product_id-2"];
        
            foreach ($_SESSION['cart'] as $key => $cart_item) {
                if ($cart_item['product_id'] == $product_id) {
                    $_SESSION['cart'][$key]['quantity'] = $quantity;
                    break;
                }
            }
        }

        if (isset($_POST['quantity'])) {
            $quantity = $_POST['quantity'];
        }else {
            $quantity = 1;
        }
    


        if (isset($_POST["product_id"])) {
            $product_id = $_POST["product_id"];
            $product = selectProduct("SELECT * FROM products WHERE product_id = $product_id");
            
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }

            $product_exists = false;

            foreach ($_SESSION['cart'] as $key => $cart_item) {
                if ($cart_item['product_id'] == $product_id) {
                    $_SESSION['cart'][$key]['quantity'] += $quantity;
                    $product_exists = true;
                    break;
                }
            }
            
            if (!$product_exists) {
                $cart_item = array(
                    'product_id' => $product['product_id'],
                    'product_name' => $product['product_name'],
                    'price' => $product['price'],
                    'sale' => $product['sale'],
                    'product_image' => $product['product_image'],
                    'quantity' => $quantity
                );

                $_SESSION['cart'][] = $cart_item;
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
    <title>Giỏ hàng - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/cart.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/cart.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <article>
            <h3>GIỎ HÀNG</h3>
            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {?>
            <div class="content">
                <div class="info-cart table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Stt</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Xóa</th>
                            </tr>
                        </thead>
                        <?php 
                        $stt = 0;
                        $totalPrice = 0;
                        if (isset($_SESSION["cart"])) {
                            foreach ($_SESSION["cart"] as $cart_item){
                                $priceNew = $cart_item['price'] - ($cart_item['price'] * ($cart_item['sale'] / 100));
                                $price = $cart_item['sale'] > 0 ? $priceNew : $cart_item['price'];
                                $total = $price * $cart_item['quantity'];
                                $priceF = number_format($price,0,',','.');
                                $totalF = number_format($total,0,',','.');
                                $totalPrice += $total;
                                $stt++;
                        ?>
                        <tbody>
                            <tr>
                            <th scope="row"><?=$stt?></th>
                            <td class="flex">
                                <div class="img">
                                    <img src="<?=$cart_item['product_image']?>" alt="">
                                </div>
                                <div class="right">
                                    <h5><?=$cart_item['product_name']?></h5>
                                    <span><?=$priceF?><sup>đ</sup></span>  
                                </div>
                            </td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="product_id-2" value="<?=$cart_item['product_id']?>">
                                    <input name="quantity-2" oninput="validateDiscount(this)" type="number" value="<?=$cart_item['quantity']?>">
                                    <button name="update"><i class="fa-solid fa-floppy-disk"></i></button>
                                </form>
                            </td>
                            <td><?=$totalF?><sup>đ</sup></td>
                            <td><a onclick="deleteC(event)" href="./removeCart.php?product_id=<?=$cart_item['product_id']?>"><i class="fa-regular fa-trash-can"></i></a></td>
                            </tr>
                        </tbody>
                        <?php } } ?>
                    </table>
                </div>
                <div class="pay-product">
                    <div class="price-pay">
                        <span>Tổng tiền</span>
                        <p><span id="total-price"><?php 
                            echo number_format($totalPrice, 0, ',', '.');;
                        ?></span><sup>đ</sup></p>
                    </div>
                    <div class="btn-pay">
                        <?php 
                        if (isset($_SESSION['user_id'])){
                        ?>
                        <a href="../pay/pay.php">Thanh toán</a>
                        <?php } else { ?>
                        <a onclick="login(event)" href="../accounts/login.php">Thanh toán</a>
                        <?php } ?>    
                    </div>
                </div>
            </div>
            <?php }else { ?>
            <div class="cart-empty">
                <div class="icon-cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <p>Không có sản phẩm nào trong giỏ hàng</p>
                <div class="return-home">
                    <a href="../pages/home.php">Quay về trang chủ</a>
                </div>
            </div>
            <?php } ?>
        </article>
        <!-- ----------------footer----------------- -->
        <?php include "../footer.php"; ?>
    </main>
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

        function login(event) {
            event.preventDefault();

            const deleteLink = event.currentTarget; // sử dụng this để lấy phần tử được kích hoạt
            const path = deleteLink.getAttribute('href');

            Swal.fire({
                title: "Bạn chưa đăng nhập",
                text: "Vui lòng đăng nhập để thanh toán!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Hủy bỏ",
                confirmButtonText: "Đăng nhập"
            }).then((result) => {
                if (result.value) {
                    document.location.href = path;
                }
            });
        }

        function validateDiscount(input) {
            if (input.value <= 0) {
                input.value = 1;
            }
        }
    </script>
    <script src="../../assets/js/header.js"></script>
</body>
</html>