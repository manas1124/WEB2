async function getAllChuky(page = 1, status = null) {
    try {
        const response = await $.ajax({
            url: "./controller/chuKyController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllpaging",
                page: page,
                status: status
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadAllChuky(page = 1, status = null) {
    const res = await getAllChuky(page, status);
    if (res) {
        console.log(res);
        const chukyList = res.data;
        const totalPages = res.totalPages;
        const currentPage = res.currentPage;
        $("#chuky-list").empty();
        $("#pagination").empty();
        chukyList.forEach(item => {
            $("#chuky-list").append(`
              <tr>
                    <td>${item.ck_id}</td>
                    <td>${item.ten_ck}</td>
                    <td>${item.status == 1
                    ? '<span class="badge badge-soft badge-success ">Đang sử dụng</span>'
                    : '<span class="badge badge-soft badge-error ">Đã khóa</span>'
                }</td>
                    <td>
                        <button class="action-sua btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--pencil] size-5"></span></button>
                        <button class="btn btn-circle btn-text btn-sm" aria-label="Action button" onclick="toggleStatus(${item.ck_id})"><span class="icon-[tabler--trash] size-5"></span></button>
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

function create() {
    const ten_ck = $("#ten-chuky").val();
    const status = $("#select-status").val();
    $.ajax({
        url: "./controller/chuKyController.php",
        type: "GET",
        dataType: "json",
        data: {
            func: "create",
            ten_ck: ten_ck,
            status: status
        },
        success: function (response) {
            if (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Tạo thành công!',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Tạo không thành công!'
                });
            }
        },
        error: function (error) {
            console.error("Error navigate page:", error);

        }
    });
}

function updatepage(params) {
    $.ajax({
        url: "./controller/chuKyController.php",
        type: "GET",
        dataType: "json",
        data: params,
        success: function (response) {
            $("#main-content").html(response.html);
            let queryString = $.param(params);
            history.pushState(params, "", "admin.php?" + queryString);
        },
        error: function (error) {
            console.error("Error loading form sua:", error);
        }
    });
}

function update() {
    const ck_id = $("#ck_id").val();
    const ten_ck = $("#ten-ck").val();
    const status = $("#select-status").val();
    $.ajax({
        url: "./controller/chuKyController.php",
        type: "GET",
        dataType: "json",
        data: {
            func: "update",
            ck_id: ck_id,
            ten_ck: ten_ck,
            status: status
        },
        success: function (response) {

        },
        error: function (error) {
            console.error("Error loading form sua:", error);
        }
    });
}

function toggleStatus(ck_id) {
    $.ajax({
        url: "./controller/chuKyController.php",
        type: "GET",
        dataType: "json",
        data: {
            func: "toggleStatus",
            ck_id: ck_id,
        },
        success: function (response) {
            if (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Đổi trạng thái thành công!',
                    showConfirmButton: false,
                    timer: 2000
                });
                const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
                loadAllChuky(currentPage);
            }

        },
        error: function (error) {
            console.error("Error loading form sua:", error);
        }
    });
}

$(document).ready(function () {
    loadAllChuky(1);

    $("#chuky-list").on("click", ".action-sua", function (event) {

    });

    $("#btn-loc").on("click", function () {
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllChuky(1, status);
    });

    $("#btn-create").on("click", function () {
        if ($("#ten-chuky").val() != "") {
            create();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Tên chu kỳ không được để trống!'
            });
        }
    });

    $("#pagination").on("click", ".btn-page", function () {
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedPage = Number($(this).data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == selectedPage) {
            return;
        }
        loadAllChuky(selectedPage, status);
    });

    $("#pagination").on("click", ".btn-prev", function () {
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == 1) {
            return;
        }
        currentPage -= 1;
        loadAllChuky(currentPage, status);
    });

    $("#pagination").on("click", ".btn-next", function () {
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == $("#pagination .btn-page]").length) {
            return;
        }
        currentPage += 1;
        loadAllChuky(currentPage, status);
    });
});