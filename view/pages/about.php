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
    <title>Liên hệ - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/about.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/about.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <article>
            <h3>Giới thiệu</h3>
            <div class="container">
                <div data-aos="fade-right" class="content-page">
                    <h3>Chào mừng bạn đến với SUGAR - Nơi nở rộ phong cách!</h3>
                    <h3>🌟 Giới thiệu về SUGAR 🌟</h3>
                    <h4>👗 SUGAR - Nơi Nở Rộ Phong Cách</h4>
                    <p>
                        Chào mừng bạn đến với SUGAR, điểm đến lý tưởng cho những người yêu thời trang và muốn 
                        thể hiện phong cách cá nhân của mình. Tại đây, chúng tôi tự hào mang đến cho bạn những 
                        trải nghiệm mua sắm trực tuyến độc đáo và thú vị nhất.
                    </p>
                    <h4>🌈 Đa Dạng Phong Cách</h4>
                    <p>
                        SUGAR không chỉ là một trang web bán hàng, mà là nơi bạn có thể khám phá và tận hưởng sự 
                        đa dạng trong thế giới thời trang. Chúng tôi cung cấp một bộ sưu tập đa dạng các sản phẩm 
                        từ trang phục hàng ngày đến trang điểm, giày dép, và phụ kiện, giúp bạn tạo ra phong cách 
                        riêng biệt và thú vị.
                    </p>
                    <h4>🌟 Chất Lượng Đỉnh Cao</h4>
                    <p>
                        Tại SUGAR, chúng tôi cam kết đem đến cho bạn những sản phẩm chất lượng hàng đầu từ những 
                        thương hiệu uy tín và các nhà thiết kế hàng đầu trên thị trường thời trang. Chất liệu tốt 
                        nhất và sự chăm sóc tỉ mỉ trong từng đường may là cam kết của chúng tôi để bạn luôn tự tin 
                        khi diện những bộ trang phục từ SUGAR.
                    </p>
                    <h4>🌐 Giao Hàng Nhanh Chóng, Dịch Vụ Chăm Sóc Khách Hàng Tận Tâm</h4>
                    <p>
                        Chúng tôi hiểu rằng thời gian là quan trọng. Đó là lý do tại SUGAR, chúng tôi luôn nỗ lực để đảm 
                        bảo quá trình giao hàng nhanh chóng và an toàn nhất cho bạn. Đồng thời, đội ngũ chăm sóc khách 
                        hàng của chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc, đảm bảo rằng mọi trải nghiệm mua sắm của bạn 
                        đều là một trải nghiệm tuyệt vời.
                    </p>
                    <h4>💖 Nâng Tầm Phong Cách Cùng SUGAR</h4>
                    <p>
                        Hãy tham gia cùng SUGAR ngay hôm nay để khám phá thế giới thời trang đẳng cấp. Với SUGAR, phong cách của bạn sẽ nở rộ và làm nổi bật cái tôi của bạn mỗi ngày!
                    </p>
                    <h4>SUGAR - Nơi nở rộ phong cách, nơi bạn là ngôi sao! ✨</h4>
                </div>
                <hr>
                <div class="map">
                    <h3>Địa chỉ Shop 💖</h3>
                    <iframe data-aos="fade-up" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.0669586163385!2d108.17629847449629!3d16.062014784616363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142190356264cd7%3A0xc87deefcb21b78ae!2zTmfDoyBCYSBIdeG6vywgxJDDoCBO4bq1bmcgNTUwMDAwLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1700228562652!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
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