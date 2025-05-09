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
                    <td><input type="checkbox" class="checkbox" id="view.survey" value="view.survey" /></td>
                    <td><input type="checkbox" class="checkbox" id="create.survey" value="create.survey" /></td>
                    <td><input type="checkbox" class="checkbox" id="edit.survey" value="edit.survey" /></td>
                    <td><input type="checkbox" class="checkbox" id="delete.survey" value="delete.survey" /></td>
                </tr>
                <tr id="nganh-chuky-ctdt-row">
                    <td>Quản lý ngành,chu kì, chương trình đào tạo</td>
                    <td><input type="checkbox" class="checkbox" id="view.program" value="view.program" /></td>
                    <td><input type="checkbox" class="checkbox" id="create.program" value="create.program" /></td>
                    <td><input type="checkbox" class="checkbox" id="edit.program" value="edit.program" /></td>
                    <td><input type="checkbox" class="checkbox" id="delete.program" value="delete.program" /></td>
                </tr>
                <tr id="doiTuong-nhomDoiTuong-row">
                    <td>Quản lý đối tượng và nhóm đối tượng</td>
                    <td><input type="checkbox" class="checkbox" id="view.target" value="view.target" /></td>
                    <td><input type="checkbox" class="checkbox" id="create.target" value="create.target" /></td>
                    <td><input type="checkbox" class="checkbox" id="edit.target" value="edit.target" /></td>
                    <td><input type="checkbox" class="checkbox" id="delete.target" value="delete.target" /></td>
                </tr>
                <tr id="taiKhoan-row">
                    <td>Quản lý tài khoản</td>
                    <td><input type="checkbox" class="checkbox" id="view.account" value="view.account" /></td>
                    <td><input type="checkbox" class="checkbox" id="create.account" value="create.account" /></td>
                    <td><input type="checkbox" class="checkbox" id="edit.account" value="edit.account" /></td>
                    <td><input type="checkbox" class="checkbox" id="delete.account" value="delete.account" /></td>
                </tr>
                <tr id="quyen-row">
                    <td>Quản lý quyền</td>
                    <td><input type="checkbox" class="checkbox" id="view.permission" value="view.permission" /></td>
                    <td><input type="checkbox" class="checkbox" id="create.permission" value="create.permission" /></td>
                    <td><input type="checkbox" class="checkbox" id="edit.permission" value="edit.permission" /></td>
                    <td><input type="checkbox" class="checkbox" id="delete.permission" value="delete.permission" /></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer border-t border-base-content/10">
        <button id="btn-save" type="submit" class="btn btn-primary">Cập nhật</button>
    </div>
</div>
<script src="views/javascript/quyenPage-edit.js"></script>