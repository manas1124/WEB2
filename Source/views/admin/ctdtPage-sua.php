<a href="" class="back-link btn btn-soft ">Quay lại</a>

<h3 class="modal-title">Chỉnh sửa CTDT</h3>

<div class="overflow-y-auto">
    <!-- thong tin chung -->
    <div class="flex flex-row">
        <div class="modal-body pt-0 mb-4">
            <div class="w-96">
                <label class="label-text" for="ctdt_id">Mã CTDT </label>
                <input type="text" placeholder="" class="input" id="ctdt_id" />
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
                <label class="label-text" for="select-chuky">Chu kỳ</label>
                <select class="select" id="select-chuky">
                    <option value="-1">Chọn chu kì</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="select-loai">Loại</label>
                <select class="select" id="select-loai">
                    <option value="1">Chương trình đào tạo</option>
                    <option value="0">Chuẩn đầu ra</option>
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
        <button id="btn-save" type="submit" class="btn btn-primary">Lưu</button>
    </div>
</div>
<script>
    async function waitForOptionAndSetValue(selectId, value) {
        const maxAttempts = 20;
        let attempts = 0;

        const interval = setInterval(() => {
            if ($(selectId + " option").length > 0) {
                $(selectId).val(value);
                clearInterval(interval);
            } else {
                attempts++;
                if (attempts >= maxAttempts) {
                    console.warn(`Không tìm thấy option cho ${selectId}`);
                    clearInterval(interval);
                }
            }
        }, 200); // kiểm tra mỗi 200ms
    }

    async function getCTDTById(id) {
        try {
            const response = await $.ajax({
                url: "./controller/CTDTController.php",
                type: "GET",
                dataType: "json",
                data: {
                    func: "getById",
                    ctdt_id: id
                },
            });
            return response;
        } catch (error) {
            console.error(error);
            return null;
        }
    }

    async function loadCTDTById(id) {
        const ctdt = await getCTDTById(id);
        $("#ctdt_id").val(ctdt.ctdt_id);
        $("#file-decuong").val(ctdt.file);
        $("#select-loai").val(ctdt.la_ctdt);
        $("#select-status").val(ctdt.status);
        waitForOptionAndSetValue("#select-nganh", ctdt.nganh_id);
        waitForOptionAndSetValue("#select-chuky", ctdt.ck_id);
    }

    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        loadCTDTById(id);
    });
</script>
<script src="./views/javascript/ctdtPage.js"></script>