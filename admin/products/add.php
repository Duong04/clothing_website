<h4>Thêm sản phẩm</h4>
<form id="yourFormId" method="POST" enctype="multipart/form-data">
    <div class="grid">
        <div class="mb-3">
            <label for="" class="form-label">Mã sản phẩm</label>
            <input required type="text" class="form-control" disabled placeholder="Tự động nhập">
        </div>
        <div class="mb-3">
            <label for="name-product" class="form-label">Tên sản phẩm</label>
            <input required placeholder="Tên sản phẩm" name="product_name" type="text" class="form-control border-2" id="name-product">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh sản phẩm</label>
            <input required name="image_product" class="form-control" type="file" id="formFile">
        </div>
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Thư viện ảnh</label>
            <input name="images[]" class="form-control" type="file" id="formFileMultiple" multiple>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Đơn giá</label>
            <input oninput="validatePrice(this)" min="0" required placeholder="Đơn giá sản phẩm" name="price" type="number" class="form-control border-2" id="price">
        </div>
        <div class="mb-3 form-outline">
            <label class="form-label" for="typeNumber">Phần trăm giảm giá</label>
            <input name="sale" oninput="validateDiscount(this)" placeholder="Phần trăm giảm giá" min="0" max="100" type="number" id="typeNumber" class="form-control" />
        </div>
        <div class="mb-3 form-outline">
            <label class="form-label" for="quantity_product">Số lượng sản phẩm</label>
            <input oninput="validatePrice(this)" required name="quantity" placeholder="Số lượng sản phẩm" min="0" type="number" id="quantity_product" class="form-control" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="category">Danh mục sản phẩm</label>
            <select style="height: 40px;" id="category" name="category" required class="form-select" aria-label="Default select example">
            <?php 
            $result = selectCategoryAll("SELECT * FROM categories");
            foreach ($result as $row) {
            ?>
                <option value="<?=$row['category_id']?>"><?=$row['category_name']?></option>
            <?php } ?>
            </select>
        </div>
    </div>
    <div class="mb-3" style="margin-top:30px;">
        <label for="description" class="form-label">Mô tả sản phẩm</label>
        <textarea required class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
    </div>
    <button id="btn-add" name="add" class="btn btn-outline-success">Thêm</button>
    <button type="reset" class="btn btn-outline-success">Nhập lại</button>
    <a href="./index.php?action=products" type="submit" class="btn btn-outline-success">Danh sách</a>
</form>