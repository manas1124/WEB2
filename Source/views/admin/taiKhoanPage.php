<div class="flex w-full justify-center">
    <div id="qltk-content" class="container h-full">
        <div class="flex items-center justify-between mb-4">
            <h1>Quản lí tài khoản</h1>
            <div class="flex items-center gap-4">
                <button type="button" class="action-item btn btn-primary create-account hidden" data-act="tk-them">Thêm
                    tài khoản</button>
            </div>
        </div>
        <div class="w-full overflow-x-auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tài khoản ID</th>
                        <th>Username</th>
                        <th>Quyền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="account-list">
                </tbody>
            </table>
            <div id="pagination" class="flex justify-center space-x-2"></div>
        </div>
    </div>
</div>
<script>
window.HSStaticMethods.autoInit()
</script>
<script src="views/javascript/taiKhoanPage.js"></script>