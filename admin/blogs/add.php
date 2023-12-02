<h4>Thêm bài viết</h4>
<form id="yourFormId" method="POST" enctype="multipart/form-data">
    <div class="grid">
        <div class="mb-3">
            <label for="" class="form-label">Mã bài viết</label>
            <input required type="text" class="form-control" disabled placeholder="Tự động nhập">
        </div>
        <div class="mb-3">
            <label for="name-product" class="form-label">Tiêu đề bài viết</label>
            <input required placeholder="Tên danh mục" name="blog_name" type="text" class="form-control border-2" id="name-product">
        </div>
        <div class="mb-3">
            <label for="name-product" class="form-label">Mô tả bài viết</label>
            <textarea required name="description" id="description" cols="30" rows="10"></textarea>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh sản phẩm</label>
            <input required name="image_blog" class="form-control" type="file" id="formFile">
        </div>
        <div class="mb-3">
            <label class="form-label" for="category">Danh mục bài viết</label>
            <select style="height: 40px;" id="category" name="category" required class="form-select" aria-label="Default select example">
            <?php 
            $result = selectBlogsAll("SELECT * FROM blog_category");
            foreach ($result as $row) {
            ?>
                <option value="<?=$row['blog_categoryId']?>"><?=$row['category_name']?></option>
            <?php } ?>
            </select>
        </div>
    </div>
    <div class="mb-3" style="margin-top:30px;">
        <label for="description" class="form-label">Nội dung bài viết</label>
        <textarea required class="form-control" name="content" id="content" cols="30" rows="10"></textarea>
    </div>
    <button id="btn-add" name="add" class="btn btn-outline-success">Thêm</button>
    <button type="reset" class="btn btn-outline-success">Nhập lại</button>
    <a href="./index.php?action=blogs" type="submit" class="btn btn-outline-success">Danh sách</a>
</form>