<div id="ctdt-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý chương trình đào tạo</h1>
        <div class="flex items-center gap-4">
            <button class="action-item btn btn-primary" data-act="ctdt-them">Thêm Ctdt</button>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <label class="label-text" for="select-nganh">Ngành </label>
                <select class="select" id="select-nganh">
                    <option value="-1">Chọn ngành</option>
                </select>
            </div>
            <div>
                <label class="label-text" for="select-chuky">Chu kỳ </label>
                <select class="select" id="select-chuky">
                    <option value="-1">Chọn chu kỳ</option>
                </select>
            </div>
            <div>
                <label class="label-text" for="select-loai">Loại </label>
                <select class="select" id="select-loai">
                    <option value="-1">Chọn loại</option>
                </select>
            </div>
            <div>
                <label class="label-text" for="select-status">Status </label>
                <select class="select" id="select-status">
                    <option value="-1">Chọn status</option>
                </select>
            </div>
            <button class="btn btn-primary" data-act="ctdt-loc">Lọc</button>
        </div>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã CTDT</th>
                    <th>Ngành</th>
                    <th>Chu kỳ</th>
                    <th>Loại</th>
                    <th>File</th>
                    <th>Trạng thái</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="ctdt-list">
                <tr>
                    <td>1</td>
                    <td>công nghệ thông tin</td>
                    <td>2020-2024</td>
                    <td>ctdt</td>
                    <td>1234</td>
                    <td>1</td>
                    <td>
                        <button class="action-item btn btn-primary" data-act="ctdt-sua">Sửa Ctdt</button>
                        <button class="btn btn-primary" data-act="ctdt-khoa">Khóa</button>
                    </td>
                </tr>

            </tbody>
        </table>
        <div id="pagination"></div>
    </div>
</div>
<script src="./views/javascript/ctdtPage.js"></script>
<script src="../node_modules/flyonui/flyonui.js"></script>