<?php 
    require "../../config/connectDB.php";
    require "../../model/dao-products.php";
    require "../../model/dao-categories.php";
    require "../../model/dao-users.php";
    require "../../model/dao-blogs.php";
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/user-account.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/user-account.css">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])) { ?>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <article>
        <?php 
            if (isset($_SESSION['user_id'])){
                $id = $_SESSION['user_id'];
            }
            $row = selectUsers("SELECT * FROM users WHERE user_id = $id");
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['update'])) {
                    
                    $userName = $_POST['user_name'];
                    $phone = $_POST['phone'];
                    $address = $_POST['address'];
                    $email = $_POST['email'];
                    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                        $target_dir = '../../upload_img/';
                        $target_file = $target_dir . basename($_FILES['image']['name']);
                        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                        $sql = "UPDATE users SET user_name = '$userName', user_image = '$target_file', phone_number = $phone, address = '$address', email = '$email' WHERE user_id = $id";
                    } else {
                        $sql = "UPDATE users SET user_name = '$userName', phone_number = $phone, address = '$address', email = '$email' WHERE user_id = $id";
                    }
                    $query = cudUsers($sql);
                    if ($query) {
                        echo '<script>
                        Swal.fire({
                            title: "Thành công!",
                            text: "Cập nhật thông tin thành công!",
                            icon: "success",
                            timer: 1000
                        });
                        setTimeout(function() {
                            window.location.href = "./user-account.php";
                        },1000);
                        </script>';
                    }
                }
            }
        ?>
            <h3>Thông tin của tôi</h3>
            <div class="profile">
                <form id="myForm" action="" method="post" enctype="multipart/form-data">
                    <div class="avatar">
                        <div for="file" class="avatar-img">
                            <?php 
                            $img = '../../assets/img/143086968_2856368904622192_1959732218791162458_n.png';
                            $image = $row['user_image'] != null ? $row['user_image'] : $img;
                            ?>
                            <label for="file" class="avatar-item">
                                <img id="preview" src="<?=$image?>" alt="">
                            </label>
                            <input id="file" name="image" type="file" hidden>
                            <label class="icon-camera" for="file"><i class="fa-solid fa-camera"></i></label>
                        </div>
                        <h4><?=$row['user_name']?></h4>
                        <div class="logout">
                            <a href="../accounts/logout.php">Đăng xuất <i class="fa-solid fa-right-from-bracket"></i></a>
                        </div>
                    </div>
                    <div class="info-user">
                        <h4>Thông tin</h4>
                        <div class="form-item">
                            <label for="">Tên người dùng</label>
                            <input name="user_name" value="<?=$row['user_name']?>" required type="text" placeholder="Tên người dùng">
                        </div>
                        <div class="form-item">
                            <label for="">Số điện thoại</label>
                            <input name="phone" value=" <?=$row['phone_number']?>" required type="text" placeholder="Số điện thoại">
                        </div>
                        <div class="form-item">
                            <label for="">Địa chỉ</label>
                            <input name="address" value="<?=$row['address']?>" required type="text" placeholder="Địa chỉ của bạn">
                        </div>
                        <div class="form-item">
                            <label for="">Email</label>
                            <input name="email" value="<?=$row['email']?>" required type="email" placeholder="email">
                        </div>
                        <div class="btn-update">
                            <button id="update" name="update">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </article>
        <!-- ----------------footer----------------- -->
        <?php include "../footer.php"; ?>
    </main>
    <?php } ?>
    <script src="../../assets/js/header.js"></script>
    <script>
        const inputElement = document.getElementById("file");

        inputElement.addEventListener("change", handleFiles);

        function handleFiles() {
            const fileList = this.files;
            if (!fileList.length) {
                return;
            }

            const file = fileList[0];
            const reader = new FileReader();

            reader.onload = function () {
                const preview = document.getElementById("preview");
                preview.src = reader.result;
            };

            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>