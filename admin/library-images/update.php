<h4>Cập nhật ảnh mới</h4>
<?php if (isset($_GET['idP'])) $idP = $_GET['idP']; ?>
<form action="./index.php?action=handle-image&idP=<?=$idP?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="formFileMultiple" class="form-label">Ảnh</label>
      <input required name="image" class="form-control" type="file" id="formFileMultiple">
      <img style="width: 45px;" src="<?=$row['image']?>" alt="">
    </div>
    <input name="id" value="<?=$row['image_id']?>" type="hidden">
    <button id="btn-add" name="update" class="btn btn-outline-success">Cập nhật</button>
    <button type="reset" class="btn btn-outline-success">Nhập lại</button>
    <?php if (isset($_GET['idP'])) $id = $_GET['idP']; ?>
    <a href="./index.php?action=list-detail&idP=<?=$id?>" type="submit" class="btn btn-outline-success">Danh sách</a>
</form>