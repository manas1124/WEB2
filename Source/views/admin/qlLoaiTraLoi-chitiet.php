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

                    <div id="ltl-container" class="flex flex-row gap-4 flex-wrap wrap">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function interpolateColor(color1, color2, factor) {
        const result = color1.slice();
        for (let i = 0; i < 3; i++) {
            result[i] = Math.round(result[i] + factor * (color2[i] - color1[i]));
        }
        return result;
    }

    function rgbToHex(rgb) {
        return "#" + rgb.map(x => x.toString(16).padStart(2, '0')).join('');
    }

    function generateGradientColors(n) {
        const red = [255, 0, 0];
        const yellow = [255, 255, 0];
        const green = [0, 255, 0];
        const colors = [];

        if (n === 2) {
            colors.push(rgbToHex(red), rgbToHex(green));
        } else {
            const half = Math.floor(n / 2);
            for (let i = 0; i < half; i++) {
                const factor = i / (half - 1 || 1); // Tránh chia 0
                const color = interpolateColor(red, yellow, factor);
                colors.push(rgbToHex(color));
            }
            for (let i = half; i < n; i++) {
                const factor = (i - half) / (n - half - 1 || 1);
                const color = interpolateColor(yellow, green, factor);
                colors.push(rgbToHex(color));
            }
        }

        return colors;
    }
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

        const colors = generateGradientColors(thang_diem);
        console.log(colors);

        document.getElementById("ltl_id").textContent = "Chi tiết loại trả lời: Mã loại trả lời - " + id;
        document.getElementById("select-status").value = status;
        document.getElementById("mo-ta").value = mota;

        if (data) {
            data.forEach((item, index) => {
                const section = document.createElement("div");
                const color = colors[index];
                console.log(color);
                section.className = `mb-4 border-5 p-4 section min-w-[125px] min-h-[125px] rounded-full item-center`;
                section.style.border = `solid ${color}`;
                section.innerHTML = `
                    <div>
                        <h3 class='my-2 text-center'>Lựa chọn ${index + 1}:</h3>
                    </div>
                    <div>
                        <p class='my-4 text-center'>${item}</p>
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