<?php 
    require "../../config/global.php";
    require "../../config/connectDB.php";
    require "../../model/dao-users.php";
    require "../../PHPMailer/sendmail.php";
    require "../../model/dao-categories.php";
    require "../../model/dao-blogs.php";
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <style>
        article form {
            margin: 100px auto;
            width: 400px;
            height: 200px;
            box-shadow: rgb(0 0 0 / 10%) 1px 1px 5px 5px;
            display: flex;
            flex-direction: column;
            border-radius: 8px;
        }

        article input, button {
            width: 90%;
            height: 45px;
            margin: 10px auto;
            border: none;
            border: 2px solid #ccc;
            font-family: 'Inclusive Sans', sans-serif;
            border-radius: 5px;
        }

        article input{
            margin-top: 40px;
            padding-left: 10px;
        }

        article button{
            background-color: var(--green-color);
            color: var(--white-color);
            transition: all 0.4s ease;
            cursor: pointer;
        }

        article button:hover{
            opacity: 0.7;
        }

        article input:focus {
            outline: none;
            border: 2px solid var(--green-color);
        }

        .error {
            width: 90%;
            margin: -5px auto 5px;
            color: red;
        }

        @media (max-width: 30.625em) {
            article form {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            $otp = rand(111111,999999);
            $email = $_POST['email'];
            $query = selectUsers("SELECT * FROM users WHERE email = '$email'");
            if ($query != null) {
                $sql = "UPDATE users SET otp = $otp WHERE email = '$email'";
                $result = cudUsers($sql);
                if ($result) {
                    $title = "Reset password";
                    $content = "Nhấp vào liên kết để đổi mật khẩu <a href='$url/view/accounts/resetPsw.php?otp=$otp'>Tại đây</a>";
                    $massage = "";
                    $sendMail = send_mail($email, $title, $content, $massage);
                    if ($sendMail) {
                        echo "<script>
                        Swal.fire({
                               title: 'Gửi mail thành công!',
                               text: 'Vui lòng check mail để đổi mật khẩu!',
                               icon: 'success',
                               timer: 3000
                           });
                        </script>";
                    }
                }
            }else {
                $errorEmail = "Tài khoản này không tồn tại";
            }
        }
    }
    ?>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <article>
            <form action="" method="post">
                <input required type="email" name="email" placeholder="Nhập email của bạn">
                <span class="error"><?php if (isset($errorEmail)) echo $errorEmail ?></span>
                <button name="submit">Gửi mail</button>
            </form>
        </article>
        <!-- ----------------footer----------------- -->
        <?php include "../footer.php"; ?>
    </main>
    <script src="../../assets/js/header.js"></script>
</body>
</html>