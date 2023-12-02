

<div>
    <ul class="content-comment">
        <li class="image-user">
            <img src="<?= $comment['user_image'] ?>" alt="">
        </li>
        <li class="info-user">
            <div class="info-user-item-1">
                <div class="info_name">
                    <h4><?= $comment['user_name'] ?></h4>
                    <?php if ($comment['role'] == 'Admin' || $comment['role'] == 'Nhân viên') {?>
                        <div class="ticks"><i class="fa-solid fa-check"></i> Người kiểm duyệt</div>
                    <?php } ?>
                </div>
                <div class="content-comment-item"><?= $comment['content'] ?></div>
            </div>
            <div class="info-user-item-2">
                <div class="btn-delete">
                    <a href="">Thích</a>
                    <?php
                    if(isset($_SESSION['user_id'])) {
                     if ($_SESSION['user_id'] == $comment['user_id']) { ?>
                    <a onclick="deleteC(event)" href="../controller/deleteComment.php?product_id=<?=$row['product_id']?>&comment_id=<?=$comment['comment_id']?>" class="delete-comment">Xóa</a>
                    <?php } } ?>
                </div>
                <div><?= $comment['comment_date'] ?></div>
            </div>
            <!-- --------------- -->
            <?php 
                $listCommentReply = selectCommentAll("SELECT CR.*, U.*, P.*, C.*, CR.content AS content_reply, CR.comment_date AS comment_reply_date, CR.user_id AS user_rep FROM comment_reply AS CR 
                                                    INNER JOIN comments AS C ON CR.comment_id = C.comment_id 
                                                    INNER JOIN products AS P ON C.product_id = P.product_id
                                                    INNER JOIN users AS U ON CR.user_id = U.user_id 
                                                    WHERE CR.comment_id =" . $comment['comment_id']);
                if ($listCommentReply != null){
                    foreach ($listCommentReply as $reply) {
            ?>
                <ul class="content-comment">
                    <li class="image-user">
                        <img src="<?= $reply['user_image'] ?>" alt="">
                    </li>
                    <li class="info-user">
                        <div class="info-user-item-1">
                            <div class="info_name">
                                <h4><?= $reply['user_name'] ?></h4>
                                <?php if ($reply['role'] == 'Admin' || $reply['role'] == 'Nhân viên') {?>
                                <div class="ticks"><i class="fa-solid fa-check"></i> Người kiểm duyệt</div>
                                <?php } ?>
                            </div>
                            <div class="content-comment-item"><?= $reply['content_reply'] ?></div>
                        </div>
                        <div class="info-user-item-2">
                            <div class="btn-delete">
                                <a href="">Thích</a>
                                <?php
                                if(isset($_SESSION['user_id'])) {
                                if ($_SESSION['user_id'] == $reply['user_rep']) { ?>
                                <a onclick="deleteC(event)" href="../controller/deleteComment.php?product_id=<?=$row['product_id']?>&comment_id=<?=$comment['comment_id']?>&idR=<?=$reply['id']?>" class="delete-comment">Xóa</a>
                                <?php } } ?>
                            </div>
                            <div><?= $reply['comment_reply_date'] ?></div>
                        </div>
                    </li>
                </ul>
            <?php } }?>
            <!-- ----------------------- -->
        </li>
    </ul>
</div>