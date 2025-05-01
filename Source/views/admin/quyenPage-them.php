<div class="flex flex-col w-full">
    <div>
        <a class="back-link btn btn-soft ">Quay lại</a>
    </div>
    <div class="flex justify-center">
        <h3 class="modal-title">Thêm quyền</h3>
    </div>


    <div class="flex justify-center">
        <div class="flex flex-row">
            <div class="modal-body pt-0 mb-4">
                <div class="w-96">
                    <label class="label-text" for="file-decuong">Tên quyền</label>
                    <input type="text" placeholder="" class="input" id="ten_quyen" />
                    <div class="w-96">
                        <label class="label-text" for="select-status">Status</label>
                        <select class="select" id="select-status">
                            <option value="1">Đang sử dụng</option>
                            <option value="0">Đã khóa</option>
                        </select>
                    </div>
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
            <tbody>
                <tr>
                    <td>Quản lý khảo sát</td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" checked /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                </tr>
                <tr>
                    <td>Quản lý ngành,chu kì, chương trình đào tạo</td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" checked /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                </tr>
                <tr>
                    <td>Quản lý đối tượng và nhóm đối tượng</td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" checked /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                </tr>
                <tr>
                    <td>Quản lý tài khoản</td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" checked /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                </tr>
                <tr>
                    <td>Quản lý quyền</td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" checked /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                    <td><input type="checkbox" class="checkbox" id="checkboxDefault" /></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer border-t border-base-content/10">
        <button id="btn-create" type="submit" class="btn btn-primary">Thêm</button>
    </div>
</div>
<script src="./views/javascript/quyenPage.js"></script>