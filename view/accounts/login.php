<?php 
    require "../../config/connectDB.php";
    require "../../model/dao-users.php";
    require "../../model/dao-products.php";
    require "../../model/dao-categories.php";
    require "../../model/dao-blogs.php";
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
            $psw = trim($_POST['psw']);
            $sql = "SELECT * FROM users WHERE email = '$filterEmail'";
            $row = selectUsers($sql);
            if ($row != null) {
                $role = $row['role'];
                $status = $row['status'];
                $user_id = $row['user_id'];
                $password = $row['password'];

                if ($status === 'Chưa kích hoạt') {
                    $errorEmail = 'Tài khoản chưa được kích hoạt';
                } else if ($status === 'Vô hiệu hóa') {
                    $errorEmail = 'Tài khoản đã bị vô hiệu hóa';
                } else {
                    if (password_verify($psw, $password)) {
                        $_SESSION['userName'] = $user_name;
                        $_SESSION['role'] = $role;
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['status'] = $status;
                        header('Location: ../pages/home.php');
                    }else {
                        $errorPsw = 'Mật khẩu không đúng';
                    }
                }
            }else {
                $errorEmail = 'email không tồn tại';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/login.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/login.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <article>
            <div class="form-login">
                <div class="form-img">
                    <img src="../../assets/img/Free Vector _ Smart home concept illustration.jpg" alt="">
                </div>
                <div class="form-main">
                    <h3>Đăng nhập</h3>
                    <form method="POST" action="" id="registration-form">
                        <div class="form-item">
                            <input id="email" name="email" type="text" placeholder="Email của bạn">
                            <span class="form-error" id="email-error"><?php if (isset($errorEmail)) echo $errorEmail ?></span>
                        </div>
                        <div class="form-item">
                            <div class="inp">
                                <input id="psw" name="psw" type="password" placeholder="Mật khẩu">
                                <i id="eye" class="fa-regular fa-eye-slash"></i>
                            </div>
                            <span class="form-error" id="psw-error"><?php if (isset($errorPsw)) echo $errorPsw ?></span>
                        </div>
                        <div class="forgot-psw"><a href="./forgotPsw.php">Bạn quên mật khẩu?</a></div>
                        <div class="btn-login">
                            <button name="submit">Đăng nhập</button>
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
                        <div class="link-register">Bạn đã có tài khoản? <a href="./register.php">Đăng ký</a></div>
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
    <script src="../../assets/js/login.js"></script>
</body>
</html>