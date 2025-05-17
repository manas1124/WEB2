window.HSStaticMethods.autoInit();

async function getAllLoaiTraLoi(page = 1, status = null, txt_search = null) {
    try {
        const response = await $.ajax({
            url: "./controller/loaiTraLoiController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getAllPaging",
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

async function loadAllLoaiTraLoi(page = 1, status = null, txt_search = null) {
    console.log("page:" + page + ", status:" + status + ", txt_search:" + txt_search)
    const res = await getAllLoaiTraLoi(page, status, txt_search);
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
        const loaiTraLoiList = res.data;
        const totalPages = res.totalPages;
        const currentPage = res.currentPage;
        $("#loaiTraLoi-list").empty();
        if (loaiTraLoiList.length == 0) {
            $("#loaiTraLoi-list").html("<tr><td colspan='7' class='text-center text-gray-500 italic py-4 bg-gray-100 rounded'>Không tìm thấy loại trả lời.</td></tr>");
            $("#pagination").empty();
            return;
        }
        loaiTraLoiList.forEach(item => {
            $("#loaiTraLoi-list").append(`
              <tr>
                    <td>${item.ltl_id}</td>
                    <td>${item.thang_diem}</td>
                    <td>${item.mota}</td>
                    <td>${item.status == 1
                    ? '<span class="badge badge-soft badge-success ">Đang sử dụng</span>'
                    : '<span class="badge badge-soft badge-error ">Đã khóa</span>'
                }</td>
                    <td>
                        <button class="action-item btn btn-circle btn-text btn-sm view-survey hidden" aria-label="Action button" data-act="ltl-chi-tiet" data-id="${item.ltl_id}"><span class="icon-[tabler--eye] size-5"></span></button>
                        <button class="action-item btn btn-circle btn-text btn-sm edit-survey hidden" aria-label="Action button" data-act="ltl-sua" data-id="${item.ltl_id}"><span class="icon-[tabler--pencil] size-5"></span></button>
                        <button class="btn btn-circle btn-text btn-sm delete-survey hidden" aria-label="Action button" onclick="toggleStatus(${item.ltl_id})"><span class="icon-[tabler--trash] size-5"></span></button>
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

function toggleStatus(ltl_id) {
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
                url: "./controller/loaiTraLoiController.php",
                type: "POST",
                dataType: "json",
                data: {
                    func: "toggleStatus",
                    ltl_id: ltl_id
                },
                success: function (response) {
                    if (response?.status == false && response?.message) {
                        Swal.fire({
                            title: "Thông báo",
                            text: response.message,
                            icon: "warning"
                        });
                    } else {
                        if (response.status == true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Đổi trạng thái thành công!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            const txtSearch = $("#search-keyword").val().trim();
                            const selectedValue = $("#select-status").val();
                            const status = selectedValue == -1 ? null : selectedValue;
                            loadAllLoaiTraLoi(1, status, txtSearch);
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

$(document).ready(function () {
    loadAllLoaiTraLoi(1);

    // Xử lý nút Lọc
    $("#btn-loc").on("click", function () {
        const txtSearch = $("#search-keyword").val().trim();
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllLoaiTraLoi(1, status, txtSearch);
    });

    $("#search-keyword").on("input", function () {
        const txtSearch = $("#search-keyword").val().trim();
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllLoaiTraLoi(1, status, txtSearch);
    });


    $("#btn-reset").on("click", function () {
        $("#select-status").val(-1);
        const txtSearch = $("#search-keyword").val().trim();
        loadAllLoaiTraLoi(1, null, txtSearch);
    });

    $("#btn-save").on("click", function () {


        Swal.fire({
            title: 'Bạn có chắc chắn muốn sửa?',
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
    });

    $("#pagination").on("click", ".btn-page", function () {
        const txtSearch = $("#search-keyword").val().trim();
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedPage = Number($(this).data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == selectedPage) {
            return;
        }
        loadAllLoaiTraLoi(selectedPage, status, txtSearch);
    });

    $("#pagination").on("click", ".btn-prev", function () {
        const txtSearch = $("#search-keyword").val().trim();
        let currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        console.log(currentPage);
        if (currentPage == 1) {
            return;
        }
        currentPage -= 1;
        console.log(currentPage);
        loadAllLoaiTraLoi(currentPage, status, txtSearch);
    });

    $("#pagination").on("click", ".btn-next", function () {
        const txtSearch = $("#search-keyword").val().trim();
        let currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        const totalPages = $("#pagination .btn-page").length;
        console.log(currentPage);
        if (currentPage == totalPages) {
            return;
        }
        currentPage += 1;
        console.log(currentPage);
        loadAllLoaiTraLoi(currentPage, status, txtSearch);
    });
});