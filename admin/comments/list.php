<h4>Quản lý bình luận</h4>
                <div class="filter">
                    <form action="./index.php?action=comments" method="POST">
                        <div class="form-item">
                            <input class="border-success form-control" name="search" type="text" placeholder="Tìm kiếm ảnh theo sản phẩm">
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
                                <td><a id="delete" class="text-success" href="./index.php?action=comment-detail&idP=<?=$row['product_id']?>">Chi tiết</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>