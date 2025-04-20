<a href="" class="back-link btn btn-soft ">Quay lại</a>

<h3 class="modal-title">Chỉnh sửa ngành</h3>

<div class="overflow-y-auto">
    <!-- thong tin chung -->
    <div class="flex flex-row">
        <div class="modal-body pt-0 mb-4">
            <div class="w-96">
                <label class="label-text" for="nganh_id">Mã ngành </label>
                <input type="text" placeholder="" class="input" id="nganh_id" />
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

<script>
    async function getNganhById(id) {
        try {
            const response = await $.ajax({
                url: "./controller/nganhController.php",
                type: "GET",
                dataType: "json",
                data: {
                    func: "getById",
                    nganh_id: id
                },
            });
            return response;
        } catch (error) {
            console.error(error);
            return null;
        }
    }

    async function loadNganhById(id) {
        const nganh = await getNganhById(id);
        $("#nganh_id").val(nganh.nganh_id);
        $("#ten-nganh").val(nganh.ten_nganh);
        $("#select-status").val(nganh.status);
    }

    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        loadNganhById(id);
    });
</script>
<script src="./views/javascript/nganh.js"></script>