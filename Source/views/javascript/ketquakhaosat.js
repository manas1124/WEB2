// const { data } = require("jquery");

window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component

async function getAllKhaoSat(page = 1, ks_ids = null, txt_search = null,
    ngay_bat_dau = null, ngay_ket_thuc = null,
    nks_id = null, nganh = null, chuky = null) {
    try {
        const response = await $.ajax({
            url: "./controller/KhaoSatController.php",
            type: "POST",
            dataType: "json",
            data: {
                func: "getAllKhaoSatFilter",
                page: page,
                ks_ids: JSON.stringify(ks_ids),
                txt_search: txt_search,
                ngay_bat_dau: ngay_bat_dau,
                ngay_ket_thuc: ngay_ket_thuc,
                nks_id: nks_id,
                nganh: nganh,
                chuky: chuky

            }
        });
        // console.log("fect",response)
        return response;
    } catch (e) {
        console.log(e.responseText)
        console.log("loi fetchdata getAllKhaoSat")
        return null;
    }
}

async function getKsIds() {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getIdKhaoSat"
            }
        });
        return response;
    } catch (error) {
        console.log(error);
    }
}

async function loadDsKhaoSat(page = 1, txt_search = null,
    ngay_bat_dau = null, ngay_ket_thuc = null,
    nks_id = null, nganh = null, chuky = null) {
    const ks_ids = await getKsIds();
    console.log(ks_ids);
    if (!ks_ids || ks_ids.length === 0) {
        $("#ks-list").html("<tr><td colspan='7' class='text-center text-gray-500 italic py-4 bg-gray-100 rounded'>Không có kết quả khảo sát nào.</td></tr>");
        $("#pagination").empty();
        return;
    }
    const ksList = await getAllKhaoSat(page, ks_ids, txt_search, ngay_bat_dau, ngay_ket_thuc, nks_id, nganh, chuky);

    if (ksList?.status === false && ksList?.message) {
        Swal.fire({
            title: "Thông báo",
            text: ksList.message,
            icon: "warning"
        });
        return;
    }

    console.log(ksList);
    console.log(ks_ids);

    // ksList = JSON.parse(ksList)
    if (ksList.status) {
        // console.log(ksList)
        $("#ks-list").empty();
        if (ksList.data.data.length == 0) {
            $("#ks-list").html("<tr><td colspan='7' class='text-center text-gray-500 italic py-4 bg-gray-100 rounded'>Không có kết quả khảo sát nào.</td></tr>");
            $("#pagination").empty();
            return;
        }
        if (ksList.data?.data?.length > 0) {
            ksList.data.data.map((item) => {
                $("#ks-list").append(`
                <tr>
                    <td>${item.ten_ks}</td>
                    <td>${item.ngay_bat_dau}</td>
                    <td>${item.ngay_ket_thuc}</td>
                    <td>${item.ten_nks}</td>
                    <td>${item.ten_nganh}</td>
                    <td>${item.ten_ck}</td>
                    <td>
                        <button class="action-item btn btn-circle btn-text btn-sm view-survey hidden" data-act="xem-kqks" data-id="${item.ks_id}" aria-label="xem ket qua">
                            <span class="icon-[tabler--eye] size-5"></span>
                        </button>
                        <button class="btnExcel btn btn-circle btn-text btn-sm view-survey hidden" data-id="${item.ks_id}" aria-label="xuất excel">
                            <span class="icon-[tabler--file-spreadsheet] size-5"></span>
                        </button>
                    </td>
                </tr>
    
            `);
            });
        }
        window.AppState.applyPermissionControl();
        renderPagination(ksList.data.totalPages, ksList.data.currentPage);
    }
}


function renderPagination(totalPages, currentPage) {
    if (totalPages <= 1) {
        $("#pagination").empty();
        return;
    }

    $("#pagination").empty();

    $("#pagination").append(`<button type="button" class="btn btn-text btn-prev"><</button><div class="flex items-center gap-x-1">`);

    for (let i = 1; i <= totalPages; i++) {
        let activeClass = (i == currentPage) ? 'aria-current="page"' : '';
        $("#pagination").append(`
            <button type="button" class="btn btn-text btn-square aria-[current='page']:text-bg-primary btn-page" data-page="${i}" ${activeClass}>${i}</button>
        `);
    }

    $("#pagination").append(`</div><button type="button" class="btn btn-text btn-next">></button>`);
}

