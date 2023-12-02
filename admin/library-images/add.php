<h4>Thêm ảnh mới</h4>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="formFileMultiple" class="form-label">Danh sách ảnh</label>
      <input required name="images[]" class="form-control" type="file" id="formFileMultiple" multiple>
    </div>
    <button id="btn-add" name="add" class="btn btn-outline-success">Thêm</button>
    <button type="reset" class="btn btn-outline-success">Nhập lại</button>
    <?php if (isset($_GET['idP'])) $id = $_GET['idP']; ?>
    <a href="./index.php?action=list-detail&idP=<?=$id?>" type="submit" class="btn btn-outline-success">Danh sách</a>
</form>