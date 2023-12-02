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
    <title>Kiểm tra đơn hàng - SUGAR - Streetwear brand</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/check-order.css">
    <link rel="stylesheet" href="../../assets/reponsive/header.css">
    <link rel="stylesheet" href="../../assets/reponsive/footer.css">
    <link rel="stylesheet" href="../../assets/reponsive/order.css">
</head>
<body>
    <main>
    <?php include '../header.php'; ?>
        <!-- article -->
        <article>
        <?php 
            if (isset($_GET['act']) == 'update_status') {
                $act = $_GET['act'];
                switch ($act) {
                    case 'update_status':
                        if (isset($_GET['invoice_id'])) {
                            $id = $_GET['invoice_id'];
                            $query = selectInvoicetAll("SELECT * FROM invoice_details WHERE invoice_id = $id");
                            foreach ($query as $row) {
                                $quantity = $row['quantity'];
                                cudProduct("UPDATE products set quantity_product = quantity_product + $quantity WHERE product_id = ".$row['product_id']);
                            }
                            $result = cudInvoice("UPDATE invoices SET order_status = 'Hủy đơn hàng' WHERE invoice_id = $id");
                            if ($result) {
                              echo '<script>
                                      Swal.fire({
                                        title: "Hủy thành công!",
                                        text: "Hủy đơn hàng thành công!",
                                        icon: "success",
                                        timer: 1000
                                      });
                                    </script>';
                            }
                        }
                        break;
                    case 'repurchase':
                        if (isset($_GET['invoice_id'])) {
                            $id = $_GET['invoice_id'];
                            $query = selectInvoicetAll("SELECT * FROM invoice_details WHERE invoice_id = $id");
                            foreach ($query as $row) {
                                $quantity = $row['quantity'];
                                cudProduct("UPDATE products set quantity_product = quantity_product - $quantity WHERE product_id = ".$row['product_id']);
                            }
                            $result = cudInvoice("UPDATE invoices SET order_status = 'Chờ xác nhận' WHERE invoice_id = $id");
                            if ($result) {
                              echo '<script>
                                      Swal.fire({
                                        title: "Mua thành công!",
                                        text: "Mua hàng thành công!",
                                        icon: "success",
                                        timer: 1000
                                      });
                                    </script>';
                            }
                        }
                        break;
                    case 'delete_history':
                        if (isset($_GET['invoice_id'])) {
                            $id = $_GET['invoice_id'];
                            cudInvoice("DELETE FROM invoice_details WHERE invoice_id = $id");
                            $result = cudInvoice("DELETE FROM invoices WHERE invoice_id = $id");
                            if ($result) {
                              echo '<script>
                                      Swal.fire({
                                        title: "Xóa thành công!",
                                        text: "Xóa hàng thành công!",
                                        icon: "success",
                                        timer: 1000
                                      });
                                    </script>';
                            }
                        }
                        break;
                    case 'confirm_order':
                        if (isset($_GET['invoice_id'])) {
                            $id = $_GET['invoice_id'];
                            $result = cudInvoice("UPDATE invoices SET order_status = 'Hoàn tất đơn hàng' WHERE invoice_id = $id");
                            if ($result) {
                              echo '<script>
                                      Swal.fire({
                                        title: "Thành công!",
                                        text: "Đơn hàng hoàn thành!",
                                        icon: "success",
                                        timer: 1000
                                      });
                                    </script>';
                            }
                        }
                        break;
                }
            }
            ?>
          <?php 
          if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id']; 
          ?>
            <h3>Kiểm tra đơn hàng</h3>
            <ul class="tabs">
                <li class="tab active" onclick="changeTab(0)">Chờ xác nhận</li>
                <li class="tab" onclick="changeTab(1)">Đã xác nhận</li>
                <li class="tab" onclick="changeTab(2)">Chuẩn bị đơn hàng</li>
                <li class="tab" onclick="changeTab(3)">Đang vận chuyển</li>
                <li class="tab" onclick="changeTab(4)">Đã giao hàng</li>
                <li class="tab" onclick="changeTab(5)">Đã hủy</li>
            </ul>
          
            <!-- Nội dung cho tab "Chờ xác nhận" -->
            <div id="tabContent0" class="tab-content active">
                <div>
                  <?php 
                $listInvoice = selectInvoicetAll("SELECT * FROM invoices WHERE order_status='Chờ xác nhận' AND user_id=$user_id ORDER BY invoice_date DESC");
                if ($listInvoice != null) {
                    foreach ($listInvoice as $list) {
                    $price = number_format($list['total_amount'], 0, ',','.');
                    $shipping_fee = number_format($list['shipping_fee'], 0,',','.');
                    $total = $list['total_amount'] + $list['shipping_fee'];
                    $totalF = number_format($total, 0,',','.');
                ?>
                    <div class="order">
                        <h3>Đơn hàng #DH000<?=$list['invoice_id']?></h3>
                        <p><strong>Trạng thái:</strong> <?=$list['order_status']?></p>
                        <?php 
                        $listImg = selectInvoicetAll("SELECT * FROM invoice_details AS I INNER JOIN products P ON I.product_id = P.product_id WHERE I.invoice_id = ".$list['invoice_id']);
                        ?>
                        <p>
                            <strong>Sản phẩm:</strong>
                            <?php foreach ($listImg as $row) { ?>
                                <img style="width: 80px;" src="<?=$row['product_image']?>" alt="">
                            <?php } ?>
                        </p>
                        <p><strong>Ngày xuất hóa đơn:</strong> <?=$list['invoice_date']?></p>
                        <p><strong>Tạm tính:</strong> <?=$price?><sup>đ</sup></p>
                        <p><strong>Tiền ship:</strong> <?=$shipping_fee?><sup>đ</sup></p>
                        <p><strong>Tổng tiền:</strong> <?=$totalF?><sup>đ</sup></p>
                        <p><strong>Trạng thái đơn hàng:</strong> Chờ xác nhận</p>
                        <div class="btn-event">
                            <a class="btn btn-outline-success" href="../pay/order-detail.php?invoice_id=<?=$list['invoice_id']?>">Xem chi tiết đơn hàng</a>
                            <a onclick="updatee(event)" class="btn btn-outline-danger" href="../pay/order.php?act=update_status&invoice_id=<?=$list['invoice_id']?>">Hủy đơn hàng</a>
                        </div>
                    </div>
                <?php } }else { ?>
                    <div class="no-order">
                        <img src="../../assets/img/fb-gg/5fafbb923393b712b96488590b8f781f.png" alt="">
                        <p>Chưa có đơn hàng!</p>
                    </div>
                <?php } ?>
                </div>
            </div>
            <!-- Nội dung cho tab "Đã xác nhận" -->
            <div id="tabContent1" class="tab-content">
            <?php 
                $listInvoice = selectInvoicetAll("SELECT * FROM invoices WHERE order_status='Đã xác nhận' AND user_id=$user_id ORDER BY invoice_date DESC");
                if ($listInvoice != null) {
                    foreach ($listInvoice as $list) {
                    $price = number_format($list['total_amount'], 0, ',','.');
                    $shipping_fee = number_format($list['shipping_fee'], 0,',','.');
                    $total = $list['total_amount'] + $list['shipping_fee'];
                    $totalF = number_format($total, 0,',','.');
                ?>
                    <div class="order">
                        <h3>Đơn hàng #DH000<?=$list['invoice_id']?></h3>
                        <p><strong>Trạng thái:</strong> <?=$list['order_status']?></p>
                        <?php 
                        $listImg = selectInvoicetAll("SELECT * FROM invoice_details AS I INNER JOIN products P ON I.product_id = P.product_id WHERE I.invoice_id = ".$list['invoice_id']);
                        ?>
                        <p>
                            <strong>Sản phẩm:</strong>
                            <?php foreach ($listImg as $row) { ?>
                                <img style="width: 80px;" src="<?=$row['product_image']?>" alt="">
                            <?php } ?>
                        </p>
                        <p><strong>Ngày xuất hóa đơn:</strong> <?=$list['invoice_date']?></p>
                        <p><strong>Tạm tính:</strong> <?=$price?><sup>đ</sup></p>
                        <p><strong>Tiền ship:</strong> <?=$shipping_fee?><sup>đ</sup></p>
                        <p><strong>Tổng tiền:</strong> <?=$totalF?><sup>đ</sup></p>
                        <p><strong>Trạng thái đơn hàng:</strong> <?=$list['order_status']?></p>
                        <div class="btn-event">
                          <a class="btn btn-outline-success" href="../pay/order-detail.php?invoice_id=<?=$list['invoice_id']?>">Xem chi tiết đơn hàng</a>
                        </div>
                    </div>
                <?php } }else { ?>
                    <div class="no-order">
                        <img src="../../assets/img/fb-gg/5fafbb923393b712b96488590b8f781f.png" alt="">
                        <p>Chưa có đơn hàng!</p>
                    </div>
                <?php } ?> 
            </div>
          
            <!-- Nội dung cho tab "Chuẩn bị đon hàng" -->
            <div id="tabContent2" class="tab-content">
            <?php 
                $listInvoice = selectInvoicetAll("SELECT * FROM invoices WHERE order_status='Chuẩn bị đơn hàng' AND user_id=$user_id ORDER BY invoice_date DESC");
                if ($listInvoice != null) {
                    foreach ($listInvoice as $list) {
                    $price = number_format($list['total_amount'], 0, ',','.');
                    $shipping_fee = number_format($list['shipping_fee'], 0,',','.');
                    $total = $list['total_amount'] + $list['shipping_fee'];
                    $totalF = number_format($total, 0,',','.');
                ?>
                    <div class="order">
                        <h3>Đơn hàng #DH000<?=$list['invoice_id']?></h3>
                        <p><strong>Trạng thái:</strong> <?=$list['order_status']?></p>
                        <?php 
                        $listImg = selectInvoicetAll("SELECT * FROM invoice_details AS I INNER JOIN products P ON I.product_id = P.product_id WHERE I.invoice_id = ".$list['invoice_id']);
                        ?>
                        <p>
                            <strong>Sản phẩm:</strong>
                            <?php foreach ($listImg as $row) { ?>
                                <img style="width: 80px;" src="<?=$row['product_image']?>" alt="">
                            <?php } ?>
                        </p>
                        <p><strong>Ngày xuất hóa đơn:</strong> <?=$list['invoice_date']?></p>
                        <p><strong>Tạm tính:</strong> <?=$price?><sup>đ</sup></p>
                        <p><strong>Tiền ship:</strong> <?=$shipping_fee?><sup>đ</sup></p>
                        <p><strong>Tổng tiền:</strong> <?=$totalF?><sup>đ</sup></p>
                        <p><strong>Trạng thái đơn hàng:</strong> <?=$list['order_status']?></p>
                        <div class="btn-event">
                            <a class="btn btn-outline-success" href="../pay/order-detail.php?invoice_id=<?=$list['invoice_id']?>">Xem chi tiết đơn hàng</a>
                        </div>
                    </div>
                <?php } }else { ?>
                    <div class="no-order">
                        <img src="../../assets/img/fb-gg/5fafbb923393b712b96488590b8f781f.png" alt="">
                        <p>Chưa có đơn hàng!</p>
                    </div>
                <?php } ?>
            </div>
          
            <!-- Nội dung cho tab "Đang vận chuyển" -->
            <div id="tabContent3" class="tab-content">
            <?php 
                $listInvoice = selectInvoicetAll("SELECT * FROM invoices WHERE order_status='Đang vận chuyển' AND user_id=$user_id ORDER BY invoice_date DESC");
                if ($listInvoice != null) {
                    foreach ($listInvoice as $list) {
                        $price = number_format($list['total_amount'], 0, ',','.');
                        $shipping_fee = number_format($list['shipping_fee'], 0,',','.');
                        $total = $list['total_amount'] + $list['shipping_fee'];
                        $totalF = number_format($total, 0,',','.');
                  ?>
                    <div class="order">
                        <h3>Đơn hàng #DH000<?=$list['invoice_id']?></h3>
                        <p><strong>Trạng thái:</strong> <?=$list['order_status']?></p>
                        <?php 
                        $listImg = selectInvoicetAll("SELECT * FROM invoice_details AS I INNER JOIN products P ON I.product_id = P.product_id WHERE I.invoice_id = ".$list['invoice_id']);
                        ?>
                        <p>
                            <strong>Sản phẩm:</strong>
                            <?php foreach ($listImg as $row) { ?>
                                <img style="width: 80px;" src="<?=$row['product_image']?>" alt="">
                            <?php } ?>
                        </p>
                        <p><strong>Ngày xuất hóa đơn:</strong> <?=$list['invoice_date']?></p>
                        <p><strong>Tạm tính:</strong> <?=$price?><sup>đ</sup></p>
                        <p><strong>Tiền ship:</strong> <?=$shipping_fee?><sup>đ</sup></p>
                        <p><strong>Tổng tiền:</strong> <?=$totalF?><sup>đ</sup></p>
                        <p><strong>Trạng thái đơn hàng:</strong> <?=$list['order_status']?></p>
                        <div class="btn-event">
                            <a class="btn btn-outline-success" href="../pay/order-detail.php?invoice_id=<?=$list['invoice_id']?>">Xem chi tiết đơn hàng</a>
                        </div>
                    </div>
                <?php } }else { ?>
                    <div class="no-order">
                        <img src="../../assets/img/fb-gg/5fafbb923393b712b96488590b8f781f.png" alt="">
                        <p>Chưa có đơn hàng!</p>
                    </div>
                <?php } ?>
            </div>
          
            <!-- Nội dung cho tab "Đã giao hàng" -->
            <div id="tabContent4" class="tab-content">
            <?php 
                $listInvoice = selectInvoicetAll("SELECT * FROM invoices WHERE order_status='Đã giao hàng' OR order_status='Hoàn tất đơn hàng' AND user_id=$user_id ORDER BY invoice_date DESC");
                if ($listInvoice != null) {
                    foreach ($listInvoice as $list) {
                    $price = number_format($list['total_amount'], 0, ',','.');
                    $shipping_fee = number_format($list['shipping_fee'], 0,',','.');
                    $total = $list['total_amount'] + $list['shipping_fee'];
                    $totalF = number_format($total, 0,',','.');
                ?>
                    <div class="order">
                        <?php if ($list['order_status'] == 'Hoàn tất đơn hàng'){ ?>
                        <div class="success-order"><i class="fa-solid fa-car-side"></i> &nbsp;Giao hàng thành công</div>
                        <?php } ?>
                        <h3>Đơn hàng #DH000<?=$list['invoice_id']?></h3>
                        <p><strong>Trạng thái:</strong> <?=$list['order_status']?></p>
                        <?php 
                        $listImg = selectInvoicetAll("SELECT * FROM invoice_details AS I INNER JOIN products P ON I.product_id = P.product_id WHERE I.invoice_id = ".$list['invoice_id']);
                        ?>
                        <p>
                            <strong>Sản phẩm:</strong>
                            <?php foreach ($listImg as $row) { ?>
                                <img style="width: 80px;" src="<?=$row['product_image']?>" alt="">
                            <?php } ?>
                        </p>
                        <p><strong>Ngày xuất hóa đơn:</strong> <?=$list['invoice_date']?></p>
                        <p><strong>Tạm tính:</strong> <?=$price?><sup>đ</sup></p>
                        <p><strong>Tiền ship:</strong> <?=$shipping_fee?><sup>đ</sup></p>
                        <p><strong>Tổng tiền:</strong> <?=$totalF?><sup>đ</sup></p>
                        <p><strong>Trạng thái đơn hàng:</strong> <?=$list['order_status']?></p>
                        <div class="btn-event">
                            <a class="btn btn-outline-success" href="../pay/order-detail.php?invoice_id=<?=$list['invoice_id']?>">Xem chi tiết đơn hàng</a>
                            <?php if ($list['order_status'] != 'Hoàn tất đơn hàng'){ ?>
                            <a class="btn btn-outline-danger" href="../pay/order.php?act=confirm_order&invoice_id=<?=$list['invoice_id']?>">Đã nhận được hàng</a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } } else { ?>
                    <div class="no-order">
                        <img src="../../assets/img/fb-gg/5fafbb923393b712b96488590b8f781f.png" alt="">
                        <p>Chưa có đơn hàng!</p>
                    </div>
                <?php } ?> 
            </div>
            <!-- Nội dung cho tab "Đã hủy" -->
            <div id="tabContent5" class="tab-content">
            <?php 
                $listInvoice = selectInvoicetAll("SELECT * FROM invoices WHERE order_status='Hủy đơn hàng' AND user_id=$user_id ORDER BY invoice_date DESC");
                if ($listInvoice != null) {
                    foreach ($listInvoice as $list) {
                    $price = number_format($list['total_amount'], 0, ',','.');
                    $shipping_fee = number_format($list['shipping_fee'], 0,',','.');
                    $total = $list['total_amount'] + $list['shipping_fee'];
                    $totalF = number_format($total, 0,',','.');
                  ?>
                    <div class="order">
                        <h3>Đơn hàng #DH000<?=$list['invoice_id']?></h3>
                        <p><strong>Trạng thái:</strong> <?=$list['order_status']?></p>
                        <?php 
                        $listImg = selectInvoicetAll("SELECT * FROM invoice_details AS I INNER JOIN products P ON I.product_id = P.product_id WHERE I.invoice_id = ".$list['invoice_id']);
                        ?>
                        <p>
                            <strong>Sản phẩm:</strong>
                            <?php foreach ($listImg as $row) { ?>
                                <img style="width: 80px;" src="<?=$row['product_image']?>" alt="">
                            <?php } ?>
                        </p>
                        <p><strong>Ngày xuất hóa đơn:</strong> <?=$list['invoice_date']?></p>
                        <p><strong>Tạm tính:</strong> <?=$price?><sup>đ</sup></p>
                        <p><strong>Tiền ship:</strong> <?=$shipping_fee?><sup>đ</sup></p>
                        <p><strong>Tổng tiền:</strong> <?=$totalF?><sup>đ</sup></p>
                        <p><strong>Trạng thái đơn hàng:</strong> Chờ xác nhận</p>
                        <div class="btn-event">
                            <a class="btn btn-outline-success" href="../pay/order-detail.php?invoice_id=<?=$list['invoice_id']?>">Xem chi tiết đơn hàng</a>
                            <a onclick="update_2(event)" class="btn btn-outline-danger" href="../pay/order.php?act=repurchase&invoice_id=<?=$list['invoice_id']?>">Mua lại</a>
                            <a onclick="deletee(event)" class="btn btn-outline-warning" href="../pay/order.php?act=delete_history&invoice_id=<?=$list['invoice_id']?>">Xóa lịch sử</a>
                        </div>
                    </div>
                <?php } }else { ?>
                    <div class="no-order">
                        <img src="../../assets/img/fb-gg/5fafbb923393b712b96488590b8f781f.png" alt="">
                        <p>Chưa có đơn hàng!</p>
                    </div>
                <?php } ?>
            </div>
          <?php } ?>
        </article>
        <!-- Footer -->
        <?php include '../footer.php' ?>
    </main>
    <script src="../../assets/js/check-order.js"></script>
    <script>
        function updatee(event) {
            event.preventDefault();

            const deleteLink = event.currentTarget; // sử dụng this để lấy phần tử được kích hoạt
            const path = deleteLink.getAttribute('href');

            Swal.fire({
                title: "Bạn có chắc muốn hủy đơn hàng?",
                text: "Bạn sẽ không thể khôi phục điều này!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Thoát",
                confirmButtonText: "Hủy đơn hàng"
            }).then((result) => {
                if (result.value) {
                    document.location.href = path;
                }
            });
        }

        function update_2(event) {
            event.preventDefault();

            const deleteLink = event.currentTarget; // sử dụng this để lấy phần tử được kích hoạt
            const path = deleteLink.getAttribute('href');

            Swal.fire({
                title: "Bạn có chắc muốn mua hàng?",
                text: "Bạn sẽ sẽ mua đơn hàng này!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Thoát",
                confirmButtonText: "Mua"
            }).then((result) => {
                if (result.value) {
                    document.location.href = path;
                }
            });
        }

        function deletee(event) {
            event.preventDefault();

            const deleteLink = event.currentTarget; // sử dụng this để lấy phần tử được kích hoạt
            const path = deleteLink.getAttribute('href');

            Swal.fire({
                title: "Bạn có chắc muốn xóa?",
                text: "Bạn sẽ không thể khôi phục điều này!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Thoát",
                confirmButtonText: "Xóa"
            }).then((result) => {
                if (result.value) {
                    document.location.href = path;
                }
            });
        }
    </script>
</body>
</html>