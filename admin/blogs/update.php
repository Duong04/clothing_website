<?php 
$id = $row['blog_categoryId'];
?>
<h4>Cập nhật bài viết</h4>
<form action="./index.php?action=handle-blog" id="yourFormId" method="POST" enctype="multipart/form-data">
    <div class="grid">
        <div class="mb-3">
            <label for="" class="form-label">Mã bài viết</label>
            <input required value="<?=$row['blog_id']?>" type="text" class="form-control" disabled placeholder="Tự động nhập">
        </div>
        <div class="mb-3">
            <label for="name-product" class="form-label">Tiêu đề bài viết</label>
            <input value="<?=$row['title']?>" required placeholder="Tên danh mục" name="blog_name" type="text" class="form-control border-2" id="name-product">
        </div>
        <div class="mb-3">
            <label for="name-product" class="form-label">Mô tả bài viết</label>
            <textarea required name="description" id="description" cols="30" rows="10"><?=$row['blog_description']?></textarea>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh sản phẩm</label>
            <input required name="image_blog" class="form-control" type="file" id="formFile">
            <img style="width: 60px; height: 60px;" src="<?=$row['blog_image']?>" alt="">
        </div>
        <div class="mb-3">
            <label class="form-label" for="category">Danh mục bài viết</label>
            <select style="height: 40px;" id="category" name="category" required class="form-select" aria-label="Default select example">
            <?php 
            $listC = selectBlogsAll("SELECT * FROM blog_category");
            foreach ($listC as $list) {
                if ($id == $list['blog_categoryId']){
            ?>
                <option value="<?=$list['blog_categoryId']?>"><?=$list['category_name']?></option>
            <?php }else { ?>
                <option value="<?=$list['blog_categoryId']?>"><?=$list['category_name']?></option>
            <?php } } ?>
            </select>
        </div>
    </div>
    <div class="mb-3" style="margin-top:30px;">
        <label for="description" class="form-label">Nội dung bài viết</label>
        <textarea required class="form-control" name="content" id="content" cols="30" rows="10"><?=$row['blog_content']?></textarea>
    </div>
    <input name="id" value="<?=$row['blog_id']?>" type="hidden">
    <button id="btn-add" name="update" class="btn btn-outline-success">Cập nhật</button>
    <button type="reset" class="btn btn-outline-success">Nhập lại</button>
    <a href="./index.php?action=blogs" type="submit" class="btn btn-outline-success">Danh sách</a>
</form>