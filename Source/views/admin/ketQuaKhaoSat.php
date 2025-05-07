<div id="kqks-content" class="container h-full p-5">
    <div class="flex items-center justify-between mb-4">
        <h1>Kết quả khảo sát</h1>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <label class="label-text mb-1">Status</label>
                <input type="text" class="input w-48" />
            </div>
            <div>
                <label class="label-text" for=""></label>
                <button class="btn btn-primary h-10">Lọc</button>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <label class="label-text" for="">Status </label>
                <select class="select" id="">
                    <option value="-1">Chọn status</option>
                </select>
            </div>
            <div>
                <label class="label-text" for="">ngay </label>
                <input type="date" class="input" name="" id="">
            </div>
            <div>
                <label class="label-text" for="">ngay </label>
                <input type="date" class="input" name="" id="">
            </div>
            <div>
                <label class="label-text" for="">Status </label>
                <select class="select" id="">
                    <option value="-1">Chọn status</option>
                </select>
            </div>
            <div>
                <label class="label-text" for="">Status </label>
                <select class="select" id="">
                    <option value="-1">Chọn status</option>
                </select>
            </div>
            <div>
                <label class="label-text" for=""></label>
                <button class="btn btn-primary" data-act="kqks-loc">Lọc</button>
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
    </div>
</div>

<script src="./views/javascript/ketquakhaosat.js"></script>