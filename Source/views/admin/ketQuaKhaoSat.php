<div id="kqks-content" class="container h-full p-5">
    <div class="flex items-center justify-between mb-4">
        <h1>Kết quả khảo sát</h1>
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
                <label class="label-text" for="from-date">Từ ngày</label>
                <input type="date" class="input" name="from_date" id="from-date" />
            </div>
            <div>
                <label class="label-text" for="to-date">Đến ngày</label>
                <input type="date" class="input" name="to_date" id="to-date" />
            </div>
            <div>
                <select class="select" id="select-nhom" name="nhom_khao_sat">
                    <option value="-1">Chọn nhóm khảo sát</option>
                </select>
            </div>
            <div>
                <select class="select" id="select-nganh" name="nganh">
                    <option value="-1">Chọn ngành</option>
                </select>
            </div>
            <div>
                <select class="select" id="select-chuky" name="chuky">
                    <option value="-1">Chọn chu kỳ</option>
                </select>
            </div>
            <div>
                <button type="button" class="btn btn-primary" id="btn-filter" name="loc" data-act="kqks-loc">Lọc</button>
                <button type="button" class="btn btn-primary" id="btn-reset" data-act="reset">Reset</button>
            </div>
        </div>
    </div>
    <div class="w-full overflow-x-auto">
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
        <div id="pagination" class="flex justify-center space-x-2">
            
        </div>
    </div>
</div>

<script src="./views/javascript/ketquakhaosat.js"></script>