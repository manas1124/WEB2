<div id="chuky-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý chương trình đào tạo</h1>
        <div class="flex items-center gap-4">
            <!-- <button type="button" class="action-item btn btn-primary" data-act="ks-tao"
                data-aria-haspopup="dialog" aria-expanded="false"
                aria-controls="create-ks-modal" data-overlay="#create-ks-modal">Tạo bài khảo sát</button> -->
            <button class="action-item btn btn-primary" data-act="ctdt-them">Thêm Ctdt</button>
            <button class="action-item btn btn-primary" data-act="ctdt-sua">Sửa Ctdt</button>
            <button class="action-item btn btn-primary" data-act="ctdt-chitiet">Xem chi tiết</button>
        </div>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã CTDT</th>
                    <th>Chu kỳ</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody id="ctdt-list">
                <tr>
                    <td>1</td>
                    <td>2020-2024</td>
                    <td>1</td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
<script src="./views/javascript/ctdtPage.js"></script>
<script src="../node_modules/flyonui/flyonui.js"></script>