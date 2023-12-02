<h4>Quản lý hóa đơn</h4>
                <div class="filter">
                    <form action="./index.php?action=invoices" method="POST">
                        <div class="form-item">
                            <input class="border-success form-control" name="search" type="text" placeholder="Tìm kiếm hóa đơn">
                        </div>
                        <div class="btn-submit">
                            <button name="submit" class="btn btn-success" type="submit"><i class='fa-solid fa-filter'></i> Lọc</button>
                            <input class="btn btn-warning" type="reset" value="Nhập lại">
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Mã hóa đơn</th>
                                <th scope="col">Tạm tính</th>
                                <th scope="col">Tiền ship</th>
                                <th scope="col">Ngày xuất hóa đơn</th>
                                <th scope="col">Trạng thái đơn hàng</th>
                                <th scope="col">Người nhận</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="colo">Action</th>
                                <th scope="colo">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($result as $row) {
                                $id = $row['invoice_id'];
                                $priceF = number_format($row['total_amount'],0,',','.');
                                $shipping_fee = number_format($row['shipping_fee'],0,',','.');
                                $total = $row['total_amount'] + $row['shipping_fee'];
                                $totalF = number_format($total,0,',','.');
                            ?>
                            <tr>
                                <th scope="row">DH000<?=$row['invoice_id']?></th>
                                <th><?=$priceF?><sup>đ</sup></th>
                                <th><?=$shipping_fee?><sup>đ</sup></th>
                                <td><?=$row['invoice_date']?></td>
                                <td><?=$row['order_status']?></td>
                                <td><?=$row['user_name']?></td>
                                <th><?=$totalF?><sup>đ</sup></th>
                                <?php 
                                if ($row['order_status'] !== 'Hủy đơn hàng' && $row['order_status'] !== 'Hoàn tất đơn hàng'){
                                ?>
                                <td>
                                    <form action="./index.php?action=invoices&invoice_id=<?=$id?>" method="POST">
                                        <select class="form-select" name="status" id="">
                                            <?php if ($row['order_status']){ ?>
                                            <option selected value="<?=$row['order_status']?>"><?=$row['order_status']?></option>
                                            <?php } ?>
                                            <option value="Đã xác nhận">Đã xác nhận</option>
                                            <option value="Chuẩn bị đơn hàng">Chuẩn bị đơn hàng</option>
                                            <option value="Đang vận chuyển">Đang vận chuyển</option>
                                            <option value="Đã giao hàng">Đã giao hàng</option>
                                            <option value="Hoàn tất đơn hàng">Hoàn tất đơn hàng</option>
                                            <option value="Hủy đơn hàng">Hủy đơn hàng</option>
                                        </select>
                                        <button name="update" style="margin-top:10px;" class="btn btn-success">Cập nhật</button>
                                    </form>
                                </td>
                                <?php }else if ($row['order_status'] == 'Hủy đơn hàng') { ?>
                                    <td>Đơn hàng này đã bị hủy</td>
                                <?php } else if ($row['order_status'] == 'Hoàn tất đơn hàng') {?>
                                    <td>Giao hàng thành công</td>
                                <?php } ?>
                                <td><a class="text-success" href="./index.php?action=invoice_details&invoice_id=<?=$id?>">Xem chi tiết</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
             