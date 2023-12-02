<?php
require "../../config/connectDB.php";
require "../../model/dao-users.php";
require "../../model/dao-products.php";
require "../../model/dao-categories.php";
require "../../model/dao-blogs.php";
require "../../model/dao-invoice.php";
require "../../config/global.php";
require "../../PHPMailer/sendmail.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id']; 
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $totalPrice = 0;
        
        foreach ($_SESSION['cart'] as $cart_item) {
            $priceNew = $cart_item['price'] - ($cart_item['price'] * ($cart_item['sale'] / 100));
            $price = $cart_item['sale'] > 0 ? $priceNew : $cart_item['price'];
            $result = selectProduct("SELECT * FROM products WHERE product_id = ".$cart_item['product_id']);
            $quantity = $cart_item['quantity'];
            if ($quantity > $result['quantity_product']) {
                $quantity = $result['quantity_product'];
            }
            $total = $price * $quantity;
            $totalPrice += $total;
        }

        if ($cart_item['price'] > 0) {
            $shippingFee = $totalPrice > 500000 ? 0 : 30000;
            $sql = "INSERT INTO invoices (user_id, invoice_date, total_amount, order_status, shipping_fee)
                    VALUES ($user_id, NOW(), $totalPrice, 'Chờ xác nhận', $shippingFee)";
            $addInvoice =  cudInvoiceId($sql, $lastInsertId);
            if ($addInvoice) {
                foreach ($_SESSION['cart'] as $cart_item_2) {
                    $productId = $cart_item_2['product_id'];
                    $quantity = $cart_item_2['quantity'];
                    $result = selectProduct("SELECT * FROM products WHERE product_id = ".$cart_item_2['product_id']);
                    $quantity = $cart_item_2['quantity'];
                    if ($quantity > $result['quantity_product']) {
                        $quantity = $result['quantity_product'];
                    }
                    $price = $cart_item_2['price'] - ($cart_item_2['price'] * ($cart_item_2['sale'] / 100));
                    $priceNew = $cart_item_2['sale'] > 0 ? $price : $cart_item_2['price'];
                    $addInvoiceDetails = cudInvoice("INSERT INTO invoice_details(invoice_id, product_id, quantity, unit_price) 
                    VALUES($lastInsertId, $productId, $quantity, $price)");
                    cudProduct("UPDATE products SET quantity_product = quantity_product - $quantity WHERE product_id = $productId");
                }
    
                cudUsers("UPDATE users SET user_name = '$name', phone_number = $phone, address = '$address' WHERE user_id = $user_id");
                // send mail
                $title = "Đơn hàng của bạn";
                $massage = "Cảm ơn bạn đã mua hàng ở chúng tôi!";
                $content = "Vào phần <a href='$url/view/pay/order.php'>kiểm tra đơn hàng</a> để xem thông tin chi tiết nha💖 ";
                $sendMail = send_mail ($email, $title, $content, $massage);
                if ($sendMail) {
                    unset($_SESSION['cart']);
                    header('location: ../pay/thanks.php');
                }
            }
        }else {
            header('location: ../pay/thanks.php');
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - SUGAR - Streetwear brand</title>
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
    <link rel="stylesheet" href="../../assets/css/pay.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/pay.css">
</head>
<body>
    <main>
        <?php include '../header.php'; ?>
        <!-- article -->
        <div class="container">
            <article>
                <div class="content-article">
                    <h3>Sugar shop</h3>
                    <h5>Thông tin giao hàng</h5>
                    <form action="" method="POST">
                        <div class="my-info">
                            <?php 
                            if (isset($_SESSION['user_id'])) {
                                $id = $_SESSION['user_id'];
                            }
                            $listUser = selectUsers("SELECT * FROM users WHERE user_id = $id")
                            ?>
                            <div class="name">
                                <input type="text" name="name" value="<?=$listUser['user_name']?>" placeholder="Tên người dùng" required>
                            </div>
                            <div class="email">
                                <input type="email" name="email" value="<?=$listUser['email']?>" placeholder="email" required>
                            </div>
                            <div class="phone">
                                <input type="text" name="phone" value="<?=$listUser['phone_number']?>" placeholder="Số điện thoại" required>
                            </div>
                            <div class="address">
                                <input type="text" name="address" value="<?=$listUser['address']?>" placeholder="Địa chỉ" required>
                            </div>
                        </div>
                    <div class="ship-method">
                        <h5>Phương thức vận chuyển</h5>
                        <div class="ship-price">
                            <span>Ship nhanh, an toàn</span>
                            <span>30.000<sup>đ</sup></span>
                        </div>
                    </div>
                    <div class="pay-method">
                        <h5>Phương thức thanh toán</h5>
                        <div class="pay-item">
                            <div class="cod-pay">
                                <div class="tick-circle">
                                    <i id="i1" class="fa-solid fa-circle"></i>
                                </div>
                                <div class="cod-item">
                                    <p>Thanh toán khi nhận hàng (COD)</p>
                                </div>
                            </div>
                            <div class="text-pay">
                                <p>Cảm ơn bạn đã tin dùng mua hàng tại <b>Shop sugar</b></p>
                                <p>Chúng mình sẽ sớm liên hệ với bạn để Xác Nhận Đơn Hàng qua điện thoại trước khi giao hàng.</p>
                            </div>
                            <div class="pay-bank">
                                <div class="tick-circle">
                                    <i id="i2" class="fa-regular fa-circle"></i>
                                </div>
                                <div class="cod-item">
                                    <p>Chuyển khoản qua ngân hàng</p>
                                </div>
                            </div>
                            <div class="info-bank">
                                <p>Số tài khoản: <b>91930092004</b></p>
                                <p>Chủ tài khoản: <b>Nguyễn Thành Đường</b></p>
                                <p>Ngân hàng thụ hưởng: TP Bank (Tiên Phong bank)</p>
                                <p>
                                    Khách hàng vui lòng điền nội dung chuyển khoản theo cú pháp : [Mã đơn hàng] - [Số điện thoại] - [Tên người nhận]
                                    VD : 888333 - Nguyễn Văn A - 0908654321
                                </p>
                                <p>Ở trên là các bước xác nhận tham chiếu nội dung thanh toán của bạn</p>
                                <p>Sau khi chuyển thành công, vui long chụp màn hình gửi vào zalo: <b>0815416086</b> để xác nhận thông tin thanh toán</p>
                            </div>
                        </div>
                    </div>
                    <div class="btn-click">
                        <div class="change-cart">
                            <a href="../cart/cart.php"><i class="fa-solid fa-arrow-right fa-rotate-180"></i> Giỏ hàng</a>
                        </div>
                        <button name="submit">Hoàn tất đơn hàng</button>
                     </div>
                    </form>
                </div>
            </article>
            <aside>
                <div class="show-cart"><i class="fa-solid fa-cart-shopping"></i> Xem thông tin đơn hàng <i class="fa-solid fa-caret-down"></i></div>
                <div class="hide-product">
                    <div class="product">
                        <?php
                        $totalPrice = 0;
                        foreach ($_SESSION['cart'] as $cart_item) {
                            $priceNew = $cart_item['price'] - ($cart_item['price'] * ($cart_item['sale'] / 100));
                            $price = $cart_item['sale'] > 0 ? $priceNew : $cart_item['price'];
                            $result = selectProduct("SELECT * FROM products WHERE product_id = ".$cart_item['product_id']);
                            $quantity = $cart_item['quantity'];
                            if ($quantity > $result['quantity_product']) {
                                echo '<script>
                                    Swal.fire({
                                        title: "Xin lỗi bạn!",
                                        text: "Đơn hàng của bạn vượt quá số lượng trong kho của chúng tôi!",
                                        icon: "error"
                                    });
                                </script>';
                                $quantity = $result['quantity_product'];
                            }
                            $total = $price * $quantity;
                            $priceF = number_format($price,0,',','.');
                            $totalF = number_format($total,0,',','.');
                            $totalPrice += $total;
                        ?>
                        <div class="product-item">
                            <div class="product-img">
                                <img src="<?=$cart_item['product_image']?>" alt="">
                                <span><?=$quantity?></span>
                            </div>
                            <div class="name-product">
                                <h4><?=$cart_item['product_name']?></h4>
                            </div>
                            <div class="price"><span><?=$priceF?></span><sup>đ</sup></div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="voucher">
                        <form action="">
                            <input type="text" placeholder="Mã giảm giá">
                            <button disabled>Sử dụng</button>
                        </form>
                    </div>
                    <div class="prepare">
                        <div class="price-product">
                            <span>Tạm tính</span>
                            <p><span><?php echo number_format($totalPrice,0,',','.'); ?></span><sup>đ</sup></p>
                        </div>
                        <div class="price-ship">
                            <span>Tiền vận chuyển</span>
                            <?php $priceShip = $totalPrice > 500000 ? 'Free ship' : '30.000<sup>đ</sup>'; ?>
                            <p><span><?=$priceShip?></span></p>
                        </div>
                    </div>
                    <div class="sum-price">
                        <span>Tổng cộng</span>
                        <?php $priceShip = $totalPrice > 500000 ? 0 : 30000; ?>
                        <p><span><?php $num = $totalPrice + $priceShip; echo number_format($num,0,',','.'); ?></span><sup>đ</sup></p>
                    </div>
                </div>
            </aside>
        </div>
        <?php include '../footer.php' ?>
    </main>
    <script src="../../assets/js/pay.js"></script>
    <script src="../../assets/js/header.js"></script>
</body>
</html>