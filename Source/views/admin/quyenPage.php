<div class="flex w-full justify-center">
    <div id="qltk-content" class="container h-full">
        <div class="flex items-center justify-between mb-4">
            <h1>Quản lí quyền</h1>
            <div class="flex items-center gap-4">
                <button type="button" class="action-item btn btn-primary create-permission hidden"
                    data-act="quyen-them">Thêm quyền</button>
            </div>
        </div>
        <div class="w-full overflow-x-auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Quyền ID</th>
                        <th>Tên Quyền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="quyen-list">
                </tbody>
            </table>
            <div id="pagination" class="flex justify-center space-x-2"></div>
        </div>
    </div>
</div>
<script>
window.HSStaticMethods.autoInit()
</script>
<script src="views/javascript/quyenPage.js"></script>