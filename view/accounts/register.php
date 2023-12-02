<?php 
    require "../../config/global.php";
    require "../../config/connectDB.php";
    require "../../model/dao-users.php";
    require "../../model/dao-products.php";
    require "../../model/dao-categories.php";
    require "../../PHPMailer/sendmail.php";
    require "../../model/dao-blogs.php";
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            $userName = $_POST['user-name'];
            $email = $_POST['email'];
            $psw = trim($_POST['psw']);
            $hashedPsw = password_hash($psw, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(16));
            $count = selectUsers("select * from users where email='$email' ");
            if ($count == null) {
                $sql = "INSERT INTO users (user_name, email, password, role, status, token, create_date) 
                VALUES ('$userName', '$email', '$hashedPsw', 'Khách hàng', 'Chưa kích hoạt', '$token', NOW())";
                $query = cudUsers($sql);
                if ($query) {
                    $title = "Xác nhận đăng ký, kích hoạt tài khoản";
                    $content = "Để kích hoạt tài khoản click <a style='padding: 10px 20px; background-color:#004230; text-decoration: none; color:#fff;' href='$url/view/accounts/confirm.php?token=$token'>vào đây</a>"; 
                    $sendMail = send_mail($email, $title, $content, '');
                    if ($sendMail) {
                        header ('location: check-mail.php');
                    }
                }
            }else {
                $error = 'email đã tồn tại';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/register.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/register.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <article>
            <div class="form-register">
                <div class="form-img">
                    <img src="../../assets/img/Free Vector _ Smart home concept illustration.jpg" alt="">
                </div>
                <div class="form-main">
                    <h3>Đăng ký</h3>
                    <form method="POST" action="" id="registration-form">
                        <div class="form-item">
                            <label for="user-name">Tên người dùng (<span style="color:red;"> * </span>)</label>
                            <input id="user-name" name="user-name" type="text" placeholder="Tên người dùng">
                            <span class="form-error" id="user-name-error"></span>
                        </div>
                        <div class="form-item">
                            <label for="email">Email (<span style="color:red;"> * </span>)</label>
                            <input id="email" name="email" type="text" placeholder="Email của bạn">
                            <span class="form-error" id="email-error"><?php if (isset($error)) echo $error ?></span>
                        </div>
                        <div class="form-item">
                            <label for="psw">Mật khẩu (<span style="color:red;"> * </span>)</label>
                            <div class="inp">
                                <input id="psw" name="psw" type="password" placeholder="Mật khẩu">
                                <i id="eye" class="fa-regular fa-eye-slash"></i>
                            </div>
                            <span class="form-error" id="psw-error"></span>
                        </div>
                        <div class="form-item">
                            <label for="confirm-psw">Nhập lại mật khẩu (<span style="color:red;"> * </span>)</label>
                            <div class="inp">
                                <input id="confirm-psw" name="confirm-psw" type="password" placeholder="Nhập lại mật khẩu">
                                <i id="eye_2" class="fa-regular fa-eye-slash"></i>
                            </div>
                            <span class="form-error" id="confirm-psw-error"></span>
                        </div>
                        <div class="btn-register">
                            <button name="submit" type="submit">Đăng ký</button>
                        </div>
                        <div class="or">
                            <span></span>
                            <span>Hoặc</span>
                            <span></span>
                        </div>
                        <div class="fb-gg">
                            <div onclick="eventClick()" class="btn-fb">
                                <img src="../../assets/img/fb-gg/fb.png" alt="">
                                <span>Facebook</span>
                            </div>
                            <div onclick="eventClick()" class="btn-fb">
                                <img src="../../assets/img/fb-gg/gg.png" alt="">
                                <span>Google</span>
                            </div>
                        </div>
                        <div class="link-login">Bạn đã có tài khoản? <a href="./login.php">Đăng nhập</a> </div>
                        <div class="confirm-submit">
                            <div class="confirm-submit-item">
                                <input id="checkbox" type="checkbox">
                                <label for="checkbox">Bằng việc đăng ký, bạn đã đồng ý về <a href="">điều khoản dịch vụ</a> & <a href="">chính sách bảo mật</a></label>
                            </div>
                            <div class="form-error" id="checkbox-error"></div>
                        </div>
                    </form>
                </div>
            </div>
        </article>
        <!-- ----------------footer----------------- -->
        <?php include "../footer.php"; ?>
    </main>
    <script>
        function eventClick() {
            Swal.fire({
                title: "Xin lỗi bạn!",
                text: "Chức năng này mình chưa làm!",
                icon: "info",
                timer: 3000
            });
        }
    </script>
    <script src="../../assets/js/header.js"></script>
    <script src="../../assets/js/register.js"></script>
</body>
</html>