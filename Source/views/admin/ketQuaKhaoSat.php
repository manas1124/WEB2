<div id="kqks-content" class="container h-full p-5">
    <div class="flex items-center justify-between mb-4">
        <h1>Kết quả khảo sát</h1>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div class="w-96 relative">
                <input type="text" placeholder="Nhập nội dung tìm kiếm" class="input ps-8" id="search-keyword" name="keyword" aria-expanded="false" />
                <span class="icon-[tabler--search] text-base-content absolute start-3 top-1/2 size-4 shrink-0 -translate-y-1/2"></span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button type="button" class="btn btn-primary" aria-haspopup="dialog"
                aria-expanded="false" aria-controls="slide-down-animated-modal"
                data-overlay="#slide-down-animated-modal">Gửi kết quả</button>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <label class="label-text" for="from-date">Từ ngày</label>
                <input type="date" class="input" name="from_date" id="from-date" />
            </div>
            <div>
                <label class="label-text" for="to-date">Đến ngày</label>
                <input type="date" class="input" name="to_date" id="to-date" />
            </div>
            <div>
                <select class="select" id="select-nhom" name="nhom_khao_sat">
                    <option value="-1">Chọn nhóm khảo sát</option>
                </select>
            </div>
            <div>
                <select class="select" id="select-nganh" name="nganh">
                    <option value="-1">Chọn ngành</option>
                </select>
            </div>
            <div>
                <label class="label-text" for="from-date"></label>
                <select class="select" id="select-chuky" name="chuky">
                    <option value="-1">Chọn chu kỳ</option>
                </select>
            </div>
            <div>
                <button type="button" class="btn btn-primary" id="btn-filter" name="loc" data-act="kqks-loc">Lọc</button>
                <button type="button" class="btn btn-primary" id="btn-reset" data-act="reset">Reset</button>
            </div>
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
                    <th>Action</th>
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