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
        if (isset($_GET['category_id'])) {
            $id = $_GET['category_id'];
            $listC = selectBlog("SELECT * FROM blog_category WHERE blog_categoryId = $id");
        ?>
    <title>Blog <?=$listC['category_name']?> - SUGAR - Streetwear brand</title>
    <?php } else { ?>
    <title>Tất cả bài viết - SUGAR - Streetwear brand</title>
    <?php } ?>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/blog.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/blog.css">
</head>
<body>
    <main>
        <?php include "../header.php"; ?>
        <!-- ---------------- article ------------------- -->
        <?php 
        if (isset($_GET['category_id'])) {
            $id = $_GET['category_id'];
            $row = selectBlog("SELECT B.*,C.*,U.*, B.create_date AS blog_create_date 
            FROM blogs AS B INNER JOIN users AS U ON B.user_id = U.user_id
            INNER JOIN blog_category AS C ON B.blog_categoryId = C.blog_categoryId 
            WHERE B.blog_categoryId = $id
            ORDER BY B.create_date DESC LIMIT 1");
            if ($row != null){
            $idB = $row['blog_id'];
        ?>
        <div class="container">
            <h3><?=$row['category_name']?></h3>
            <div class="container-flex">
                <article>
                    <div class="post-main">
                        <a href="../blog/blog-detail.php?blog_id=<?=$row['blog_id']?>">
                            <div data-aos="fade-down" class="post-main-img">
                                <img src="<?=$row['blog_image']?>" alt="">
                            </div>
                            <div data-aos="fade-right" class="post-main-text">
                                <h3><?=$row['category_name']?></h3>
                                <h4><?=$row['title']?></h4>
                                <div class="post-date"><i><?=$row['blog_create_date']?></i></div>
                                <div class="description"><?=$row['blog_description']?></div>
                            </div>
                        </a>
                    </div>
                </article>
                <!-- ------------------- aside ---------------------- -->
                <?php include "../blog/aside-blog.php"; ?>
            </div>
            <hr>
            <h3>Tất cả bài viết</h3>
            <div class="post-tail">
                <div class="grid-post-tail">
                    <?php 
                    $sql = $sql = "SELECT B.*, C.*, U.*, B.create_date AS blog_create_date 
                    FROM blogs AS B 
                    INNER JOIN users AS U ON B.user_id = U.user_id
                    INNER JOIN blog_category AS C ON B.blog_categoryId = C.blog_categoryId
                    WHERE B.blog_id != $idB AND B.blog_categoryId = $id";
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
                    <?php }?>
                </div>
            </div>
            <?php }else { ?>
                <h2 style="text-align:center; margin: 50px 0;">Hiện chưa có bài viết ❤️!!</h2>
            <?php } ?>
        </div>
        <?php }else{ ?>
        <div class="container">
            <h3>Tất cả bài viết</h3>
            <div class="container-flex">
                <article>
                    <?php 
                    $row = selectBlog("SELECT B.*,C.*,U.*, B.create_date AS blog_create_date 
                            FROM blogs AS B INNER JOIN users AS U ON B.user_id = U.user_id
                            INNER JOIN blog_category AS C ON B.blog_categoryId = C.blog_categoryId 
                            ORDER BY B.create_date DESC LIMIT 1");
                    ?>
                    <div class="post-main">
                        <a href="../blog/blog-detail.php?blog_id=<?=$row['blog_id']?>">
                            <div data-aos="fade-down" class="post-main-img">
                                <img src="<?=$row['blog_image']?>" alt="">
                            </div>
                            <div data-aos="fade-right" class="post-main-text">
                                <h3><?=$row['category_name']?></h3>
                                <h4><?=$row['title']?></h4>
                                <div class="post-date"><i><?=$row['blog_create_date']?></i></div>
                                <div class="description"><?=$row['blog_description']?></div>
                            </div>
                        </a>
                    </div>
                    <hr>
                    <div class="post-new">
                        <h3>Bài viết mới nhất</h3>
                        <div class="grid-post">
                            <?php
                            $id = $row['blog_id'];
                            $id2 = array();
                            $sql = "SELECT B.*,C.*,U.*, B.create_date AS blog_create_date 
                                    FROM blogs AS B 
                                    INNER JOIN users AS U ON B.user_id = U.user_id
                                    INNER JOIN blog_category AS C ON B.blog_categoryId = C.blog_categoryId
                                    WHERE B.blog_id != $id 
                                    ORDER BY B.create_date DESC LIMIT 3";
                            $listNew = selectBlogsAll($sql);
                            foreach ($listNew as $list) {
                            ?>
                            <div class="grid-post-item">
                                <a href="../blog/blog-detail.php?blog_id=<?=$list['blog_id']?>">
                                    <div data-aos="fade-down" class="grid-post-img">
                                        <img src="<?=$list['blog_image']?>" alt="">
                                    </div>
                                    <div data-aos="fade-up" class="grid-post-text">
                                        <h3><?=$list['category_name']?></h3>
                                        <h4><?=$list['title']?></h4>
                                        <div class="post-date"><i><?=$row['blog_create_date']?></i></div>
                                        <div class="description"><?=$list['blog_description']?></div>
                                    </div>
                                </a>
                            </div>
                            <?php $id2[] = $list['blog_id']; } ?>
                        </div>
                    </div>
                </article>
                <!-- ------------------- aside ---------------------- -->
                <?php include "../blog/aside-blog.php"; ?>
            </div>
            <hr>
            <h3>Tất cả bài viết</h3>
            <div class="post-tail">
                <div class="grid-post-tail">
                    <?php 
                    $sql = $sql = "SELECT B.*, C.*, U.*, B.create_date AS blog_create_date 
                    FROM blogs AS B 
                    INNER JOIN users AS U ON B.user_id = U.user_id
                    INNER JOIN blog_category AS C ON B.blog_categoryId = C.blog_categoryId
                    WHERE B.blog_id != $id";
                    foreach ($id2 as $blogId) {
                        $sql .= " AND B.blog_id != $blogId";
                    }
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
            </div>
        </div>
        <?php } ?>
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