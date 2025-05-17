<div class="flex items-center justify-between mb-4">
    <a href="" class="back-link btn btn-soft ">Quay lại</a>
</div>
<div class="flex w-full justify-center">
    <div class="flex flex-col ">
        <div class="w-full flex justify-center">
            <h3 class="modal-title" id="ltl_id"></h3>
        </div>
        <div class="overflow-y-auto">
            <!-- thong tin chung -->
            <div class="flex flex-col gap-4 min-w-[400px]">
                <div class="w-full pt-0 mb-4 mt-4 flex justify-center">
                    <div>
                        <label class="label-text" for="select-status">Trạng thái</label>
                        <select class="select w-[400px]" id="select-status" disabled>
                            <option value="1">Đang sử dụng</option>
                            <option value="0">Đã xóa</option>
                        </select>
                    </div>
                </div>
                <div class="w-full pt-0 mb-4 flex justify-center">
                    <div class="mb-2 w-[400px]">
                        <label class="label-text" for="mo-ta"> Mô trả loại trả lời </label>
                        <input type="text" placeholder="Mô tả" class="input" id="mo-ta" disabled />
                    </div>
                </div>
                <div class="w-full pt-0 mb-4">
                    <div class="flex flex-col">
                        <strong class="mb-4">
                            Nội dung loại trả lời
                        </strong>
                    </div>

                    <div id="ltl-container" class="flex flex-row gap-4 flex-wrap wrap justify-around">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    async function getLoaiTraLoiById(ltl_id) {
        if (!ltl_id || isNaN(ltl_id)) {
            console.warn("ID không hợp lệ");
            return null;
        }

        try {
            const response = await $.ajax({
                url: "./controller/loaiTraLoiController.php",
                type: "GET",
                dataType: "json",
                cache: false,
                data: {
                    func: "getLoaiTraLoiById",
                    ltl_id: ltl_id
                },
            });
            return response;
        } catch (error) {
            console.error("Lỗi khi gọi API:", error);
            return null;
        }
    }

    async function loadSections(ltl_id) {
        console.log(ltl_id);
        const response = await getLoaiTraLoiById(ltl_id);
        if (!response.status) {
            return;
        }

        const ltlContainer = document.getElementById("ltl-container");
        ltlContainer.innerHTML = '';

        const id = response.data.ltl_id;
        const thang_diem = response.data.thang_diem;
        const mota = response.data.mota ? response.data.mota : '';
        const status = response.data.status;
        const data = response.data.chitiet_mota ? response.data.chitiet_mota.split(",").map(item => item.trim()) : null;

        document.getElementById("ltl_id").textContent = "Chi tiết loại trả lời: Mã loại trả lời - " + id;
        document.getElementById("select-status").value = status;
        document.getElementById("mo-ta").value = mota;

        if (data) {
            data.forEach((item, index) => {
                const section = document.createElement("div");
                section.className = `p-4 section min-w-[125px] min-h-[125px] rounded-full item-center`;
                section.innerHTML = `
                    <div>
                        <h3 class='mt-3 text-center'>${index + 1}</h3>
                    </div>
                    <div>
                        <p class='mt-3 text-center'>${item}</p>
                    </div>
                `;
                ltlContainer.appendChild(section);
            });
        }
        
    }

    $(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const ltl_id = urlParams.get("id");
        loadSections(ltl_id);
    });
</script>