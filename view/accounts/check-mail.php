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
    <title>Check email - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <style>

        article {
            margin: 50px 0;
        }

        .nottify-img {
            max-width: 500px;
            margin: auto;
            text-align: center;
        }
        .nottify-img img {
            width: 100%;
        }

        .nottify-text {
            max-width: 85%;
            margin: auto;
            line-height: 27px;
        }

        .nottify-text a {
            color: blue;
        }
    </style>
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <article>
            <div class="nottify-text">
                <p>Chào bạn !</p>
                <p>Chúc mừng bạn đã đăng ký tài khoản với chúng tôi!</p>
                <p>Chúng tôi đã gửi một <strong>email kích hoạt tài khoản đến địa chỉ email</strong>  mà bạn đã đăng ký. Để hoàn tất quá trình đăng ký, <strong>vui lòng kiểm tra hộp thư đến của bạn và nhấp vào liên kết kích hoạt được gửi trong email</strong> . Nếu bạn không tìm thấy email trong hộp thư đến, vui lòng kiểm tra thư mục thư rác hoặc thư mục "Spam".</p>
                <p>Nếu bạn gặp bất kỳ khó khăn nào trong việc kích hoạt tài khoản hoặc cần sự hỗ trợ bổ sung, đừng ngần ngại liên hệ với chúng tôi qua trang web hoặc qua địa chỉ email hỗ trợ của chúng tôi tại <a href="mailto:duongnt3092004@gmail.com">duongnt3092004@gmail.com</a>. Chúng tôi luôn sẵn sàng hỗ trợ bạn.</p>
                <p>Trân trọng !</p>
            </div>
            <div class="nottify-img">
                <img src="../../assets/img/8d4f7f858274a4a0eb507b49aee66385-removebg-preview.png" alt="">
            </div>
        </article>
        <!-- ----------------footer----------------- -->
        <?php include "../footer.php"; ?>
    </main>
    <script src="../../assets/js/header.js"></script>
</body>
</html>