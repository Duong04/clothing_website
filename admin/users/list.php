                <h4>Quản lý người dùng</h4>
                <div class="create-new">
                    <a class="btn btn-success" href="./index.php?action=add-user">+ Thêm mới tài khoản</a>
                </div>
                <div class="filter">
                    <form action="./index.php?action=users" method="POST">
                        <div class="form-item">
                            <input class="border-success form-control" name="search" type="text" placeholder="Tìm kiếm">
                        </div>
                        <div class="form-item">
                            <select name="filter-2" class="form-select border-success" aria-label="Default select example">
                                <option value="0">Sắp xếp theo</option>
                                <option value="nameAsc">Tên A - Z</option>
                                <option value="nameDesc">Tên Z - A</option>
                                <option value="new">Người dùng mới nhất</option>
                                <option value="old">Người dùng cũ nhất</option>
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
                                <th scope="col">Tên người dùng</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Vai trò</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ngày tạo</th>
                                <?php if ($_SESSION['role'] == 'Admin') { ?>
                                <th scope="col">Phân quyền</th>
                                <?php } ?>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($result as $row){
                                    $img = '../../assets/img/143086968_2856368904622192_1959732218791162458_n.png';
                                    $image = $row['user_image'] != null ? $row['user_image'] : $img;
                            ?>
                            <tr>
                                <th scope="row"><?=$row['user_id']?></th>
                                <td style="width:130px;"><?=$row['user_name']?></td>
                                <td><?=$row['email']?></td>
                                <td style="width:80px;"><img style="width:60px; height: 60px; border-radius: 50%;" src="<?=$image?>" alt=""></td>
                                <td><?=$row['address']?></td>
                                <td><?=$row['phone_number']?></td>
                                <td><?=$row['role']?></td>
                                <td style="width:120px;"><?=$row['status']?></td>
                                <td style="width:120px;"><?=$row['create_date']?></td>
                                <?php 
                                    if ($_SESSION['role'] == 'Admin' ) {
                                        if ($row['role'] !== 'Admin'){ 
                                ?>
                                <td style="width:100px;">
                                    <a class="btn btn-success" href="./index.php?action=client&id=<?=$row['user_id']?>"><i class="fa-solid fa-user"></i></a>
                                    <a class="btn btn-warning" href="./index.php?action=staff&id=<?=$row['user_id']?>"><i class="fa-solid fa-user-nurse"></i></a>
                                </td>
                                <?php 
                                    }else {echo '<td></td>';} }
                                    if ($row['role'] !== 'Admin'){
                                 ?>
                                <td>
                                    <a class="text-success" href="./index.php?action=activated&id=<?=$row['user_id']?>"><i class="fa-solid fa-lock-open"></i></a>
                                    <a class="text-danger" href="./index.php?action=disable&id=<?=$row['user_id']?>"><i class="fa-solid fa-lock"></i></a>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>