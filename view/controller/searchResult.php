<?php
require "../../config/connectDB.php";
require "../../model/dao-products.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = trim($_POST['search']);
    $result = selectProductAll("SELECT * FROM products AS P INNER JOIN categories AS C ON P.category_id = C.category_id WHERE P.product_name LIKE '%$search%' OR C.category_name LIKE '%$search%' LIMIT 5");
    if ($result != null) {
        foreach ($result as $list) {
            $price_new = $list['price'] - ($list['price'] * ($list['sale'] / 100));
            $price_new_f = number_format($price_new, 0, ',', '.');
            $priceF = number_format($list['price'], 0, ',', '.');
            ?>

            <div class="result-search-item">
                <a id="search_result" href="./productDetail.php?product_id=<?= $list['product_id'] ?>">
                    <img src="<?= $list['product_image'] ?>" alt="">
                    <div class="name-price">
                        <h5>
                            <?= $list['product_name'] ?>
                        </h5>
                        <?php if ($list['sale'] > 0) { ?>
                            <div class="price">
                                <span>
                                    <?= $price_new_f ?><sup>đ</sup>
                                </span>
                                <del>
                                    <?= $priceF ?><sup>đ</sup>
                                </del>
                            </div>
                        <?php } else { ?>
                            <span>
                                <?= $priceF ?><sup>đ</sup>
                            </span>
                        <?php } ?>
                    </div>
                </a>
            </div>
        <?php }
    } else { ?>
        <div class="result-search-item" style="padding:10px;"><i class="fa-solid fa-magnifying-glass"></i> Không tìm thấy sản phẩm!</div>
    <?php }
} ?>