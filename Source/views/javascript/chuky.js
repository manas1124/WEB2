async function getAllChuky(page = 1, status = null, txt_search = null) {
    try {
        const response = await $.ajax({
            url: "./controller/chuKyController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllpaging",
                page: page,
                status: status,
                txt_search: txt_search
            },
        });
        return response;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadAllChuky(page = 1, status = null, txt_search = null) {
    const res = await getAllChuky(page, status, txt_search);
    if (res?.status == false && res?.message) {
        Swal.fire({
            title: "Thông báo",
            text: res.message,
            icon: "warning"
        });
        return;
    }
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
                        <button class="action-item btn btn-circle btn-text btn-sm" aria-label="Action button" data-act="chuky-sua" data-id="${item.ck_id}"><span class="icon-[tabler--pencil] size-5"></span></button>
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
            if (!response.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: response.message
                });
            }
            else {
                if (response.data) {
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
            }

            history.back();
        },
        error: function (error) {
            console.error("Error navigate page:", error);

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
            if (!response.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: response.message
                });
            }
            else {
                if (response.data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Lưu thay đổi thành công!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Lưu thay đổi thất bại!'
                    });
                }
            }
            history.back();
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
            if (response?.status == false && response?.message) {
                Swal.fire({
                    title: "Thông báo",
                    text: response.message,
                    icon: "warning"
                });
            } else {
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
            }


        },
        error: function (error) {
            console.error("Error loading form sua:", error);
        }
    });
}

$(document).ready(function () {
    loadAllChuky(1);

    // Xử lý nút Lọc
    $("#btn-loc").on("click", function () {
        const txtSearch = $("#search-keyword").val().trim();
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllChuky(1, status, txtSearch);
    });

    $("#btn-search").on("click", function () {
        const txtSearch = $("#search-keyword").val().trim();
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllChuky(1, status, txtSearch);
    });


    $("#btn-reset").on("click", function () {
        $("#select-status").val(-1);
        const txtSearch = $("#search-keyword").val().trim();
        loadAllChuky(1, null, txtSearch);
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

    $("#btn-save").on("click", function () {
        const tenChuky = $("#ten-ck").val().trim();
        if (!tenChuky) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Tên chu kỳ không được để trống!'
            });
            return;
        }

        Swal.fire({
            title: 'Bạn có chắc chắn muốn sửa?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, sửa ngay',
            cancelButtonText: 'Không'
        }).then((result) => {
            if (result.isConfirmed) {
                update();
            }
        });
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
        let currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        console.log(currentPage);
        if (currentPage == 1) {
            return;
        }
        currentPage -= 1;
        console, log(currentPage);
        loadAllChuky(currentPage, status);
    });

    $("#pagination").on("click", ".btn-next", function () {
        let currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        const totalPages = $("#pagination .btn-page").length;
        console.log(currentPage);
        if (currentPage == totalPages) {
            return;
        }
        currentPage += 1;
        console, log(currentPage);
        loadAllChuky(currentPage, status);
    });
});