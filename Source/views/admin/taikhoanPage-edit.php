<a href="" class="back-link btn btn-soft ">Quay lại</a>
<h3 class="modal-title mb-8">Sửa tài khoản</h3>
<div class="overflow-y-auto">
    <!-- thong tin chung -->
    <div class="flexx flex-row">
        <div class="pt-0 mb-4 ">
            <div class="w-96">
                <label class="label-text" for="username">ID</label>
                <input type="text" placeholder="" class="input" id="tk_id" readonly/>
            </div>
            <div class="w-96">
                <label class="label-text" for="username">Username</label>
                <input type="text" placeholder="" class="input" id="username" />
            </div>
            <div class="w-96">
                <label class="label-text" for="password">Password</label>
                <input type="text" placeholder="" class="input" id="password" />
            </div>
            <div class="w-96">
                <label class="label-text" for="select-doituong">Đối tượng</label>
                <select class="select" id="select-doituong">
                    <option value="-1">--Chọn đối tượng--</option>
                </select>
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
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Đã khóa</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer border-t border-base-content/10">
        <button id="btn-save-tk" type="submit" class="btn btn-primary">Lưu</button>
    </div>
</div>
<script src="views/javascript/taiKhoanPage-edit.js"></script>