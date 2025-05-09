<a href="" class="back-link btn btn-soft ">Quay lại</a>

<h3 class="modal-title">Thêm tài khoản</h3>

<div class="overflow-y-auto">
    <!-- thong tin chung -->
    <div class="flex flex-row">
        <div class="modal-body pt-0 mb-4">
            <div class="w-96">
                <label class="label-text" for="file-decuong">username </label>
                <input type="text" placeholder="" class="input" id="username" />
            </div>
            <div class="w-96">
                <label class="label-text" for="select-nganh">password </label>
                <input type="password" placeholder="" class="input" id="password" />
            </div>
            <div class="w-96">
                <label class="label-text" for="select-chuky">Đối tượng</label>
                <select class="select" id="select-doituong">
                    <option value="-1">--Chọn đối tượng--</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="select-loai">Quyền</label>
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
    </div>

    <div class="modal-footer border-t border-base-content/10">
        <button id="btn-create" type="submit" class="btn btn-primary">Thêm</button>
    </div>
</div>
<script src="./views/javascript/taiKhoanPage.js"></script>