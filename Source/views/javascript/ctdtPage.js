window.HSStaticMethods.autoInit();

async function getAllctdt(page = 1, nganh_id = null, ck_id = null, la_ctdt = null, status = null, txt_search = null) {
    try {
        const response = await $.ajax({
            url: "./controller/CTDTController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllpaging",
                page: page,
                txt_search: txt_search,
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


async function loadAllCTDT(page = 1, nganh_id = null, ck_id = null, la_ctdt = null, status = null, txt_search = null) {
    const res = await getAllctdt(page, nganh_id, ck_id, la_ctdt, status, txt_search);
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
        const ctdtList = res.data;
        const totalPages = res.totalPages;
        const currentPage = res.currentPage;
        $("#ctdt-list").empty();
        ctdtList.forEach(item => {
            $("#ctdt-list").append(`
              <tr>
                    <td>${item.ctdt_id}</td>
                    <td>${item.ten_nganh}</td>
                    <td>${item.ten_ck}</td>
                    <td>${item.la_ctdt == 1 ? "Chương trình đào tạo" : "Chuẩn đầu ra"}</td>
                    <td><a href="${item.file}" target="_blank">Xem file</a></td>
                    <td>${item.status == 1
                    ? '<span class="badge badge-soft badge-success ">Đang sử dụng</span>'
                    : '<span class="badge badge-soft badge-error ">Đã khóa</span>'
                }</td>
                    <td>
                        <button class="action-item btn btn-circle btn-text btn-sm edit-program hidden" aria-label="Action button" data-act="ctdt-sua" data-id="${item.ctdt_id}"><span class="icon-[tabler--pencil] size-5"></span></button>
                        <button class="btn btn-circle btn-text btn-sm delete-program hidden" aria-label="Action button" onclick="toggleStatus(${item.ctdt_id})"><span class="icon-[tabler--trash] size-5"></span></button>
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

    $("#pagination").append(`<button type="button" class="btn btn-text btn-prev" data-page="${currentPage}"><</button><div class="flex items-center gap-x-1">`);

    for (let i = 1; i <= totalPages; i++) {
        let activeClass = (i == currentPage) ? 'aria-current="page"' : '';
        $("#pagination").append(`
            <button type="button" class="btn btn-text btn-square aria-[current='page']:text-bg-primary btn-page" data-page="${i}" ${activeClass}>${i}</button>
        `);
    }

    $("#pagination").append(`</div><button type="button" class="btn btn-text btn-next" data-page="${currentPage}">></button>`);
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

function create() {
    const file = $("#file-decuong").val();
    const nganh_id = $("#select-nganh").val();
    const ck_id = $("#select-chuky").val();
    const la_ctdt = $("#select-loai").val();
    const status = $("#select-status").val();
    $.ajax({
        url: "./controller/CTDTController.php",
        type: "GET",
        dataType: "json",
        data: {
            func: "create",
            file: file,
            nganh_id: nganh_id,
            ck_id: ck_id,
            la_ctdt: la_ctdt,
            status: status
        },
        success: function (response) {
            if (!response.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'CTDT_CDR đã tồn tại!'
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
    const ctdt_id = $("#ctdt_id").val();
    const file = $("#file-decuong").val();
    const nganh_id = $("#select-nganh").val();
    const ck_id = $("#select-chuky").val();
    const la_ctdt = $("#select-loai").val();
    const status = $("#select-status").val();
    $.ajax({
        url: "./controller/CTDTController.php",
        type: "GET",
        dataType: "json",
        data: {
            func: "update",
            ctdt_id: ctdt_id,
            file: file,
            nganh_id: nganh_id,
            ck_id: ck_id,
            la_ctdt: la_ctdt,
            status: status
        },
        success: function (response) {
            if (!response.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: response.message,
                    timer: 2000
                });
            }
            else {
                if (response.data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã lưu thay đổi!',
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

function toggleStatus(ctdt_id) {
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
                url: "./controller/CTDTController.php",
                type: "GET",
                dataType: "json",
                data: {
                    func: "toggleStatus",
                    ctdt_id: ctdt_id,
                },
                success: function (response) {
                    if (!response.status) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: response.message,
                            timer: 2000
                        });
                    }
                    else {
                        if (response.data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Đã lưu thay đổi!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            const txt_search = $("#search-keyword").val().trim();
                            const selectedNganh = $("#select-nganh").val();
                            const nganh = selectedNganh == -1 ? null : selectedNganh;
                            const selectedChuky = $("#select-chuky").val();
                            const chuky = selectedChuky == -1 ? null : selectedChuky;
                            const selectedLoai = $("#select-loai").val();
                            const loai = selectedLoai == -1 ? null : selectedLoai;
                            const selectedStatus = $("#select-status").val();
                            const status = selectedStatus == -1 ? null : selectedStatus;

                            loadAllCTDT(1, nganh, chuky, loai, status, txt_search);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Lưu thay đổi thất bại!'
                            });
                        }
                    }

                },
                error: function (error) {
                    console.error("Error loading form sua:", error);
                }
            });
        }
    });
}



$(document).ready(async function () {
    loadAllCTDT(1);
    loadAllNganh();
    loadAllChuky();

    $("#btn-create").on("click", function () {
        if ($("#file-decuong").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'File đề cương không được để trống!'
            });
        }
        else if ($("#select-nganh").val() == -1) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Ngành không được để trống!'
            });
        }
        else if ($("#select-chuky").val() == -1) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Chu kỳ không được để trống!'
            });
        }
        else {
            create()
        }
    });

    $("#btn-save").on("click", function () {
        if ($("#file-decuong").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'File đề cương không được để trống!'
            });
        }
        else if ($("#select-nganh").val() == -1) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Ngành không được để trống!'
            });
        }
        else if ($("#select-chuky").val() == -1) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Chu kỳ không được để trống!'
            });
        }
        else {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn sửa ctdt?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có, sửa ngay',
                cancelButtonText: 'Không',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    update();
                }
            });
        }
    });

    $("#search-keyword").on("input", function () {
        const txt_search = $("#search-keyword").val().trim();
        const selectedNganh = $("#select-nganh").val();
        const nganh = selectedNganh == -1 ? null : selectedNganh;
        const selectedChuky = $("#select-chuky").val();
        const chuky = selectedChuky == -1 ? null : selectedChuky;
        const selectedLoai = $("#select-loai").val();
        const loai = selectedLoai == -1 ? null : selectedLoai;
        const selectedStatus = $("#select-status").val();
        const status = selectedStatus == -1 ? null : selectedStatus;

        console.log("Tìm kiếm:", txt_search);
        loadAllCTDT(1, nganh, chuky, loai, status, txt_search);
    });

    $("#btn-loc").on("click", function () {
        const txt_search = $("#search-keyword").val().trim();
        const selectedNganh = $("#select-nganh").val();
        const nganh = selectedNganh == -1 ? null : selectedNganh;
        const selectedChuky = $("#select-chuky").val();
        const chuky = selectedChuky == -1 ? null : selectedChuky;
        const selectedLoai = $("#select-loai").val();
        const loai = selectedLoai == -1 ? null : selectedLoai;
        const selectedStatus = $("#select-status").val();
        const status = selectedStatus == -1 ? null : selectedStatus;
        console.log("nganh: " + nganh + "; chuky: " + chuky + "; loai: " + loai + "; status: " + status);
        loadAllCTDT(1, nganh, chuky, loai, status, txt_search);
    });

    $("#btn-reset").on("click", function () {
        $("#select-nganh").val("-1");
        $("#select-chuky").val("-1");
        $("#select-loai").val("-1");
        $("#select-status").val("-1");
        const txt_search = $("#search-keyword").val().trim();
        loadAllCTDT(1, null, null, null, null, txt_search);
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
        console.log(selectedPage, nganh, chuky, loai, status);
        loadAllCTDT(selectedPage, nganh, chuky, loai, status);
    });

    $("#pagination").on("click", ".btn-prev", function () {
        let currentPage = Number($(this).data("page"));
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
        currentPage -= 1;
        console.log(currentPage, nganh, chuky, loai, status);
        loadAllCTDT(currentPage, nganh, chuky, loai, status);
    });

    $("#pagination").on("click", ".btn-next", function () {
        let currentPage = Number($(this).data("page"));
        if (currentPage == $("#pagination .btn-page").length) {
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
        currentPage += 1;
        console.log(currentPage, nganh, chuky, loai, status);
        loadAllCTDT(currentPage, nganh, chuky, loai, status);
    });
});