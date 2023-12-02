<h4>Cập nhật danh mục</h4>
<form action="./index.php?action=handle-updateC" id="yourFormId" method="POST">
    <div class="mb-3">
        <label for="" class="form-label">Mã danh mục</label>
        <input type="text" class="form-control" disabled value="<?=$row['category_id']?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Tên danh mục</label>
        <input required value="<?=$row['category_name']?>" placeholder="Tên danh mục" name="category_name" type="text" class="form-control border-2" id="exampleInputPassword1">
    </div>
    <input name="id" type="hidden" value='<?=$row["category_id"]?>'>
    <button name="update" class="btn btn-outline-success">Cập nhật</button>
    <button type="reset" class="btn btn-outline-success">Nhập lại</button>
    <a href="./index.php?action=categories" type="submit" class="btn btn-outline-success">Danh sách</a>
</form>