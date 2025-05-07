<div id="nganh-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý ngành</h1>
        <div class="flex items-center gap-4">
            <!-- <button type="button" class="action-item btn btn-primary" data-act="ks-tao"
                data-aria-haspopup="dialog" aria-expanded="false"
                aria-controls="create-ks-modal" data-overlay="#create-ks-modal">Tạo bài khảo sát</button> -->
            <button type="button" class="action-item btn btn-primary" data-act="nganh-them">Thêm ngành</button>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <input type="text" class="input w-48" id="search-keyword" name="keyword" />
            </div>
            <div>
                <button type="button" class="btn btn-primary h-10" id="btn-search" name="search">Tìm kiếm</button>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <select class="select" id="select-status">
                    <option value="-1">Chọn trạng thái</option>
                    <option value="1">Đang sử dụng</option>
                    <option value="0">Đã khóa</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" id="btn-loc" data-act="nganh-loc">Lọc</button>
            <button type="button" class="btn btn-primary " id="btn-reset" data-act="reset">Reset</button>
        </div>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="table-striped table">
            <thead>
                <tr>
                    <th>Mã Ngành</th>
                    <th>Ngành</th>
                    <th>Trạng thái</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="nganh-list">
            </tbody>
        </table>
        <div id="pagination" class="flex justify-center space-x-2"></div>
    </div>
</div>
<script src="./views/javascript/nganh.js"></script>
