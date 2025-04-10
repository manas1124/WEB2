<a href="" class="back-link btn btn-soft ">Quay lại</a>

<h3 class="modal-title">Chỉnh sửa ngành</h3>

<div class="overflow-y-auto">
    <!-- thong tin chung -->
    <div class="flex flex-row">
        <div class="modal-body pt-0 mb-4">
        <div class="w-96">
                <label class="label-text" for="ten-nganh">Mã ngành </label>
                <input type="text" placeholder="" class="input" id="ten-nganh" />
            </div>
            <div class="w-96">
                <label class="label-text" for="ten-nganh">Tên ngành </label>
                <input type="text" placeholder="" class="input" id="ten-nganh" />
            </div>
            <div class="w-96">
                <label class="label-text" for="select-status">Status</label>
                <select class="select" id="select-status">
                    <option value="1">Đang sử dụng</option>
                    <option value="0">Đã xóa</option>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer border-t border-base-content/10">
        <button id="btn-save" type="submit" class="btn btn-primary">Lưu</button>
    </div>
</div>
<script src="./views/javascript/nganh.js"></script>
