<h4>Quản lý danh mục bài viết</h4>
                <div class="create-new">
                    <a class="btn btn-success" href="./index.php?action=add-blogCategory">+ Thêm mới danh mục</a>
                </div>
                <div class="filter">
                    <form action="./index.php?action=blog_category" method="POST">
                        <div class="form-item">
                            <input class="border-success form-control" name="search" type="text" placeholder="Tìm kiếm danh mục">
                        </div>
                        <div class="form-item">
                            <select name="filter-2" class="form-select border-success" aria-label="Default select example">
                                <option value="0">Sắp xếp theo</option>
                                <option value="nameAsc">Tên A - Z</option>
                                <option value="nameDesc">Tên Z - A</option>
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
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Người thêm</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($result as $row) {
                            ?>
                            <tr>
                                <th scope="row"><?=$row['blog_categoryId']?></th>
                                <td><?=$row['category_name']?></td>
                                <td><?=$row['user_name']?></td>
                                <td>
                                    <a class="text-success" href="./index.php?action=update-Blogcategory&id=<?=$row['blog_categoryId']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a onclick="deleteC(event)" class="text-danger" href="./index.php?action=delete-Blogcategory&id=<?=$row['blog_categoryId']?>"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
             