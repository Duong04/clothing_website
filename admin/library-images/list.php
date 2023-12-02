<h4>Quản lý thư viện ảnh</h4>
                <div class="filter">
                    <form action="./index.php?action=library-images" method="POST">
                        <div class="form-item">
                            <input class="border-success form-control" name="search" type="text" placeholder="Tìm kiếm ảnh theo sản phẩm">
                        </div>
                        <div class="form-item">
                            <select name="filter-2" class="form-select border-success" aria-label="Default select example">
                                <option value="0">Sắp xếp theo</option>
                                <option value="nameAsc">Tên A - Z</option>
                                <option value="nameDesc">Tên Z - A</option>
                                <option value="productNew">Danh mục mới nhất</option>
                                <option value="productOld">Danh mục cũ nhất</option>
                            </select>
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
                                <th scope="col">Id</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Người thêm</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($result as $row) {
                            ?>
                            <tr>
                                <th scope="row"><?=$row['product_id']?></th>
                                <td><?=$row['product_name']?></td>
                                <td><?=$row['user_name']?></td>
                                <td><a id="delete" class="text-success" href="./index.php?action=list-detail&idP=<?=$row['product_id']?>">Chi tiết</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>