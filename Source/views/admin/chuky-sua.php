<div class="w-full h-full mx-auto container p-5">
    <div class="flex items-center justify-between mb-4">
        <a href="" class="back-link btn btn-soft ">Quay lại</a>
    </div>
    <div class="flex items-center justify-center mb-4">
        <h3 class="modal-title">Chỉnh sửa chu kỳ</h>
    </div>
    <div class="flex items-center justify-center mb-4">

        <div class="overflow-y-auto">
            <!-- thong tin chung -->
            <div class="flex flex-row">
                <div class="modal-body pt-0 mb-4">
                    <div class="w-96">
                        <label class="label-text" for="ck_id">Mã ngành </label>
                        <input type="text" placeholder="" class="input" id="ck_id" disabled/>
                    </div>
                    <div class="w-96">
                        <label class="label-text" for="ten-ck">Tên chu kỳ </label>
                        <input type="text" placeholder="" class="input" id="ten-ck" />
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
                <button id="btn-save" type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function getchuKyById(id) {
        try {
            const response = await $.ajax({
                url: "./controller/chuKyController.php",
                type: "GET",
                dataType: "json",
                data: {
                    func: "getById",
                    ck_id: id
                },
            });
            return response;
        } catch (error) {
            console.error(error);
            return null;
        }
    }

    async function loadchuKyById(id) {
        const chuKy = await getchuKyById(id);
        $("#ck_id").val(chuKy.ck_id);
        $("#ten-ck").val(chuKy.ten_ck);
        $("#select-status").val(chuKy.status);
    }

    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        loadchuKyById(id);
    });
</script>
<script src="./views/javascript/chuky.js"></script>