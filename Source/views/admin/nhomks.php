<div id="nganh-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý nhóm khảo sát</h1>
        <div class="flex items-center gap-4">
          
            <button type="button" class="action-item btn btn-primary" data-act="nhomks-them">Thêm nhóm khảo sát</button>
        </div>
    </div>
   
    <div class="w-full overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Tên Nhóm Khảo sát</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="nhomks-list">
            </tbody>
        </table>
        <div id="pagination" class="flex justify-center space-x-2"></div>
    </div>
</div>
<script src="./views/javascript/nhomks.js"></script>
