<h4>Cập nhật sản phẩm</h4>
<form action="index.php?action=handle-productC" id="yourFormId" method="POST" enctype="multipart/form-data">
    <div class="grid">
        <div class="mb-3">
            <label for="" class="form-label">Mã sản phẩm</label>
            <input value="<?=$row['product_id']?>" required type="text" class="form-control" disabled placeholder="Tự động nhập">
        </div>
        <div class="mb-3">
            <label for="name-product" class="form-label">Tên sản phẩm</label>
            <input value="<?=$row['product_name']?>" required placeholder="Tên danh mục" name="product_name" type="text" class="form-control border-2" id="name-product">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh sản phẩm</label>
            <input name="image_product" class="form-control" type="file" id="formFile">
            <img style="width: 40px; height: 40px; margin-top: 10px;" src="<?=$row['product_image']?>" alt="">
        </div>
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Thư viện ảnh</label>
            <input name="images[]" class="form-control" type="file" id="formFileMultiple" multiple>
            <div>
            <?php foreach($row2 as $list) { ?>
                <img style="width:40px; height: 40px; margin-top: 10px;" src="<?=$list['image']?>" alt="">
            <?php } ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Đơn giá</label>
            <input oninput="validatePrice(this)" value="<?=$row['price']?>" required placeholder="Đơn giá sản phẩm" name="price" type="number" class="form-control border-2" id="price">
        </div>
        <div class="mb-3 form-outline">
            <label class="form-label" for="typeNumber">Phần trăm giảm giá</label>
            <input value="<?=$row['sale']?>" name="sale" oninput="validateDiscount(this)" required placeholder="Phần trăm giảm giá" min="0" max="100" type="number" id="typeNumber" class="form-control" />
        </div>
        <div class="mb-3 form-outline">
            <label class="form-label" for="quantity_product">Số lượng sản phẩm</label>
            <input oninput="validatePrice(this)" value="<?=$row['quantity_product']?>" required name="quantity" placeholder="Số lượng sản phẩm" min="0" type="number" id="quantity_product" class="form-control" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="category">Danh mục sản phẩm</label>
            <select style="height: 40px;" id="category" name="category" required class="form-select" aria-label="Default select example">
                <?php 
            $query = selectCategoryAll("SELECT * FROM categories");
            foreach ($query as $list) {
                if ($row['category_id'] == $list['category_id']){
                    ?>
                <option value="<?=$list['category_id']?>" selected><?=$list['category_name']?></option>
                <?php }else { ?>
                <option value="<?=$list['category_id']?>"><?=$list['category_name']?></option>
            <?php } } ?>
            </select>
        </div>
    </div>
    <div class="mb-3" style="margin-top:30px;">
        <label for="description" class="form-label">Mô tả sản phẩm</label>
        <textarea required class="form-control" name="description" id="description" cols="30" rows="10"><?=$row['description']?></textarea>
    </div>
    <input name="id" value="<?=$row['product_id']?>" type="hidden">
    <button name="update" class="btn btn-outline-success">Cập nhật</button>
    <button type="reset" class="btn btn-outline-success">Nhập lại</button>
    <a href="./index.php?action=products" type="submit" class="btn btn-outline-success">Danh sách</a>
</form>