<a href="" class="back-link btn btn-soft ">Quay lại</a>

<h3 class="modal-title">Thêm ngành</h3>

<div class="overflow-y-auto">
    <!-- thong tin chung -->
    <div class="flex flex-row">
        <div class="modal-body pt-0 mb-4">
            <div class="w-96">
                <label class="label-text" for="ten-nganh">Tên ngành </label>
                <input type="text" placeholder="" class="input" id="ten-nganh" />
            </div>
            <div class="w-96">
                <label class="label-text" for="select-status">Status</label>
                <select class="select" id="select-status">
                    <option value="1">Hoạt động</option>
                    <option value="0">Không hoạt động</option>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer border-t border-base-content/10">
        <button id="btn-save-nganh" type="submit" class="btn btn-primary">Thêm</button>
    </div>
</div>
<script src="views/javascript/qlKhaoSatPage-tao.js"></script>