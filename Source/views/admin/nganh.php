<div id="nganh-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý ngành</h1>
        <div class="flex items-center gap-4">
            <!-- <button type="button" class="action-item btn btn-primary" data-act="ks-tao"
                data-aria-haspopup="dialog" aria-expanded="false"
                aria-controls="create-ks-modal" data-overlay="#create-ks-modal">Tạo bài khảo sát</button> -->
            <button type="button" class="action-item btn btn-primary create-program hidden" data-act="nganh-them">Thêm ngành</button>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div class="w-96 relative">
                <label class="label-text mb-1" for="search-keyword">Tìm kiếm</label>
                <input type="text" placeholder="Nhập nội dung tìm kiếm" class="input ps-8" id="search-keyword" name="keyword" aria-expanded="false" />
                <span class="icon-[tabler--search] text-base-content absolute left-3 top-1/2 transform translate-y-1/3 -translate-x-1/4 text-xl"></span>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <label class="label-text mb-1" for="select-status">Trạng thái</label>
                <select class="select" id="select-status">
                    <option value="-1">Tất cả</option>
                    <option value="1">Đang sử dụng</option>
                    <option value="0">Đã khóa</option>
                </select>
            </div>
            <div>
                <label class="label-text mb-1 invisible">Lọc</label>
                <button type="button" class="btn btn-primary" id="btn-loc" data-act="nganh-loc">Lọc</button>
            </div>
            <div>
                <label class="label-text mb-1 invisible">Đặt lại</label>
                <button type="button" class="btn btn-primary " id="btn-reset" data-act="reset">Đặt lại</button>
            </div>
        </div>
    </div>
    <div class="w-full overflow-x-auto h-[500px]">
        <table class="table-striped table">
            <thead>
                <tr>
                    <th>Mã Ngành</th>
                    <th>Ngành</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="nganh-list">
            </tbody>
        </table>
    </div>
    <div id="pagination" class="flex justify-center space-x-2"></div>
</div>
<script src="./views/javascript/nganh.js"></script>