<?php 
    require "../../config/global.php";
    require "../../config/connectDB.php";
    require "../../model/dao-users.php";
    require "../../model/dao-products.php";
    require "../../model/dao-categories.php";
    require "../../model/dao-blogs.php";
    session_start();

    if (isset($_GET['otp'])){
        $otp = $_GET['otp']; 
    }

    $checkTokenQuery = selectUsers("SELECT * FROM users WHERE otp = $otp");
    extract($checkTokenQuery);
    if(isset($_POST['psw']) && isset($_POST['confirm-psw'])) {
        $psw = $_POST['psw'];
        if (strlen($psw) < 7){
            $error = 'Mật khẩu phải hơn 6 kí tự';
        }else {
            $hashedPsw = password_hash($psw, PASSWORD_DEFAULT);
            $confirm_psw = $_POST['confirm-psw'];
            if (password_verify($confirm_psw, $hashedPsw)){
                $sql = $sql = "UPDATE users SET password = '$hashedPsw', otp = 0 WHERE email = '$email'";
                if (cudUsers($sql)){
                    header('location: login.php');
                }
            }else {
                $error = 'Mật khẩu nhập lại không đúng';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật mật khẩu - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
        .container{
            width: 100%;
            height: 100vh;
            background-color: #fff;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container .form{
            color: #fff;
            position: relative;
            margin: auto;
            width: 400px;
            height: 320px;
            border: 2px solid #004230;
            border-radius: 15px;
        }

        .form h2{
            color: #004230;
            text-shadow: 0 0 3px #fff;
            text-align: center;
            padding-top: 16px;
            font-size: 1.2rem;
        }

        .confirm-password,
        .password,
        .email{
            width: 90%;
            margin: 10px auto;
            display: flex;
            flex-direction: column;
            color: #000;
        }

        .form input{
            margin: 10px 0 0;
            height: 38px;
            padding-left: 10px;
            border-radius: 8px;
            border: none;
            border: 2px solid #ccc;
        }

        .form input:focus{
            border: none;
            outline: none;
            border: 2px solid #004230;
        }

        a{
            text-decoration: none;
            color: #004230;
        }

        a:hover{
            text-decoration: underline;
        }
        
        .btn{
            width: 90%;
            margin:20px auto;
        }

        .btn button{
            position: relative;
            width: 100%;
            height: 40px;
            border: none;
            background-color: #fff;
            border-radius: 8px;
            cursor: pointer;
            background-color: #004230;
            font-weight: 600;
            color: #fff;
            font-size: 1.1rem;
        }

        .btn button:hover{
            opacity: 0.8;
        }

        .link{
            text-align: center;
            margin-top: 10px;
        }

        .erorr{
            width: 90%;
            margin: 10px auto;
            color: red;
        }

        @media (max-width: 30em) {
            .container .form{
                width: 90%;
            }
        }

    </style>
</head>
<body>
<div class="container">
        <div class="form">
            <h2>Đặt lại mật khẩu</h2>
            <form action="" method="POST">
                <div class="password">
                    <label for="psw">Password</label>
                    <input type="password" id="psw" name="psw" placeholder="Mật khẩu" required>
                </div>
                <div class="confirm-password">
                    <label for="confirm-psw">Confirm password</label>
                    <input type="password" id="confirm-psw" name="confirm-psw" placeholder="Nhập lại mật khẩu" required>
                    <span class="erorr"><?php if(isset($error)) echo $error; ?></span>
                </div>
                <div class="btn">
                    <button>Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>