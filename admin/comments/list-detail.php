<h4>Quản lý bình luận chi tiết</h4>
                <div class="filter">
                    <form action="./index.php?action=comment-detail&idP=<?=$id?>" method="POST">
                        <div class="form-item">
                            <input class="border-success form-control" name="search" type="text" placeholder="Tìm kiếm ảnh theo sản phẩm">
                        </div>
                        <div class="form-item">
                            <select name="filter-2" class="form-select border-success" aria-label="Default select example">
                                <option value="0">Sắp xếp theo</option>
                                <option value="nameAsc">Tên A - Z</option>
                                <option value="nameDesc">Tên Z - A</option>
                                <option value="productNew">Bình luận mới nhất</option>
                                <option value="productOld">Bình luận cũ nhất</option>
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
                                <th scope="col">Nội dung bình luận</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Người bình luận</th>
                                <th scope="col">Ngày bình luận</th>
                                <th scope="col">Action</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($result as $row) {
                            ?>
                            <tr>
                                <th scope="row"><?=$row['comment_id']?></th>
                                <td scope="row"><?=$row['content']?></td>
                                <td scope="row"><?=$row['product_name']?></td>
                                <td scope="row"><?=$row['user_name']?></td>
                                <td><?=$row['comment_date']?></td>
                                <td>
                                
                                    <div onclick="hideCommentForm()" id="comment-form">
                                        <form method="POST" action="./index.php?action=rep-comment&idP=<?=$row['product_id']?>&idCM=<?=$row['comment_id']?>" id="myForm">
                                            <label for="comment">Bình luận</label>
                                            <textarea required placeholder="Trả lời bình luận tại đây" id="comment" name="content" rows="4"></textarea>
                                            <div class="btn-item">
                                                <button class="btn btn-success">Gửi</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div onclick="showCommentForm()" id="reply" class="btn btn-success">
                                        Trả lời
                                    </div>
                                    <a id="delete" onclick="deleteC(event)" class="btn btn-danger" href="./index.php?action=delete-comment&idP=<?=$row['product_id']?>&idCM=<?=$row['comment_id']?>">Xóa</a>
                                </td>
                                <td style="display: block;"><a href="./index.php?action=list-rep&idP=<?=$row['product_id']?>&idCM=<?=$row['comment_id']?>">Chi tiết</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                

