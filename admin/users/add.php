<h4>Thêm sản phẩm</h4>
<form id="yourFormId" method="POST" enctype="multipart/form-data">
    <div class="grid">
        <div class="mb-3">
            <label for="name-product" class="form-label">Tên người dùng</label>
            <input required placeholder="Tên người dùng" name="user_name" type="text" class="form-control border-2" id="name-product">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input required placeholder="Email" name="email" type="email" class="form-control border-2" id="email">
        </div>
        <div class="mb-3">
            <label for="psw" class="form-label">Mật khẩu</label>
            <input required placeholder="Mật khẩu" name="psw" type="password" class="form-control border-2" id="psw">
        </div>
        <div style="display: flex; gap: 20px;" class="mb-3">
            <div style="display: flex; flex-direction: column;" class="mb-4">
                <input checked value="nhân viên" name="role" type="radio">
                <span>Nhân viên</span>
            </div>
            <div style="display: flex; flex-direction: column;" class="mb-4">
                <input value="Khách hàng" name="role" type="radio">
                <span>Khách hàng</span>
            </div>
        </div>
        <div style="display: flex; gap: 20px;" class="mb-3">
            <div style="display: flex; flex-direction: column;" class="mb-4">
                <input checked value="Chưa kích hoạt" name="status" type="radio">
                <span>Không kích hoạt</span>
            </div>
            <div style="display: flex; flex-direction: column;" class="mb-4">
                <input value="Đã kích hoạt" name="status" type="radio">
                <span>Kích hoạt</span>
            </div>
        </div>
    </div>
    <button id="btn-add" name="add" class="btn btn-outline-success">Thêm</button>
    <button type="reset" class="btn btn-outline-success">Nhập lại</button>
    <a href="./index.php?action=users" type="submit" class="btn btn-outline-success">Danh sách</a>
</form>