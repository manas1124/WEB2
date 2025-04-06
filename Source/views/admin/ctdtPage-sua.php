<a href="" class="back-link btn btn-soft ">Quay lại</a>

<h3 class="modal-title">Chỉnh sửa CTDT</h3>

<div class="overflow-y-auto">
    <!-- thong tin chung -->
    <div class="flex flex-row">
        <div class="modal-body pt-0 mb-4">
            <div class="w-96">
                <label class="label-text" for="id-ctdt">Mã CTDT </label>
                <input type="text" placeholder="" class="input" id="id-ctdt" />
            </div>
            <div class="w-96">
                <label class="label-text" for="file-decuong">File đề cương chi tiết </label>
                <input type="text" placeholder="" class="input" id="file-decuong" />
            </div>
            <div class="w-96">
                <label class="label-text" for="select-nganh">Ngành </label>
                <select class="select" id="select-nganh">
                    <option value="-1">Chọn ngành</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="select-chu-ky">Chu kỳ</label>
                <select class="select" id="select-chu-ky">
                    <option value="-1">Chọn chu kì</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="select-loai">Loại</label>
                <select class="select" id="select-loai">
                    <option value="1">CTDT</option>
                    <option value="2">CDR</option>
                </select>
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
        <button id="btn-save-ctdt" type="submit" class="btn btn-primary">Thêm</button>
    </div>
</div>
<script src="./views/javascript/ctdtPage.js"></script>
