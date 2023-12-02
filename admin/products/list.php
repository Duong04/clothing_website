<h4>Quản lý sản phẩm</h4>
                <div class="create-new">
                    <a class="btn btn-success" href="./index.php?action=add-product">+ Thêm mới sản phẩm</a>
                </div>
                <div class="filter">
                    <form action="./index.php?action=products" method="POST">
                        <div class="form-item">
                            <input class="border-success form-control" name="search" type="text" placeholder="Tìm sản phẩm">
                        </div>
                        <div class="form-item">
                            <select name="category_id" class="form-select border-success" aria-label="Default select example">
                                <option value="0" selected>Tất cả sản phẩm</option>
                                <?php 
                                $listC = selectCategoryAll("SELECT * FROM categories");
                                foreach ($listC as $list ){
                                ?>
                                <option value="<?=$list['category_id']?>"><?=$list['category_name']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-item">
                            <select name="price" class="form-select border-success" aria-label="Default select example">
                                <option value="0" selected>Đơn giá</option>
                                <option value="100000">0 -> 100.000đ</option>
                                <option value="200000">100.000đ -> 200.000đ</option>
                                <option value="300000">200.00đ -> 300.000đ</option>
                                <option value="400000">300.000đ -> 400.000đ</option>
                                <option value="400000">500.000đ -> </option>
                            </select>
                        </div>
                        <div class="form-item">
                            <select name="filter-2" class="form-select border-success" aria-label="Default select example">
                                <option value="0">Sắp xếp theo</option>
                                <option value="nameAsc">Tên A - Z</option>
                                <option value="nameDesc">Tên Z - A</option>
                                <option value="productNew">Sản phẩm mới nhất</option>
                                <option value="productOld">Sản phẩm cũ nhất</option>
                            </select>
                        </div>
                        <div class="btn-submit">
                            <button name="filter" class="btn btn-success" type="submit"><i class='fa-solid fa-filter'></i> Lọc</button>
                            <input class="btn btn-warning" type="reset" value="Nhập lại">
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table-nobt">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Giá gốc</th>
                                <th scope="col">Giảm giá</th>
                                <th scope="col">Giá mới</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Xem</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Người thêm</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($result as $row) {
                                $price_new = $row['price'] - ($row['price'] * ($row['sale'] / 100));
                                $price = number_format($row['price'], 0, ',', '.');
                                $price_new_f = number_format($price_new, 0, ',', '.');
                                $status = $row['quantity_product'] > 0 ? 'Còn hàng' : 'Hết hàng';
                            ?>
                            <tr>
                                <th scope="row"><?=$row['product_id']?></th>
                                <td><?=$row['product_name']?></td>
                                <td><?=$row['category_name']?></td>
                                <td style="width: 100px;"><a href="./index.php?action=list-detail&idP=<?=$row['product_id']?>"><img src="<?=$row['product_image']?>" alt=""></a></td>
                                <th><?=$price.'đ'?></th>
                                <td style="width:90px;"><?=$row['sale'].'%'?></td>
                                <th><?=$price_new_f.'đ'?></th>
                                <td style="width:100px;"><?=$status?></td>
                                <td style="width:100px;"><?=$row['quantity_product']?></td>
                                <?php $views = $row['view']<=0 ? 0 : $row['view']; ?>
                                <td><?=$views?></td>
                                <td style="width:130px;"><?=$row['product_create_date']?></td>
                                <td style="width:130px;"><?=$row['user_name']?></td>
                                <td>
                                    <a class="text-success" href="./index.php?action=update-product&id=<?=$row['product_id']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a onclick="deleteC(event)" class="text-danger" href="./index.php?action=delete-product&id=<?=$row['product_id']?>"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>