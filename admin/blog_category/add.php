<h4>Thêm danh mục bài viết</h4>
<form id="yourFormId" method="POST">
    <div class="mb-3">
        <label for="" class="form-label">Mã danh mục</label>
        <input type="text" class="form-control" disabled placeholder="Tự động nhập">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Tên danh mục</label>
        <input required placeholder="Tên danh mục" name="category_name" type="text" class="form-control border-2" id="exampleInputPassword1">
    </div>
    <button id="btn-add" name="add" class="btn btn-outline-success">Thêm</button>
    <button type="reset" class="btn btn-outline-success">Nhập lại</button>
    <a href="./index.php?action=blog_category" type="submit" class="btn btn-outline-success">Danh sách</a>
</form>