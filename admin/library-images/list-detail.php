<h4>Chi tiết thư viện ảnh</h4>
                <div class="create-new">
                    <a class="btn btn-success" href="./index.php?action=add-image&idP=<?=$idP?>">+ Thêm ảnh mới</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($result as $row) {
                            ?>
                            <tr>
                                <th scope="row"><?=$row['image_id']?></th>
                                <td><?=$row['product_name']?></td>
                                <td style="width: 200px;"><img src="<?=$row['image']?>" alt=""></td>
                                <td>
                                    <a class="text-success" href="./index.php?action=update-image&id=<?=$row['image_id']?>&idP=<?=$row['product_id']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a onclick="deleteC(event)" class="text-danger" href="./index.php?action=delete-image&id=<?=$row['image_id']?>&idP=<?=$row['product_id']?>"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>