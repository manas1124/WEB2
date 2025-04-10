async function getAllNganh(page = 1, status = null) {
    try {
        const response = await $.ajax({
            url: "./controller/nganhController.php",
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

async function loadAllNganh(page = 1, status = null) {
    const res = await getAllNganh(page, status);
    if (res) {
        console.log(res);
        const nganhList = res.data;
        const totalPages = res.totalPages;
        const currentPage = res.currentPage;
        $("#nganh-list").empty();
        $("#pagination").empty();
        nganhList.forEach(item => {
            $("#nganh-list").append(`
              <tr>
                    <td>${item.nganh_id}</td>
                    <td>${item.ten_nganh}</td>
                    <td>${item.status == 1
                    ? '<span class="badge badge-soft badge-success ">Đang sử dụng</span>'
                    : '<span class="badge badge-soft badge-error ">Đã khóa</span>'
                }</td>
                    <td>
                        <button class="action-sua btn btn-circle btn-text btn-sm" aria-label="Action button" data-act="update"><span class="icon-[tabler--pencil] size-5"></span></button>
                        <button class="action-status btn btn-circle btn-text btn-sm" aria-label="Action button" data-act="toggleStatus"><span class="icon-[tabler--trash] size-5"></span></button>
                    </td>
                </tr>
            `);
            console.log(item.nganh_id);

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

function createNganh() {
    const ten_nganh = $("#ten-nganh").val();
    const status = $("#select-status").val();
    $.ajax({
        url: "./controller/chuKyController.php",
        type: "GET",
        dataType: "json",
        data: {
            func: createnganh,
            ten_nganh: ten_nganh,
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
        url: "./controller/nganhController.php",
        type: "GET",
        dataType: "json",
        data: params,
        success: function (response) {
            $("#main-content").html(response.html);
            let queryString = $.param(newParams);
            history.pushState(newParams, "", "admin.php?" + queryString);
        },
        error: function (error) {
            console.error("Error loading form sua:", error);
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
    loadAllNganh(1);

    $("#nganh-list").on("click", ".action-sua", function (event) {
        let act = $(this).data("act");
        let id = $(this).data("id");
        let currentParams = getUrlParams();
        let param = { ...currentParams, func: act, id: id };
        updatepage(param);
    });

    $().on("click", "#btn-create", function () {

    });
    $().on("click", "#btn-save", function () {

    });

    $("#btn-loc").on("click", function () {
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllNganh(1, status);
    });

    $("#pagination").on("click", ".btn-page", function () {
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedPage = Number($(this).data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == selectedPage) {
            return;
        }
        loadAllNganh(selectedPage, status);
    });

    $("#pagination").on("click", ".btn-prev", function () {
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == 1) {
            return;
        }
        currentPage -= 1;
        loadAllNganh(currentPage, status);
    });

    $("#pagination").on("click", ".btn-next", function () {
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == $("#pagination .btn-page]").length) {
            return;
        }
        currentPage += 1;
        loadAllNganh(currentPage, status);
    });
});