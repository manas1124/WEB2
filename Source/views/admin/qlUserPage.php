<div id="ctdt-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý User</h1>

        <div class="flex items-center gap-4">
            <button class="action-item btn btn-primary" data-act="user-them">Thêm</button>
            <label id="download-excel-templat" class="btn btn-outline btn-secondary cursor-pointer">Tải file mẫu</label>
            <input type="file" id="input-file-excel" class="input" accept=".xlsx, .xls" />
            <button type="button" class="btn btn-primary" aria-haspopup="dialog" aria-expanded="false" aria-controls="slide-down-animated-modal" data-overlay="#slide-down-animated-modal">Gửi khảo sát</button>

            <!-- <button class="btn btn-primary" id="btn-import-excel">Nhập Excel</button> -->

        </div>
    </div>
    <div id="slide-down-animated-modal" class="overlay modal overlay-open:opacity-100 overlay-open:duration-300 hidden bg-black/25" role="dialog" tabindex="-1">
        <div class="modal-dialog overlay-open:mt-12 overlay-open:opacity-100 overlay-open:duration-300 transition-all ease-out">
            <form id="form-send-mail" class="modal-content" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h3 class="modal-title">Gửi khảo sát</h3>
                    <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close" data-overlay="#slide-down-animated-modal">
                        <span class="icon-[tabler--x] size-4"></span>
                    </button>
                </div>
                <div class="modal-body flex gap-4 flex-col">
                    <div class="w-full">
                        <label class="label-text" for="nhom-ks-select-modal"> Đối tượng khảo sát </label>
                        <select id="nhom-ks-select-modal" class="select" name="objectSelect">
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="label-text" for="selectHelperText"> Tiêu đề </label>
                        <input type="text" name="subject-text" placeholder="Tiêu đề khảo sát" class="input w-full" />
                    </div>
                    <div class="w-full">
                        <label class="label-text" for="selectHelperText"> Nội dung khảo sát </label>
                        <textarea class="textarea" name="body-text" placeholder="Nội dung..." id="textareaLabel"></textarea>
                    </div>
                    <div class="w-full">
                        <input type="file" name="attachment" class="input w-full" id="file-attachment" accept=".xlsx, .xls, .docx, .doc, .pdf" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-soft btn-secondary" data-overlay="#slide-down-animated-modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Gửi khảo sát</button>
                </div>
            </form>
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
<script src="../node_modules/flyonui/flyonui.js"></script>
<script src="../path/to/lodash/lodash.js"></script>
<script src="../path/to/dropzone/dist/dropzone-min.js"></script>