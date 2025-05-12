<div id="ctdt-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý chương trình đào tạo</h1>
        <div class="flex items-center gap-4">
            <button class="action-item btn btn-primary create-program hidden" data-act="ctdt-them">Thêm Ctdt</button>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div class="w-96 relative">
                <input type="text" placeholder="Nhập nội dung tìm kiếm" class="input ps-8" id="search-keyword" name="keyword" aria-expanded="false" />
                <span class="icon-[tabler--search] text-base-content absolute start-3 top-1/2 size-4 shrink-0 -translate-y-1/2"></span>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <select class="select" id="select-nganh">
                    <option value="-1">Chọn ngành</option>
                </select>
            </div>
            <div>
                <select class="select" id="select-chuky">
                    <option value="-1">Chọn chu kỳ</option>
                </select>
            </div>
            <div>
                <select class="select" id="select-loai">
                    <option value="-1">Chọn loại</option>
                    <option value="1">Chương trình đào tạo</option>
                    <option value="0">Chuẩn đầu ra</option>
                </select>
            </div>
            <div>
                <select class="select" id="select-status">
                    <option value="-1">Chọn trạng thái</option>
                    <option value="1">Đang sử dụng</option>
                    <option value="0">Đã khóa</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" id="btn-loc" data-act="ctdt-loc">Lọc</button>
            <button type="button" class="btn btn-primary" id="btn-reset" data-act="reset">Reset</button>
        </div>
    </div>
    <div class="w-full overflow-x-auto h-[500px]">
        <table class="table-striped table">
            <thead>
                <tr>
                    <th>Mã CTDT</th>
                    <th>Ngành</th>
                    <th>Chu kỳ</th>
                    <th>Loại</th>
                    <th>Đề cương</th>
                    <th>Trạng thái</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="ctdt-list">

            </tbody>
        </table>    
    </div>
    <div id="pagination" class="flex justify-center space-x-2"></div>
</div>
<script src="./views/javascript/ctdtPage.js"></script>