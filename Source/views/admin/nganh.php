<div id="nganh-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý ngành</h1>
        <div class="flex items-center gap-4">
            <!-- <button type="button" class="action-item btn btn-primary" data-act="ks-tao"
                data-aria-haspopup="dialog" aria-expanded="false"
                aria-controls="create-ks-modal" data-overlay="#create-ks-modal">Tạo bài khảo sát</button> -->
            <button class="action-item btn btn-primary" data-act="nganh-them">Thêm ngành</button>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <label class="label-text" for="select-status">Status </label>
                <select class="select" id="select-status">
                    <option value="-1">Chọn status</option>
                </select>
            </div>
            <button class="btn btn-primary" data-act="nganh-loc">Lọc</button>
        </div>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã Ngành</th>
                    <th>Ngành</th>
                    <th>Trạng thái</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="nganh-list">
                <tr>
                    <td>1</td>
                    <td>công nghệ thông tin</td>
                    <td>1</td>
                    <td>
                        <button class="action-item btn btn-primary" data-act="nganh-sua">Sửa</button>
                        <button class="btn btn-primary" data-act="nganh-khoa">Khóa</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
<script src="../node_modules/flyonui/flyonui.js"></script>
<script src="./views/javascript/nganh.js"></script>
