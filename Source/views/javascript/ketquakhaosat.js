// const { data } = require("jquery");

window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component

async function getAllKhaoSat(page = 1, ks_ids = null, txt_search = null,
    ngay_bat_dau = null, ngay_ket_thuc = null,
    nks_id = null, nganh = null, chuky = null) {
    try {
        const response = await $.ajax({
            url: "./controller/KhaoSatController.php",
            type: "POST",
            data: {
                func: "getAllKhaoSatFilter",
                page: page,
                ks_ids: ks_ids,
                txt_search: txt_search,
                ngay_bat_dau: ngay_bat_dau,
                ngay_ket_thuc: ngay_ket_thuc,
                nks_id: nks_id,
                nganh: nganh,
                chuky: chuky

            },
            dataType: "json",
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
            datatype: "json",
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
                    <button class="action-item btn btn-circle btn-text btn-sm" data-act="xem-kqks" data-id="${item.ks_id}" aria-label="xem ket qua"><span class="icon-[tabler--eye] size-5"></span></button>
                    <button class="btn btn-primary btnExcel" data-id="${item.ks_id}>Xuất Excel</button>
                </td>
            </tr>
  
        `);
        });

        renderPagination(ksList.data.totalPages, ksList.data.currentPage);
    }
}


function renderPagination(totalPages, currentPage) {
    if (totalPages <= 1) {
        $("#pagination").empty();
        return;
    }

    $("#pagination").empty();

    $("#pagination").append(`<button type="button" class="btn btn-text btn-prev"><<</button><div class="flex items-center gap-x-1">`);

    for (let i = 1; i <= totalPages; i++) {
        let activeClass = (i == currentPage) ? 'aria-current="page"' : '';
        $("#pagination").append(`
            <button type="button" class="btn btn-text btn-square aria-[current='page']:text-bg-primary btn-page" data-page="${i}" ${activeClass}>${i}</button>
        `);
    }

    $("#pagination").append(`</div><button type="button" class="btn btn-text btn-next">>></button>`);
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
    $("#select-nhom").append(`<option value="-1">Chọn nhóm khảo sát</option>`);
    if (response) {
        response.forEach(item => {
            $("#select-nhom").append(`<option value="${item.nks_id}">${item.ten_nks}</option>`);
        });
    }
}

async function loadAllNganh() {
    const response = await getAllNganh();
    $("#select-nganh").empty();
    $("#select-nganh").append(`<option value="-1">Chọn ngành</option>`);
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
    $("#select-chuky").append(`<option value="-1">Chọn chu kỳ</option>`);
    if (response) {
        response.forEach(item => {
            $("#select-chuky").append(`<option value="${item.ck_id}">${item.ten_ck}</option>`);
        });
    }

}

function xuatExel(ks_id) {
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
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `survey_export_${ks_id}.xlsx`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        error: function (xhr, status, error) {
            console.error("Đã xảy ra lỗi khi xuất Excel:", error);
        }
    });
}


$(document).ready(function () {
    loadDsKhaoSat();
    loadAllChuky();
    loadAllNganh();
    loadAllNhomKhaoSat();
    $(".main-content").on("click", ".action-item", function (e) {
        e.preventDefault();
        let action = $(this).data("act");
        console.log(action)
    });

    $('.btnExcel').on('click', function () {
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
            page: 1, 
        };
    }

    // Nút Tìm kiếm
    $("#search-keyword").on("input", function () {
        const filters = getFilterData();
        console.log("Tìm kiếm với:", filters);
        loadDsKhaoSat(filters.page, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc, filters.nks_id, filters.nganh, filters.chuky);  // Gọi hàm loadDsKhaoSat với bộ lọc
    });

    // Nút Lọc
    $("#btn-filter").on("click", function () {
        const filters = getFilterData();
        console.log("Lọc với:", filters);
        loadDsKhaoSat(filters.page, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc, filters.nks_id, filters.nganh, filters.chuky);  // Gọi hàm loadDsKhaoSat với bộ lọc
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
});

