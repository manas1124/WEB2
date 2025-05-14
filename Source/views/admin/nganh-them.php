<div class="w-full h-full mx-auto container p-5">
    <div class="flex items-center justify-between mb-4">
        <a href="" class="back-link btn btn-soft ">Quay lại</a>
    </div>
    <div class="flex items-center justify-center mb-4">
        <h3 class="modal-title">Thêm ngành</h3>
    </div>
    <div class="flex items-center justify-center mb-4">
        <div class="overflow-y-auto">
            <!-- thong tin chung -->
            <div class="flex flex-row">
                <div class="modal-body pt-0 mb-4">
                    <div class="w-96">
                        <label class="label-text" for="ten-nganh">Tên ngành </label>
                        <input type="text" placeholder="" class="input" id="ten-nganh" />
                    </div>
                    <div class="w-96">
                        <label class="label-text" for="select-status">Trạng thái</label>
                        <select class="select" id="select-status">
                            <option value="1">Đang sử dụng</option>
                            <option value="0">Đã khóa</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-t border-base-content/10">
                <button id="btn-create" type="submit" class="btn btn-primary">Thêm</button>
            </div>
        </div>

    </div>
</div>

<script src="./views/javascript/nganh.js"></script>