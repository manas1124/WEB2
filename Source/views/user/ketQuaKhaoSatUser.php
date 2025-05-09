<div id="kqks-content" class="container h-full p-5">
    <div class="flex items-center justify-between mb-4">
        <h1>Kết quả khảo sát</h1>
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
                <label class="label-text" for="from-date">Từ ngày</label>
                <input type="date" class="input" name="from_date" id="from-date" />
            </div>
            <div>
                <label class="label-text" for="to-date">Đến ngày</label>
                <input type="date" class="input" name="to_date" id="to-date" />
            </div>
            <div>
                <button type="button" class="btn btn-primary" id="btn-filter" name="loc" data-act="kqks-loc">Lọc</button>
                <button type="button" class="btn btn-primary" id="btn-reset" data-act="reset">Reset</button>
            </div>
        </div>
    </div>
    <div class="w-full overflow-x-auto h-[500]">
        <table class="table-striped table">
            <thead>
                <tr>
                    <th>Tên khảo sát</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngay kết thúc</th>
                    <th>Nhóm khảo sát</th>
                    <th>Ngành</th>
                    <th>Chu kỳ</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="ks-list">

            </tbody>
        </table>
    </div>
    <div id="pagination" class="flex justify-center space-x-2"></div>
</div>

<script src="./views/javascript/ketquakhaosatUser.js"></script>