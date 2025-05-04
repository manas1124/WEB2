<div class="flex flex-col w-full">
    <div>
        <button id="return-page" class="back-link btn btn-soft ">Quay lại</button>
    </div>
    <div class="flex justify-center">
        <h3 class="modal-title">Sửa quyền</h3>
    </div>

    <div class="flex justify-center">
        <div class="flex flex-row">
            <div class="modal-body pt-0 mb-4">
                <div class="w-96">
                    <label class="label-text" for="ten-quyen">Tên quyền</label>
                    <input type="text" placeholder="" class="input" id="ten-quyen" />
                </div>
            </div>


        </div>
    </div>
    <div class="border-base-content/25 w-full overflow-x-auto border">
        <table class="table">
            <thead>
                <tr>
                    <th class="w-1/4">Tên chức năng</th>
                    <th>Xem</th>
                    <th>Thêm</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody id="checkbox-data">
                <tr id="khaoSat-row">
                    <td>Quản lý khảo sát</td>
                    <td><input type="checkbox" class="checkbox" id="ks-read" value="ks-read" /></td>
                    <td><input type="checkbox" class="checkbox" id="ks-create" value="ks-create" /></td>
                    <td><input type="checkbox" class="checkbox" id="ks-edit" value="ks-edit" /></td>
                    <td><input type="checkbox" class="checkbox" id="ks-delete" value="ks-delete" /></td>
                </tr>
                <tr id="nganh-chuky-ctdt-row">
                    <td>Quản lý ngành,chu kì, chương trình đào tạo</td>
                    <td><input type="checkbox" class="checkbox" id="nhomCkCtdt-read" value="nhomCkCtdt-read" /></td>
                    <td><input type="checkbox" class="checkbox" id="nhomCkCtdt-create" value="nhomCkCtdt-create" /></td>
                    <td><input type="checkbox" class="checkbox" id="nhomCkCtdt-edit" value="nhomCkCtdt-edit" /></td>
                    <td><input type="checkbox" class="checkbox" id="nhomCkCtdt-delete" value="nhomCkCtdt-delete" /></td>
                </tr>
                <tr id="doiTuong-nhomDoiTuong-row">
                    <td>Quản lý đối tượng và nhóm đối tượng</td>
                    <td><input type="checkbox" class="checkbox" id="doiTuong-read" value="doiTuong-read" /></td>
                    <td><input type="checkbox" class="checkbox" id="doiTuong-create" value="doiTuong-create" /></td>
                    <td><input type="checkbox" class="checkbox" id="doiTuong-edit" value="doiTuong-edit" /></td>
                    <td><input type="checkbox" class="checkbox" id="doiTuong-delete" value="doiTuong-delete" /></td>
                </tr>
                <tr id="taiKhoan-row">
                    <td>Quản lý tài khoản</td>
                    <td><input type="checkbox" class="checkbox" id="tk-read" value="tk-read" /></td>
                    <td><input type="checkbox" class="checkbox" id="tk-create" value="tk-create" /></td>
                    <td><input type="checkbox" class="checkbox" id="tk-edit" value="tk-edit" /></td>
                    <td><input type="checkbox" class="checkbox" id="tk-delete" value="tk-delete" /></td>
                </tr>
                <tr id="quyen-row">
                    <td>Quản lý quyền</td>
                    <td><input type="checkbox" class="checkbox" id="quyen-read" value="quyen-read" /></td>
                    <td><input type="checkbox" class="checkbox" id="quyen-create" value="quyen-create" /></td>
                    <td><input type="checkbox" class="checkbox" id="quyen-edit" value="quyen-edit" /></td>
                    <td><input type="checkbox" class="checkbox" id="quyen-delete" value="quyen-delete" /></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer border-t border-base-content/10">
        <button id="btn-save" type="submit" class="btn btn-primary">Cập nhật</button>
    </div>
</div>
<script src="views/javascript/quyenPage-edit.js"></script>