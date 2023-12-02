<h4>Quản lý danh mục bài viết</h4>
                <div class="create-new">
                    <a class="btn btn-success" href="./index.php?action=add-blog">+ Thêm mới bài viết</a>
                </div>
                <div class="filter">
                    <form action="./index.php?action=blogs" method="POST">
                        <div class="form-item">
                            <input class="border-success form-control" name="search" type="text" placeholder="Tìm kiếm danh mục">
                        </div>
                        <div class="form-item">
                            <select name="filter-2" class="form-select border-success" aria-label="Default select example">
                                <option value="0">Sắp xếp theo</option>
                                <option value="nameAsc">Tên A - Z</option>
                                <option value="nameDesc">Tên Z - A</option>
                                <option value="desc">Bài viết mới nhất</option>
                                <option value="asc">Bài viết cũ nhất</option>
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
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Mô tả bài viết</th>
                                <th scope="col">ảnh</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Người thêm</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($result as $row) {
                            ?>
                            <tr>
                                <th scope="row"><?=$row['blog_id']?></th>
                                <td><?=$row['title']?></td>
                                <td><?=$row['blog_description']?></td>
                                <td style="width: 100px;"><img src="<?=$row['blog_image']?>" alt=""></td>
                                <td style="width:120px;"><?=$row['blog_create_date']?></td>
                                <td style="width:120px;"><?=$row['category_name']?></td>
                                <td style="width:120px;"><?=$row['user_name']?></td>
                                <td>
                                    <a class="text-success" href="./index.php?action=update-blog&id=<?=$row['blog_id']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a onclick="deleteC(event)" class="text-danger" href="./index.php?action=delete-blog&id=<?=$row['blog_id']?>"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
             