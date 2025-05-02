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
                    <option value="1">Chương trình đào tạo</option>
                    <option value="0">Chuẩn đầu ra</option>
                </select>
            </div>
            <div>
                <label class="label-text" for="select-status">Status </label>
                <select class="select" id="select-status">
                    <option value="-1">Chọn status</option>
                    <option value="1">Đang sử dụng</option>
                    <option value="0">Đã khóa</option>
                </select>
            </div>
            <button class="btn btn-primary" id="btn-loc" data-act="ctdt-loc">Lọc</button>
        </div>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="table-striped table">
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

            </tbody>
        </table>
        <div id="pagination" class="flex justify-center space-x-2">
        </div>
    </div>
</div>
<script src="./views/javascript/ctdtPage.js"></script>