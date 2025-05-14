<div class="flex w-full justify-center">
<div id="ctdt-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý User</h1>

        <div class="flex items-center gap-4">
            <button class="action-item btn btn-primary create-target hidden" data-act="user-them">Thêm</button>
            <label id="download-excel-templat" class="btn btn-outline btn-secondary cursor-pointer">Tải file mẫu</label>
            <input type="file" id="input-file-excel" class="input" accept=".xlsx, .xls" />
            <button type="button" class="btn btn-primary" aria-haspopup="dialog" aria-expanded="false"
                aria-controls="slide-down-animated-modal" data-overlay="#slide-down-animated-modal">Gửi khảo
                sát</button>

            <!-- <button class="btn btn-primary" id="btn-import-excel">Nhập Excel</button> -->

        </div>
    </div>
    <div id="slide-down-animated-modal"
        class="overlay modal overlay-open:opacity-100 overlay-open:duration-300 hidden bg-black/25" role="dialog"
        tabindex="-1">
        <div
            class="modal-dialog overlay-open:mt-12 overlay-open:opacity-100 overlay-open:duration-300 transition-all ease-out">
            <form id="form-send-mail" class="modal-content" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h3 class="modal-title">Gửi khảo sát</h3>
                    <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close"
                        data-overlay="#slide-down-animated-modal">
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
                        <textarea class="textarea" name="body-text" placeholder="Nội dung..."
                            id="textareaLabel"></textarea>
                    </div>
                    <div class="w-full">
                        <input type="file" name="attachment" class="input w-full" id="file-attachment"
                            accept=".xlsx, .xls, .docx, .doc, .pdf" />
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
    <div class="my-6 flex flex-row align-items-center gap-4">
        <div class=" flex flex-col">
            <label for="search" class="label-text">Tìm kiếm:</label>
            <input type="text" id="search" name="search" placeholder="Nhập từ khóa tìm kiếm..."
                class="input w-64">
        </div>
        <div class="w-50 flex flex-col">
            <label for="nhom-ks-select" class="label-text">Nhóm khảo sát:</label>
            <select id="nhom-ks-select"
                class="input ">
                <option value="-1">Tất cả</option>
            </select>
        </div>
        <div class="w-50 flex flex-col">
            <label class="label-text" for="select-nganh">Ngành</label>
            <select
                class="input "
                id="select-nganh">
                <option value="-1">Tất cả</option>
            </select>
        </div>
        <div class="w-50 flex flex-col ">
            <label class="label-text" for="select-chu-ki">Chu kỳ</label>
            <select
                class="input "
                id="select-chu-ki">
                <option value="-1">Chọn chu kì</option>
            </select>
        </div>
        <div class="ml-4 relative">
            <button id="btn-search" class="btn btn-primary absolute bottom-1 left-0">Lọc</button>
        </div>
        <div class="ml-15 relative">
            <button id="btn-reset" class="btn btn-soft btn-warning absolute bottom-1 left-0">Hủy</button>
        </div>
    </div>

    <div class="w-full overflow-x-auto h-[400px]">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="w-1/5 text-center">Họ và tên</th>
                    <th class="w-1/5 text-center">Email</th>
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
    <div id="pagination" class="flex justify-center space-x-3 mt-3"></div>
</div>
</div>
<script src="views/javascript/qlUserPage.js"></script>
<script src="../node_modules/flyonui/flyonui.js"></script>
<script src="../path/to/lodash/lodash.js"></script>
<script src="../path/to/dropzone/dist/dropzone-min.js"></script>