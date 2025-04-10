<div id="qltk-content" class="container h-full">
  <div class="flex items-center justify-between mb-4">
    <h1>Quản lí tài khoản</h1>
    <button type="button" class="action-item btn btn-primary" data-act="taikhoanPage-them">Thêm tài khoản</button>
  </div>
</div>
<div class="w-full overflow-x-auto">
  <table class="table">
    <thead>
      <tr>
        <th>Tài khoản ID</th>
        <th>Username</th>
        <th>Đối tượng</th>
        <th>Quyền</th>
        <th>Trạng thái</th>
      </tr>
    </thead>
    <tbody id= "account-list">

    </tbody>
  </table>
  <div id="pagination" class="flex justify-center space-x-2">
  </div>
</div>
<div class="dropdown relative inline-flex">
</div>
<script>
  window.HSStaticMethods.autoInit()
</script>
<script src="views/javascript/taiKhoanPage.js"></script>