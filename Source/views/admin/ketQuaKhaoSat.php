<div id="kqks-content" class="container w-full h-full p-5">
    <div class="flex items-center justify-between mb-4">
        <h1>Kết quả khảo sát</h1>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div class="w-96 relative">
                <label class="label-text mb-1" for="search-keyword">Tìm kiếm</label>
                <input type="text" placeholder="Nhập nội dung tìm kiếm" class="input ps-8" id="search-keyword" name="keyword" aria-expanded="false" />
                <span class="icon-[tabler--search] text-base-content absolute left-3 top-1/2 transform translate-y-1/3 -translate-x-1/4 text-xl"></span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button type="button" class="btn btn-primary" aria-haspopup="dialog"
                aria-expanded="false" aria-controls="slide-down-animated-modal"
                data-overlay="#slide-down-animated-modal">Gửi kết quả</button>
        </div>
    </div>
    <div class="flex flex-wrap items-end gap-4 mb-4">
        <div class="flex flex-col">
            <label class="label-text mb-1" for="from-date">Từ ngày</label>
            <input type="date" class="input input-bordered h-10 min-w-[140px]" id="from-date" />
        </div>

        <div class="flex flex-col">
            <label class="label-text mb-1" for="to-date">Đến ngày</label>
            <input type="date" class="input input-bordered h-10 min-w-[140px]" id="to-date" />
        </div>

        <div class="flex flex-col">
            <label class="label-text mb-1" for="select-nhom">Nhóm khảo sát</label>
            <select class="select select-bordered h-10 min-w-[160px]" id="select-nhom">
                <option value="-1">Chọn nhóm khảo sát</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="label-text mb-1" for="select-nganh">Ngành</label>
            <select class="select select-bordered h-10 min-w-[140px]" id="select-nganh">
                <option value="-1">Chọn ngành</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="label-text mb-1" for="select-chuky">Chu kỳ</label>
            <select class="select select-bordered h-10 min-w-[140px]" id="select-chuky">
                <option value="-1">Chọn chu kỳ</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="label-text mb-1 invisible">Lọc</label>
            <button type="button" class="btn btn-primary h-10" id="btn-filter">Lọc</button>
        </div>

        <div class="flex flex-col">
            <label class="label-text mb-1 invisible">Reset</label>
            <button type="button" class="btn btn-primary h-10" id="btn-reset">Đặt lại</button>
        </div>
    </div>
    <div class="w-full overflow-x-auto h-[500]">
        <table class="table-striped table">
            <thead>
                <tr>
                    <th>Tên khảo sát</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngay kết thúc</th>
                    <th>Nhóm khảo sát</th>
                    <th>Ngành</th>
                    <th>Chu kỳ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="ks-list">

            </tbody>
        </table>
    </div>
    <div id="pagination" class="flex justify-center space-x-2"></div>
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
                        <label class="label-text" for="nhom-ks-select-modal"> Nhóm nhận </label>
                        <select id="nhom-ks-select-modal" class="select" name="objectSelect">
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="label-text" for="selectHelperText"> Tiêu đề </label>
                        <input type="text" name="subject-text" placeholder="-Tiêu đề-" class="input w-full" />
                    </div>
                    <div class="w-full">
                        <label class="label-text" for="selectHelperText"> Nội dung </label>
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
                    <button type="submit" class="btn btn-primary">Gửi kết quả</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="./views/javascript/ketquakhaosat.js"></script>