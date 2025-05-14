<div class="flex flex-col w-full">
    <div>
        <button id="return-page" class="back-link btn btn-soft ">Quay lại</button>
    </div>
    <div class="flex justify-center">
        <h3 class="modal-title mb-4">Tạo tài khoản</h3>
    </div>
    <div class="flex justify-center">
        <!-- thong tin chung -->
        <div class="flex flex-row">
            <div class="modal-body pt-0 mb-4">
                <div class="w-96">
                    <label class="label-text" for="file-decuong">Tên đăng nhập </label>
                    <input type="text" placeholder="" class="input" id="username" />
                </div>
                <div class="w-96">
                    <label class="label-text" for="password">Mật khẩu </label>
                    <input type="password" placeholder="" class="input" id="password" />
                </div>
                <div class="w-96">
                    <label class="label-text" for="select-quyen">Quyền</label>
                    <select class="select" id="select-quyen">
                        <option value="-1">--Chọn quyền--</option>
                    </select>
                </div>
                <div class="w-96">
                    <label class="label-text" for="select-status">Status</label>
                    <select class="select" id="select-status">
                        <option value="1">Đang sử dụng</option>
                        <option value="0">Đã khóa</option>
                    </select>
                </div>
            </div>
            <div class="modal-body pt-0 mb-4">
                <div class="w-96">
                    <label class="label-text" for="">Họ tên: </label>
                    <input type="text" placeholder="" class="input" id="ho-ten" />
                </div>
                <div class="w-96">
                    <label class="label-text" for="email">Email: </label>
                    <input type="text" placeholder="" class="input" id="email" />
                </div>
                <div class="w-96">
                    <label class="label-text" for="sdt">Số điện thoại: </label>
                    <input type="text" placeholder="" class="input" id="sdt" />
                </div>
                <div class="w-96">
                    <label class="label-text" for="address">Địa chỉ</label>
                    <input type="text" placeholder="" class="input" id="address" />
                </div>
                <div class="w-96">
                    <label class="label-text" for="select-loai">Loại đối tượng</label>
                    <select class="select" id="loai">
                        <option value="1">Sinh viên</option>
                        <option value="2">Giảng viên</option>
                        <option value="3">Doanh nghiệp</option>
                    </select>
                </div>
            </div>
        </div>

        
    </div>
    <div class="flex justify-center">
            <button id="btn-create" type="submit" class="btn btn-primary">Thêm</button>
        </div>
</div>
<script src="./views/javascript/taiKhoanPage.js"></script>
  
 
<script>
     $("#return-page").on("click", function () {
        console.log('test')
    window.location.href = "./admin.php?page=taiKhoanPage";
  });
</script>