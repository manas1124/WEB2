<div id="chuky-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý chu kỳ</h1>
        <div class="flex items-center gap-4">
            <!-- <button type="button" class="action-item btn btn-primary" data-act="ks-tao"
                data-aria-haspopup="dialog" aria-expanded="false"
                aria-controls="create-ks-modal" data-overlay="#create-ks-modal">Tạo bài khảo sát</button> -->
            <button type="button" class="action-item btn btn-primary" data-act="chuky-them">Thêm chu kỳ</button>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div class="w-96 relative">
                <input type="text" placeholder="Nhập nội dung tìm kiếm" class="input ps-8" id="search-keyword" name="keyword" aria-expanded="false"/>
                <span class="icon-[tabler--search] text-base-content absolute start-3 top-1/2 size-4 shrink-0 -translate-y-1/2"></span>
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
            <button type="button" class="btn btn-primary" id="btn-loc" data-act="chuky-loc">Lọc</button>
            <button type="button" class="btn btn-primary" id="btn-reset" data-act="reset">Reset</button>
        </div>
    </div>

    <div class="w-full overflow-x-auto h-[500px]">
        <table class="table-striped table">
            <thead>
                <tr>
                    <th>Mã Chu kỳ</th>
                    <th>Chu kỳ</th>
                    <th>Trạng thái</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="chuky-list">


            </tbody>
        </table>
    </div>
    <div id="pagination" class="flex justify-center space-x-2">
    </div>
</div>
<script src="./views/javascript/chuky.js"></script>