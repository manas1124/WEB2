<div id="kqks-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Kết quả khảo sát</h1>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <label class="label-text" for="select-status">Status </label>
                <select class="select" id="select-status">
                    <option value="-1">Chọn status</option>
                </select>
            </div>
            <button class="btn btn-primary" data-act="kqks-loc">Lọc</button>
        </div>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã khỏa sát</th>
                    <th>Tên khảo sát</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngay kết thúc</th>
                    <th>Nhóm khảo sát</th>
                    <th>CTDT</th>
                    <th>Trạng thái</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="kqks-list">
                <tr>
                    <th>1</th>
                    <th>khảo sát mùa thu</th>
                    <th>1-1-1</th>
                    <th>1=3-1</th>
                    <th>Nhóm ksss</th>
                    <th>NNA</th>
                    <th>HD</th>
                    <td>1</td>
                    <td>
                        <button class="btn btn-primary" data-act="kqks-chitiet">Xem chi tiết</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
<script src="../node_modules/flyonui/flyonui.js"></script>