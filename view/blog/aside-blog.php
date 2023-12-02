<aside>
                    <div data-aos="fade-left" class="aside-item">
                        <div class="aside-title">Về tôi</div>
                        <div class="aside-content">
                            <div class="aside-content-img"><img src="../../assets/img/about/3da9b7d168cf2a001694f448fca01797.jpg" alt=""></div>
                            <div class="aside-content-text">
                                <p>Duong</p>
                                <p>Hi! I am Duong, Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempora modi commodi, ratione, sapiente numquam et nemo exercitationem, minus perferendis perspiciatis mollitia eaque! Veritatis nemo ipsum magni repudiandae molestiae magnam. Eaque.</p>
                            </div>
                        </div>
                    </div>
                    <div data-aos="fade-left" class="aside-item">
                        <div class="aside-title">Theo dõi tôi</div>
                        <div class="aside-content-grid">
                            <div class="aside-content-item">
                                <a href="https://www.facebook.com/profile.php?id=100093887452815" target="_blank">
                                    <i class="fa-brands fa-facebook-f"></i>
                                    <span>Facebook</span>
                                </a>
                            </div>
                            <div class="aside-content-item">
                                <a target="_blank" href="https://www.linkedin.com/in/duong-nguyen-thanh-23538427a/">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                    <span>Linkedin</span>
                                </a>
                            </div>
                            <div class="aside-content-item">
                                <a target="_blank" href="https://github.com/Duong04">
                                    <i class="fa-brands fa-github"></i>
                                    <span>Github</span>
                                </a>
                            </div>
                            <div class="aside-content-item">
                                <a target="_blank" href="https://www.instagram.com/tinhsocode/">
                                    <i class="fa-brands fa-instagram"></i>
                                    <span>Instagram</span>
                                </a>
                            </div>
                            <div class="aside-content-item">
                                <a target="_blank" href="https://www.tiktok.com/@tinhsocode?is_from_webapp=1&sender_device=pc">
                                    <i class="fa-brands fa-tiktok"></i>
                                    <span>Tiktok</span>
                                </a>
                            </div>
                            <div class="aside-content-item">
                                <a target="_blank" href="">
                                    <i class="fa-brands fa-youtube"></i>
                                    <span>Youtube</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div data-aos="fade-up" class="aside-item">
                        <div class="aside-title">Danh mục</div>
                        <div class="aside-content">
                            <div class="aside-menu">
                                <ul>
                                    <li><a href="../blog/blog.php">Tất cả bài viết</a></li>
                                    <?php 
                                     $row = selectBlogsAll("SELECT * FROM blog_category");
                                     foreach ($row as $list){
                                     ?>
                                        <li><a href="../blog/blog.php?category_id=<?=$list['blog_categoryId']?>"><?=$list['category_name']?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </aside>