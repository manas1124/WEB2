<div class="flex flex-col w-full">
    <div>
        <button id="return-page" class="back-link btn btn-soft ">Quay lại</button>
    </div>
    <div class="flex justify-center">
        <h3 class="modal-title mb-4">Thông tin cá nhân</h3>
    </div>
    <div class="flex justify-center">
        <div class="flex flex-row">
            <div class="modal-body pt-0 mb-4">
                <div class="w-96 edit-infor">
                    <label class="label-text" for="hoten">Tên người dùng:</label>
                    <input type="text" class="input edit-infor" id="hoten" disabled />
                    <label class="label-text" for="email">Email:</label>
                    <input type="text" class="input edit-infor" id="email" disabled />
                    <label class="label-text" for="phone">Điện thoại:</label>
                    <input type="text" class="input edit-infor" id="phone" disabled />
                    <label class="label-text" for="address">Địa chỉ:</label>
                    <input type="text" class="input edit-infor" id="address" disabled />
                    <label class="label-text" for="target">Loại đối tượng:</label>
                    <input type="text" class="input" id="target" placeholder="trống" disabled />
                </div>
            </div>
        </div>
        <div class="flex flex-row edit-account hidden">
            <div class="modal-body pt-0 mb-4">
                <div class="w-96">
                    <label class="label-text" for="previousPassword">Mật khẩu cũ:</label>
                    <input type="password" class="input" id="previousPassword" />
                    <label class="label-text" for="password">Mật khẩu:</label>
                    <input type="password" class="input" id="password" />
                    <label class="label-text" for="confirm-pass">Xác nhận mật khẩu:</label>
                    <input type="password" class="input" id="confirm-pass" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer border-t border-base-content/10">
        <button id="btn-edit-infor" onclick="toggleEditInfor(true)" class="edit-infor btn-edit-infor btn btn-primary">Sửa thông tin cá nhân<button>
        <button id="submit-edit-infor" onclick="submitEditPersonal()" class="edit-infor hidden btn btn-primary hidden">Cập nhật</button>
        <button id="btn-edit-account" onclick="toggleEditAcc(true)" class="btn btn-primary">Đổi mật khẩu</button>
        <button id="submit-edit-account" class="edit-account hidden btn btn-primary hidden">Đổi mật khẩu</button>
        <button id="btn-exit-edit" onclick="backNormal()"  class="btn btn-primary hidden">Hủy</button>
    </div>
</div>
<script src="./views/javascript/jquery-3.7.1.min.js"></script>
<script src="./views/javascript/userInfor.js"></script>

</script>