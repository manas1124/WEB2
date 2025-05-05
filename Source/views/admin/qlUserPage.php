<div id="ctdt-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý User</h1>
       
        <div class="flex items-center gap-4">
            <button class="action-item btn btn-primary" data-act="user-them">Thêm</button>
            <label id="download-excel-templat" class="btn btn-outline btn-secondary cursor-pointer">Tải file mẫu</label>
            <input type="file" id="input-file-excel" class="input" accept=".xlsx, .xls" />
            <!-- <button class="btn btn-primary" id="btn-import-excel">Nhập Excel</button> -->
            
        </div>
    </div>
    <div class="my-4">
    <label for="search" class="font-bold mr-2">Tìm kiếm:</label>
    <input type="text" id="search" name="search" placeholder="Nhập từ khóa tìm kiếm..." class="p-2 w-64 border-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
    <label for="nhom-ks-select" class="font-bold ml-4 mr-2">Nhóm khảo sát:</label>
<select id="nhom-ks-select" class="p-2 border-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
    <option value="">Tất cả</option>
</select>
    </div>

    <div class="w-full overflow-x-auto ">
        <table class="table">
            <thead>
                <tr>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Điện thoại</th>
                    <th>Loại đối tượng</th>
                    <th>Nhóm khảo sát</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="user-list">
                

            </tbody>
        </table>
    </div>   
   
</div>
 <script src="views/javascript/qlUserPage.js"></script>