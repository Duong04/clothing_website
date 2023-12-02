<h4>Chi tiết hóa đơn</h4>
                <div class="table-responsive">
                    <div style="margin: 40px 0;" class="change"><a class="btn btn-success" href="./index.php?action=invoices">Quay về</a></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Mã hóa đơn</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($result as $row) {
                                $priceF = number_format($row['unit_price'],0,',','.');
                            ?>
                            <tr>
                                <th scope="row"><?=$row['invoice_id']?></th>
                                <td><?=$row['product_name']?><sup>đ</sup></td>
                                <td><img style="width:120px;" src="<?=$row['product_image']?>" alt=""></td>
                                <th><?=$priceF?><sup>đ</sup></th>
                                <td><?=$row['quantity']?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
             