async function getAllChuky() {
    try {
        const response = await $.ajax({
            url: "./controller/chuKyController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAll",
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function getAllNganh() {
    try {
        const response = await $.ajax({
            url: "./controller/nganhController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAll",
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function getAllNhomKhaoSat() {
    try {
        const response = await $.ajax({
            url: "./controller/nhomKsController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllNhomKs",
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadAllNhomKhaoSat() {
    const response = await getAllNhomKhaoSat();
    $("#select-nhom").empty();
    $("#select-nhom").append(`<option value="-1">Tất cả</option>`);
    if (response) {
        response.forEach(item => {
            $("#select-nhom").append(`<option value="${item.nks_id}">${item.ten_nks}</option>`);
        });
    }
}

async function loadAllNganh() {
    const response = await getAllNganh();
    $("#select-nganh").empty();
    $("#select-nganh").append(`<option value="-1">Tất cả</option>`);
    if (response) {
        response.forEach(item => {
            $("#select-nganh").append(`<option value="${item.nganh_id}">${item.ten_nganh}</option>`);
        });
    }
}

async function loadAllChuky() {
    const response = await getAllChuky();
    console.log(response);
    $("#select-chuky").empty();
    $("#select-chuky").append(`<option value="-1">Tất cả</option>`);
    if (response) {
        response.forEach(item => {
            $("#select-chuky").append(`<option value="${item.ck_id}">${item.ten_ck}</option>`);
        });
    }

}

function xuatExel(ks_id) {
    Swal.fire({
        title: 'Đang xử lý...',
        text: 'Vui lòng chờ trong giây lát',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    $.ajax({
        url: './controller/ketQuaKhaoSatController.php',
        type: 'GET',
        data: {
            func: "xuatExel",
            ks_id: ks_id
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response) {
            Swal.close();
            if (response?.status === false && response?.message) {
                Swal.fire({
                    title: "Thông báo",
                    text: response.message,
                    icon: "warning"
                });
            } else {
                var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                var link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `survey_export_${ks_id}.xlsx`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        },
        error: function (xhr, status, error) {
            console.error("Đã xảy ra lỗi khi xuất Excel:", error);
        }
    });
}

async function loadNhomKsToSelectModal() {
    const nhomKsList = await getAllNhomKhaoSat();
    const selectElement = $("#nhom-ks-select-modal");

    selectElement.empty();
    selectElement.append('<option value="">Tất cả</option>');
    if (nhomKsList != null) {
        nhomKsList.map((item) => {
            selectElement.append(`
          <option value="${item.nks_id}">${item.ten_nks}</option>
        `);
        });
    } else {
        selectElement.append('<option value="">Không có nhóm khảo sát</option>');
    }
}


$(function () {
    loadDsKhaoSat();
    loadAllChuky();
    loadAllNganh();
    loadAllNhomKhaoSat();
    loadNhomKsToSelectModal();

    $(".main-content").on("click", ".action-item", function (e) {
        e.preventDefault();
        let action = $(this).data("act");
        console.log(action)
    });

    $(document).on('click', '.btnExcel', function () {
        let ks_id = $(this).data("id");
        xuatExel(ks_id);
    });

    // Hàm lấy dữ liệu bộ lọc từ các trường
    function getFilterData() {
        const nhom = $("#select-nhom").val();
        const nganh = $("#select-nganh").val();
        const chuky = $("#select-chuky").val();

        return {
            txt_search: $("#search-keyword").val().trim(),
            ngay_bat_dau: $("#from-date").val(),
            ngay_ket_thuc: $("#to-date").val(),
            nks_id: nhom !== "-1" ? nhom : null,
            nganh: nganh !== "-1" ? nganh : null,
            chuky: chuky !== "-1" ? chuky : null,
        };
    }

    // Nút Tìm kiếm
    $("#search-keyword").on("input", function () {
        const filters = getFilterData();
        console.log("Tìm kiếm với:", filters);
        loadDsKhaoSat(1, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc, filters.nks_id, filters.nganh, filters.chuky);
    });

    // Nút Lọc
    $("#btn-filter").on("click", function () {
        const filters = getFilterData();
        console.log("Lọc với:", filters);
        loadDsKhaoSat(1, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc, filters.nks_id, filters.nganh, filters.chuky);
    });

    // Nút Reset
    $("#btn-reset").on("click", function () {
        $("#from-date").val('');
        $("#to-date").val('');
        $("#select-nhom").val('-1');
        $("#select-nganh").val('-1');
        $("#select-chuky").val('-1');
        const txt_search = $("#search-keyword").val().trim();
        console.log("Reset lọc");
        loadDsKhaoSat(1, txt_search, null, null, null, null, null);
    });

    $("#pagination").on("click", ".btn-page", function () {
        const currentPage = Number($("#pagination .btn-page[aria-current='page']").data("page"));
        const selectedPage = Number($(this).data("page"));
        if (currentPage == selectedPage) {
            return;
        }
        const filters = getFilterData();
        loadDsKhaoSat(selectedPage, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc, filters.nks_id, filters.nganh, filters.chuky);
    });

    $("#pagination").on("click", ".btn-prev", function () {
        let currentPage = Number($("#pagination .btn-page[aria-current='page']").data("page"));
        if (currentPage == 1) {
            return;
        }
        const filters = getFilterData();
        currentPage -= 1;
        loadDsKhaoSat(currentPage, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc, filters.nks_id, filters.nganh, filters.chuky);
    });

    $("#pagination").on("click", ".btn-next", function () {
        let currentPage = Number($("#pagination .btn-page[aria-current='page']").data("page"));
        if (currentPage == $("#pagination .btn-page").length) {
            return;
        }
        const filters = getFilterData();
        currentPage += 1;
        loadDsKhaoSat(currentPage, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc, filters.nks_id, filters.nganh, filters.chuky);
    });

    $("#form-send-mail").on("submit", function (e) {
        e.preventDefault(); 
        const objectSelect = $("#nhom-ks-select-modal").val();
        const subject = $("input[name='subject-text']").val();
        const body = $("textarea[name='body-text']").val();
        const file = $("#file-attachment")[0].files[0]; 
        console.log(objectSelect, subject, body, file);
        
        const formData = new FormData();
        formData.append("objectSelect", objectSelect);
        formData.append("subject", subject);
        formData.append("body", body);
        formData.append("attachment", file);
        formData.append("func", "sendMail");

        console.log(formData);

        $.ajax({
            url: "./controller/UserController.php",
            method: "POST",
            dataType: "json",
            data: formData,
            processData: false, 
            contentType: false, 

            success: function (response) {
                const data = JSON.parse(response);
                if (data.status === "success") {
                    Swal.fire({
                        title: 'Thành công',
                        text: "Bạn đã gửi khảo sát thành công.",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Đồng ý',
                       
                    });
                    $("#slide-down-animated-modal").addClass("hidden");
                }
            },
            error: function (err) {
                Swal.fire({
                        title: 'Thất bại',
                        text: "Bạn đã gửi khảo sát không thành công.",
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Thử lại'
                    });
            }
        });
    });
});
