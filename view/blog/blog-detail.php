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
    <?php 
    if (isset($_GET['blog_id'])) {
        $id = $_GET['blog_id'];
    }
    $name = selectBlog("SELECT * FROM blogs WHERE blog_id = $id");
    ?>
    <title><?=$name['title']?> - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/blog-detail.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/blog-detail.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <div class="container">
            <div class="container-flex">
                <!-- ---------------- article ------------------- -->
                <article>
                    <?php 
                    if (isset($_GET['blog_id'])) {
                        $id = $_GET['blog_id'];
                        $content = selectBlog("SELECT B.*,C.*,U.*, B.create_date AS blog_create_date 
                        FROM blogs AS B INNER JOIN users AS U ON B.user_id = U.user_id
                        INNER JOIN blog_category AS C ON B.blog_categoryId = C.blog_categoryId 
                        WHERE B.blog_id = $id");
                        $idC = $content['blog_categoryId'];
                    ?>
                    <div class="category"><?=$content['category_name']?></div>
                    <div class="title"><?=$content['title']?></div>
                    <div class="user-createDate"><span><?=$content['user_name']?></span> - <i><?=$content['blog_create_date']?></i></div>
                    <div class="content-blog">
                        <?=$content['blog_content']?>
                    </div>
                    <?php } ?>
                </article>
                <!-- ---------------- aside --------------------- -->
                <?php 
                include "../blog/aside-blog.php";
                ?>
            </div>
            <hr>
            <h3>Bài viết liên quan</h3>
            <div class="post-tail">
                <div class="grid-post-tail">
                    <?php 
                    $sql = $sql = "SELECT B.*, C.*, U.*, B.create_date AS blog_create_date 
                    FROM blogs AS B 
                    INNER JOIN users AS U ON B.user_id = U.user_id
                    INNER JOIN blog_category AS C ON B.blog_categoryId = C.blog_categoryId
                    WHERE B.blog_id != $id AND C.blog_categoryId = $idC
                    LIMIT 8";
                    $listAll = selectBlogsAll($sql);
                    foreach ($listAll as $list) {
                    ?>
                    <div class="grid-post-item">
                        <a href="../blog/blog-detail.php?blog_id=<?=$list['blog_id']?>">
                            <div data-aos="fade-down" class="grid-post-img">
                                <img src="<?=$list['blog_image']?>" alt="">
                            </div>
                            <div data-aos="fade-up" class="grid-post-text">
                                <h3><?=$list['category_name']?></h3>
                                <h4><?=$list['title']?></h4>
                                <div class="post-date"><i><?=$list['blog_create_date']?></i></div>
                                <div class="description"><?=$list['blog_description']?></div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
        </div>
        <!-- ----------------footer----------------- -->
        <?php include "../footer.php"; ?>
    </main>
    <script src="../../assets/js/header.js"></script>
    <script>
        AOS.init({
            duration: 1000,
        });
    </script>
</body>
</html>