                <h4>Quản lý bình luận chi tiết</h4>
                <div style="margin: 20px 0;" class="">
                    <?php 
                    if (isset($_GET['idP']) && $_GET['idCM']) {
                        $idP = $_GET['idP'];
                        $idCM = $_GET['idCM'];
                    }
                    ?>
                    <a class="btn btn-success" href="./index.php?action=comment-detail&idP=<?=$idP?>&idCM=<?=$idCM?>"><i class="fa-solid fa-angles-left"></i> Quay về</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nội dung trả lời</th>
                                <th scope="col">Người trả lời</th>
                                <th scope="col">Ngày bình luận</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($result as $row) {
                            ?>
                            <tr>
                                <th scope="row"><?=$row['id']?></th>
                                <td scope="row"><?=$row['content_reply']?></td>
                                <td scope="row"><?=$row['user_name']?></td>
                                <td><?=$row['comment_reply_date']?></td>
                                <td>
                                
                                    <div onclick="hideCommentForm()" id="comment-form">
                                        <form method="POST" action="./index.php?action=update-reply&idP=<?=$row['product_id']?>&idCM=<?=$row['comment_id']?>&idR=<?=$row['id']?>" id="myForm">
                                            <label for="comment">Bình luận</label>
                                            <textarea required placeholder="Cập nhật bình luận tại đây" id="comment" name="content" rows="4"><?=$row['content_reply']?></textarea>
                                            <div class="btn-item">
                                                <button class="btn btn-success">Cập nhật</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div onclick="showCommentForm()" id="reply" class="btn btn-success">
                                        Sửa
                                    </div>
                                    <a id="delete" onclick="deleteC(event)" class="btn btn-danger" href="./index.php?action=delete-reply&idP=<?=$row['product_id']?>&idCM=<?=$row['comment_id']?>&idR=<?=$row['id']?>">Xóa</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                

