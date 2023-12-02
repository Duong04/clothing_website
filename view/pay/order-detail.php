<?php
require "../../config/connectDB.php";
require "../../model/dao-users.php";
require "../../model/dao-products.php";
require "../../model/dao-categories.php";
require "../../model/dao-blogs.php";
require "../../model/dao-invoice.php";

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <style>
        article {
            width: 85%;
            margin: 50px auto;
        }

        article>h3 {
            text-align: center;
        }

        .change {
            margin-bottom: 40px;
        }

        @media (max-width: 39.375em) {
            .btn {
                margin: 30px 0;
            }
        }
    </style>
</head>
<body>
    <main>
    <?php include '../header.php'; ?>
        <!-- article -->
        <?php 
        if (isset($_GET['invoice_id'])) {
            $id = $_GET['invoice_id'];
        }

        $result = selectInvoice("SELECT * FROM invoices WHERE invoice_id = $id");
        ?>
        <article>
            <h3>Chi tiết đơn hàng</h3>
            <div class="table table-responsive">
                <div class="change"><a class="btn btn-success" href="../pay/order.php"><i class="fa-solid fa-angles-down fa-rotate-90"></i> Quay lại</a></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá sản phẩm</th>
                            <?php if ($result['order_status'] == 'Hoàn tất đơn hàng') { ?>
                            <th></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (isset($_GET['invoice_id'])) {
                            $id = $_GET['invoice_id'];
                        }

                        $query = selectInvoicetAll("SELECT * FROM invoice_details AS I INNER JOIN products AS P ON I.product_id = P.product_id WHERE invoice_id = $id");
                        foreach ($query as $row) {
                            $price = number_format($row['unit_price'],0,',','.');
                        ?>
                        <tr>
                            <td><img style="width: 100px;" src="<?=$row['product_image']?>" alt=""></td>
                            <td><?=$row['product_name']?></td>
                            <td><?=$row['quantity']?></td>
                            <td><?=$price?><sup>đ</sup></td>
                            <?php if ($result['order_status'] == 'Hoàn tất đơn hàng') { ?>
                            <td><a class="btn btn-outline-warning" href="../pages/productDetail.php?product_id=<?=$row['product_id']?>#comment">Đánh giá sản phẩm</a></td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </article>
        <!-- Footer -->
        <?php include '../footer.php' ?>
    </main>
    <script src="../../assets/js/check-order.js"></script>
</body>
</html>