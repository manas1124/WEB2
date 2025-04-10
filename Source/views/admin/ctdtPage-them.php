<a href="" class="back-link btn btn-soft ">Quay lại</a>

<h3 class="modal-title">Thêm CTDT</h3>

<div class="overflow-y-auto">
    <!-- thong tin chung -->
    <div class="flex flex-row">
        <div class="modal-body pt-0 mb-4">
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
                    <option value="0">Chương trình đào tạo</option>
                    <option value="1">Chuẩn đầu ra</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="select-status">Status</label>
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

<script src="./views/javascript/ctdtPage.js"></script>
