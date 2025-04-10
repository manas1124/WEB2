async function getAllctdt(page = 1, nganh_id = null, ck_id = null, la_ctdt = null, status = null) {
    try {
        const response = await $.ajax({
            url: "./controller/CTDTController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllpaging",
                page: page,
                nganh_id: nganh_id,
                ck_id: ck_id,
                la_ctdt: la_ctdt,
                status: status
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
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


async function loadAllctdt(page = 1, nganh_id = null, ck_id = null, la_ctdt = null, status = null) {
    const res = await getAllctdt(page, nganh_id, ck_id, la_ctdt, status);
    if (res) {
        console.log(res);
        const ctdtList = res.data;
        const totalPages = res.totalPages;
        const currentPage = res.currentPage;
        $("#ctdt-list").empty();
        $("#pagination").empty();
        ctdtList.forEach(item => {
            $("#ctdt-list").append(`
              <tr>
                    <td>${item.ctdt_id}</td>
                    <td>${item.ten_nganh}</td>
                    <td>${item.ten_ck}</td>
                    <td>${item.la_ctdt == 0 ? "Chương trình đào tạo" : "Chuẩn đầu ra"}</td>
                    <td>${item.file}</td>
                    <td>${item.status == 1
                    ? '<span class="badge badge-soft badge-success ">Đang sử dụng</span>'
                    : '<span class="badge badge-soft badge-error ">Đã khóa</span>'
                }</td>
                    <td>
                        <button class="action-sua btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--pencil] size-5"></span></button>
                        <button class="action-status btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--trash] size-5"></span></button>
                    </td>
                </tr>
            `);
        });
        $("#pagination").append(`<button type="button" class="btn btn-text btn-prev">Previous</button><div class="flex items-center gap-x-1">`);
        for (let i = 1; i <= totalPages; i++) {
            let activeClass = (i == currentPage) ? 'aria-current="page"' : '';
            $("#pagination").append(`
                <button type="button" class="btn btn-text btn-square aria-[current='page']:text-bg-primary btn-page" data-page="${i}" ${activeClass}>${i}</button>
            `);
        }
        $("#pagination").append(`</div><button type="button" class="btn btn-text btn-next">Next</button>`);
    }
}

async function loadAllNganh() {
    const response = await getAllNganh();
    $("#select-nganh").empty();
    if (response) {
        response.forEach(item => {
            $("#select-nganh").append(`<option value="${item.nganh_id}">${item.ten_nganh}</option>`);
        });
    }
}

async function loadAllChuky() {
    const response = await getAllChuky();
    $("#select-chuky").empty();
    if (response) {
        response.forEach(item => {
            $("#select-chuky").append(`<option value="${item.ck_id}">${item.ten_ck}</option>`);
        });
    }

}

function create() {
    $.ajax({
        type: "GET",
        url: "./controller/chuKyController.php",
        // url: "./handle/test.php",
        data: params, // Send all parameters
        dataType: "json",
        success: function (response) {
            $("#main-content").html(response.html);
            // Update the URL
            let queryString = $.param(params);
            queryString = cleanQueryString(queryString);
            history.pushState(params, "", "admin.php?" + queryString);
        },
        error: function (error) {
            console.error("Error navigate page:", error);
         
        }
    });
}

function update(params) {
    $.ajax({
        type: "GET",
        url: "./handle/adminHandler.php",
        // url: "./handle/test.php",
        data: params, // Send all parameters
        dataType: "json",
        success: function (response) {
            $("#main-content").html(response.html);
            // Update the URL
            let queryString = $.param(params);
            queryString = cleanQueryString(queryString);
            history.pushState(params, "", "admin.php?" + queryString);
        },
        error: function (error) {
            console.error("Error navigate page:", error);

        }
    });
}

function toggelStatus(params) {
    $.ajax({
        type: "GET",
        url: "./handle/adminHandler.php",
        // url: "./handle/test.php",
        data: params, // Send all parameters
        dataType: "json",
        success: function (response) {
            $("#main-content").html(response.html);
            // Update the URL
            let queryString = $.param(params);
            queryString = cleanQueryString(queryString);
            history.pushState(params, "", "admin.php?" + queryString);
        },
        error: function (error) {
            console.error("Error navigate page:", error);
         
        }
    });
}



$(document).ready(function () {
    loadAllctdt(1);
    loadAllNganh();
    loadAllChuky();

    $("#ctdt-list").on("click", ".action-sua", function (event) {
        event.preventDefault();
        let act = $(this).data("act");
        let currentParams = getUrlParams();
        let newParams = { ...currentParams, act: act };

        // xử lí này sẽ truyền param lên url vd: ..act="them"&id=3
        let id = $(this).data("id");
        if (id) {
            // let newParams = { ...currentParams, act: act, id: 3 };
        }

        updateContent(newParams);
    });

    $("#btn-loc").on("click", function () {
        const selectedNganh = $("#select-nganh").val();
        const nganh = selectedNganh == -1 ? null : selectedNganh;
        const selectedChuky = $("#select-chuky").val();
        const chuky = selectedChuky == -1 ? null : selectedChuky;
        const selectedLoai = $("#select-loai").val();
        const loai = selectedLoai == -1 ? null : selectedLoai;
        const selectedStatus = $("#select-status").val();
        const status = selectedStatus == -1 ? null : selectedStatus;

        loadAllctdt(1, nganh, chuky, loai, status);
    });

    $("#pagination").on("click", ".btn-page", function () {
        const currentPage = Number($("#pagination .btn-page[aria-current='page']").data("page"));
        const selectedPage = Number($(this).data("page"));
        if (currentPage == selectedPage) {
            return;
        }
        const selectedNganh = $("#select-nganh").val();
        const nganh = selectedNganh == -1 ? null : selectedNganh;
        const selectedChuky = $("#select-chuky").val();
        const chuky = selectedChuky == -1 ? null : selectedChuky;
        const selectedLoai = $("#select-loai").val();
        const loai = selectedLoai == -1 ? null : selectedLoai;
        const selectedStatus = $("#select-status").val();
        const status = selectedStatus == -1 ? null : selectedStatus;
        loadAllctdt(selectedPage, nganh, chuky, loai, status);
    });

    $("#pagination").on("click", ".btn-prev", function () {
        const currentPage = Number($("#pagination .btn-prev[aria-current='page']").data("page"));
        if (currentPage == 1) {
            return;
        }
        const selectedNganh = $("#select-nganh").val();
        const nganh = selectedNganh == -1 ? null : selectedNganh;
        const selectedChuky = $("#select-chuky").val();
        const chuky = selectedChuky == -1 ? null : selectedChuky;
        const selectedLoai = $("#select-loai").val();
        const loai = selectedLoai == -1 ? null : selectedLoai;
        const selectedStatus = $("#select-status").val();
        const status = selectedStatus == -1 ? null : selectedStatus;
        const selectedPage = currentPage + 1;
        loadAllctdt(currentPage, nganh, chuky, loai, status);
    });

    $("#pagination").on("click", ".btn-next", function () {
        const currentPage = Number($("#pagination .btn-next[aria-current='page']").data("page"));
        if (currentPage == $("#pagination .btn-page]").length) {
            return;
        }
        const selectedNganh = $("#select-nganh").val();
        const nganh = selectedNganh == -1 ? null : selectedNganh;
        const selectedChuky = $("#select-chuky").val();
        const chuky = selectedChuky == -1 ? null : selectedChuky;
        const selectedLoai = $("#select-loai").val();
        const loai = selectedLoai == -1 ? null : selectedLoai;
        const selectedStatus = $("#select-status").val();
        const status = selectedStatus == -1 ? null : selectedStatus;
        const selectedPage = currentPage + 1;
        loadAllctdt(currentPage, nganh, chuky, loai, status);
    });
});