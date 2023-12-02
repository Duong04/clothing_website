<?php 
    require "../../config/connectDB.php";
    require "../../model/dao-users.php";
    require "../../model/dao-products.php";
    require "../../model/dao-categories.php";
    require "../../model/dao-blogs.php";
    require "../../PHPMailer/sendmail.php";
    session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/contact.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/contact.css">
</head>
<body>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $content = '<h3>Thông tin liên hệ của khách hàng</h3>
                        <div class="name"><strong>Tên người liên hệ</strong> &emsp;'.$name.'</div>
                        <br>
                        <div class="phone"><strong>số điện thoại:</strong> &emsp;<a style="text-decoration: none; padding: 5px 20px; background-color: #004230; color: #fff; border-radius: 10px;" href="tel:'.$phone.'">'.$phone.'</a></div>
                        <br>
                        <div class="phone"><strong>Email liện hệ:</strong> &emsp;<a style="text-decoration: none; padding: 5px 20px; background-color: #004230; color: #fff; border-radius: 10px;" href="mailto:'.$email.'">'.$email.'</a></div>
                        <br>
                        <div class="content"><strong>Nội dung của khách hàng:</strong> &emsp;'.
                            $_POST['content']
                        .'</div>';
            $sendMail = send_mail('duongnt3092004@gmail.com','Thông tin liên hệ của khách hàng', $content, '');
            if ($sendMail) {
                echo '<script>
                        Swal.fire({
                                title: "Thành công!",
                                text: "Chúng tôi đã nhận được thông tin của bạn sẽ sớm liên hệ lại!💖",
                                icon: "success",
                                timer: 5000
                        });
                    </script>';
            }
        }
    ?>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <article>
            <h3>Liên hệ</h3>
            <div class="container">
                <div data-aos="fade-right" class="content-left">
                    <h4>Gửi tin nhắn cho SUGAR</h4>
                    <p>khi bạn cần hỗ trợ hoặc có thắc mắc nhé:</p>
                    <div class="form-contact">
                        <form method="POST" action="">
                            <div class="form-item">
                                <input name="name" type="text" placeholder="Họ và tên">
                            </div>
                            <div class="form-item form-item-2">
                                <input name="phone" type="text" placeholder="Số điện thoại">
                                <input name="email" type="email" placeholder="Email">
                            </div>
                            <div class="form-item">
                                <textarea name="content" id="" rows="5" placeholder="Nội dung"></textarea>
                            </div>
                            <div class="form-item">
                                <button>Gửi</button>
                            </div>
                        </form>
                    </div>
                    <div class="info-contact">
                        <h4>Thông tin liên hệ</h4>
                        <div class="info">
                            <ul class="contact-list">
                                <li><span>Hotline: &emsp;<strong>0815416086</strong></span><a href="tel:0815416086">Gọi ngay</a></li>
                                <li><span>Email: &emsp;<strong>duongnt3092004@gmail.com</strong></span><a href="mailto:duongnt3092004@gmail.com">Gửi ngay</a></li>
                                <li><span>Chatbot: &emsp;<strong>Messenger</strong></span><a href="">Nhắn ngay</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div data-aos="fade-left" class="content-right"><img src="../../assets/img/contact/bgr-contact.jpg" alt=""></div>
            </div>
        </article>
        <!-- ----------------footer----------------- -->
        <?php include "../footer.php"; ?>
    </main>
    <script>
        AOS.init({
            duration: 1000,
        });
    </script>
    <script src="../../assets/js/header.js"></script>
</body>
</html>