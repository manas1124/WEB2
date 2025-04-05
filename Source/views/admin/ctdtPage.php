<div id="ctdt-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý chương trình đào tạo</h1>
        <div class="flex items-center gap-4">
            <!-- <button type="button" class="action-item btn btn-primary" data-act="ks-tao"
                data-aria-haspopup="dialog" aria-expanded="false"
                aria-controls="create-ks-modal" data-overlay="#create-ks-modal">Tạo bài khảo sát</button> -->
            <button class="action-item btn btn-primary" data-act="ctdt-them">Thêm Ctdt</button>
        </div>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="table">
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
                <tr>
                    <td>1</td>
                    <td>công nghệ thông tin</td>
                    <td>2020-2024</td>
                    <td>ctdt</td>
                    <td>1234</td>
                    <td>1</td>
                    <td>
                        <button class="btn btn-primary" data-act="ctdt-sua">Sửa Ctdt</button>
                        <button class="btn btn-primary" data-act="ctdt-chitiet">Xem chi tiết</button>
                        <button class="btn btn-primary" data-act="ctdt-khoa">Khóa</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
<script src="./views/javascript/ctdtPage.js"></script>
<script src="../node_modules/flyonui/flyonui.js"></script>