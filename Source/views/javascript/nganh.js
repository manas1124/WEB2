window.HSStaticMethods.autoInit();

async function getAllNganh(page = 1, status = null, txt_search = null) {
    try {
        const response = await $.ajax({
            url: "./controller/nganhController.php",
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

async function loadAllNganh(page = 1, status = null, txt_search = null) {
    const res = await getAllNganh(page, status, txt_search);
    if (res?.status === false && res?.message) {
        Swal.fire({
            title: "Thông báo",
            text: res.message,
            icon: "warning"
        });
        return;
    }
    if (res) {
        console.log(res);
        const nganhList = res.data;
        const totalPages = res.totalPages;
        const currentPage = res.currentPage;
        $("#nganh-list").empty();
        $("#pagination").empty();
        if (nganhList.length == 0) {
            $("#nganh-list").html("<tr><td colspan='7' class='text-center text-gray-500 italic py-4 bg-gray-100 rounded'>Không tìm thấy ngành.</td></tr>");
            $("#pagination").empty();
            return;
        }
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
                        <button class="action-item btn btn-circle btn-text btn-sm edit-program hidden" aria-label="Action button" data-act="nganh-sua" data-id="${item.nganh_id}"><span class="icon-[tabler--pencil] size-5"></span></button>
                        <button class="btn btn-circle btn-text btn-sm delete-program hidden" aria-label="Action button" onclick=toggleStatus(${item.nganh_id})><span class="icon-[tabler--trash] size-5"></span></button>
                    </td>
                </tr>
            `);

        });
        window.AppState.applyPermissionControl();
        renderPagination(totalPages, currentPage);
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

function create() {
    const ten_nganh = $("#ten-nganh").val();
    const status = $("#select-status").val();
    $.ajax({
        url: "./controller/nganhController.php",
        type: "GET",
        dataType: "json",
        data: {
            func: "create",
            ten_nganh: ten_nganh,
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
    const nganh_id = $("#nganh_id").val();
    const ten_nganh = $("#ten-nganh").val();
    const status = $("#select-status").val();
    $.ajax({
        url: "./controller/nganhController.php",
        type: "GET",
        dataType: "json",
        data: {
            func: "update",
            nganh_id: nganh_id,
            ten_nganh: ten_nganh,
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
                        text: 'Lưu thay dổi thất bại!'
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

function toggleStatus(nganh_id) {
    Swal.fire({
        title: 'Bạn có chắc chắn muốn thay đổi trạng thái không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Có, thay đổi ngay',
        cancelButtonText: 'Không',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "./controller/nganhController.php",
                type: "GET",
                dataType: "json",
                data: {
                    func: "toggleStatus",
                    nganh_id: nganh_id,
                },
                success: function (response) {
                    if (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Đổi trạng thái thành công!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        const txtSearch = $("#search-keyword").val().trim();
                        const selectedValue = $("#select-status").val();
                        const status = selectedValue == -1 ? null : selectedValue;
                        loadAllNganh(1, status, txtSearch);
                    }

                },
                error: function (error) {
                    console.error("Error loading form sua:", error);
                }
            });
        }
    });
}

$(document).ready(function () {
    loadAllNganh(1);

    $("#btn-create").on("click", function () {
        if ($("#ten-nganh").val() != "") {
            create();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Tên ngành không được để trống!'
            });
        }
    });
    $("#btn-save").on("click", function () {
        const tenNganh = $("#ten-nganh").val().trim();
        if (!tenNganh) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Tên ngành không được để trống!'
            });
            return;
        }

        Swal.fire({
            title: 'Bạn có chắc chắn muốn sửa ngành?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, sửa ngay',
            cancelButtonText: 'Không',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                update(); // Gọi hàm cập nhật khi xác nhận
            }
        });
    });

    $("#btn-loc").on("click", function () {
        const txtSearch = $("#search-keyword").val().trim();
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllNganh(1, status, txtSearch);
    });

    $("#search-keyword").on("input", function () {
        const txtSearch = $("#search-keyword").val().trim();
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllNganh(1, status, txtSearch);
    });

    $("#btn-reset").on("click", function () {
        $("#select-status").val(-1);
        const txtSearch = $("#search-keyword").val().trim();
        loadAllNganh(1, null, txtSearch);
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
        let currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == 1) {
            return;
        }
        currentPage -= 1;
        loadAllNganh(currentPage, status);
    });

    $("#pagination").on("click", ".btn-next", function () {
        let currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        const totalPages = $("#pagination .btn-page").length; // lấy tổng số trang
        if (currentPage == totalPages) {
            return;
        }
        currentPage += 1;
        loadAllNganh(currentPage, status);
    });
});