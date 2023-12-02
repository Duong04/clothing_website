        <header>
            <div class="topbar-des">Miễn phí ship giao hàng toàn quốc với đơn hàng trên 500.000đ</div>
            <div class="header-main">
                <div class="header-child-top">
                    <div class="header-left">
                        <!-- Menu mobile -->
                        <input hidden type="checkbox" name="" id="nav-bar-block">
                        <label for="nav-bar-block" class="menu-mobile"></label>
                        <div class="menu-mobile-item">
                            <ul>
                                <li><a href="../pages/home.php">Trang chủ</a></li>
                                <li>
                                    <a class="defaut" href="#"><span>Cửa hàng</span> <i class="fa-solid fa-chevron-down"></i></a>
                                    <ul class="menu_item-2">
                                        <li><a href="../pages/categories.php">Tất cả các sản phẩm</a></li>
                                        <?php 
                                        $row = selectCategoryAll("SELECT * FROM categories");
                                        foreach ($row as $list){
                                        ?>
                                        <li><a href="../pages/categories.php?category_id=<?=$list['category_id']?>"><?=$list['category_name']?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li>
                                    <a class="defaut" href="#"><span>Bài viết</span> <i class="fa-solid fa-chevron-down"></i></a>
                                    <ul class="menu_item-2">
                                    <li><a href="../blog/blog.php">Tất cả bài viết</a></li>
                                    <?php 
                                    $row = selectBlogsAll("SELECT * FROM blog_category");
                                    foreach ($row as $list){
                                    ?>
                                    <li><a href="../blog/blog.php?category_id=<?=$list['blog_categoryId']?>"><?=$list['category_name']?></a></li>
                                    <?php } ?>
                                    </ul>
                                </li>
                                <li><a href="../pages/contact.php">Liên hệ</a></li>
                                <li><a href="../pages/about.php">Giới thiệu</a></li>
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                <li><a href="../pay/order.php">Đơn hàng</a></li>
                                <?php } ?>
                                <?php 
                                if (isset($_SESSION['role'])){
                                    if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Nhân viên') {
                                ?>
                                <li><a href="../../admin/layout/index.php?action=statistical">Admin</a></li>
                                <?php } } ?>
                            </ul>
                            <label for="nav-bar-block" class="close"><i class="fa-solid fa-xmark"></i></label>
                        </div>
                        <label for="nav-bar-block" class="bar-mobile"><i class="fa-solid fa-bars"></i></label>
                        <!-- ----------------------------------- -->
                        <div class="language"><img src="../../assets/img/flag-vie2.webp" alt=""></div>
                        <div class="search">
                            <form action="../pages/search.php" method="POST" class="input-wrapper">
                                <button class="icon"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <input id="search" name="search" class="input" type="text" placeholder="Bạn muốn tìm gì...">
                            </form>
                            <div class="result-seach">
                                <div class="result" id="search-results">

                                </div>
                            </div>
                        </div>
                        <!-- Search mobile -->
                        <input hidden type="checkbox" name="" id="search-block">
                        <label for="search-block" class="search-mobile2"></label>
                        <div class="search-2">
                            <h3>Tìm kiếm tại đây</h3>
                            <form action="../pages/search.php" method="POST">
                                <input id="search-2" name="search" type="text" placeholder="Bạn muốn tìm gì...">
                                <button ><i class="fa-solid fa-magnifying-glass"></i></button>
                                <div class="result-seach">
                                    <div class="result-2" id="search-results-2">
                                
                                    </div>
                                </div>
                            </form>
                            <label for="search-block" class="close"><i class="fa-solid fa-xmark"></i></label>
                        </div>
                        <label for="search-block" class="search-mobile"><i class="fa-solid fa-magnifying-glass"></i></label>
                        <!-- ------------- -->
                    </div>
                    <div class="header-center">
                        <a href="">
                            <img src="../../assets/img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="header-right">
                        <div class="accout">
                        <?php 
                            if (isset($_SESSION['user_id'])) {
                                $id = $_SESSION['user_id'];
                                $row = selectUsers("SELECT * FROM users WHERE user_id = $id");    
                                $img = '../../assets/img/143086968_2856368904622192_1959732218791162458_n.png';
                                $image = $row['user_image'] != null ? $row['user_image'] : $img;
                        ?>
                            <a href="../accounts/user-account.php"><img src="<?=$image?>" alt=""></a>
                        <?php } else { ?>
                            <a href="../accounts/login.php"><i class="fa-regular fa-user"></i></a>
                        <?php } ?>
                        </div>
                        <div class="favorite-product cart">
                            <?php 
                            $totalHeart = 0;
                            if (isset($_SESSION['heart'])) {
                                $totalHeart = count($_SESSION['heart']);
                            }
                            ?>
                            <span><?=$totalHeart?></span>
                            <a href="../heart/heart.php"><i class="fa-regular fa-heart"></i></a>
                        </div>
                        <div class="cart">
                            <?php 
                            $totalCart = 0;
                            if (isset($_SESSION['cart'])) {
                                $totalCart = count($_SESSION['cart']);
                            }
                            ?>
                            <span><?=$totalCart?></span>
                            <a href="../cart/cart.php"><i class="fa-solid fa-cart-plus"></i></a>
                        </div>
                    </div>
                </div>
                <menu>
                    <ul>
                       <li><a href="../pages/home.php">Trang chủ</a></li>
                       <li class="menu-hv">
                            <a href="../pages/categories.php">
                                Cửa hàng <i class="fa-solid fa-chevron-down"></i>
                            </a>
                            <ul class="menu-child">
                                <li><a href="../pages/categories.php">Tất cả các sản phẩm</a></li>
                            <?php 
                            $row = selectCategoryAll("SELECT * FROM categories");
                            foreach ($row as $list){
                            ?>
                                <li><a href="../pages/categories.php?category_id=<?=$list['category_id']?>"><?=$list['category_name']?></a></li>
                            <?php } ?>
                            </ul>
                        </li>
                       <li class="menu-hv-2">
                            <a href="../blog/blog.php">Bài viết <i class="fa-solid fa-chevron-down"></i></a>
                            <ul class="menu-child-2">
                                <li><a href="../blog/blog.php">Tất cả bài viết</a></li>
                            <?php 
                            $row = selectBlogsAll("SELECT * FROM blog_category");
                            foreach ($row as $list){
                            ?>
                                <li><a href="../blog/blog.php?category_id=<?=$list['blog_categoryId']?>"><?=$list['category_name']?></a></li>
                            <?php } ?>
                            </ul>
                        </li>
                       <li><a href="../pages/contact.php">Liên hệ</a></li>
                       <li><a href="../pages/about.php">Giới thiệu</a></li>
                       <?php if (isset($_SESSION['user_id'])) { ?>
                       <li><a href="../pay/order.php">Đơn hàng</a></li>
                       <?php } ?>
                       <?php 
                       if (isset($_SESSION['role'])){
                            if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Nhân viên') {
                       ?>
                       <li><a href="../../admin/layout/index.php?action=statistical">Admin</a></li>
                       <?php } } ?>
                    </ul>
                </menu>
            </div>
        </header>
