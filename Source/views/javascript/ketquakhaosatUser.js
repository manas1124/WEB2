// const { data } = require("jquery");

window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component

async function getAllKhaoSat(page = 1, ks_ids = null, txt_search = null,
    ngay_bat_dau = null, ngay_ket_thuc = null) {
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
                nks_id: null,
                nganh: null,
                chuky: null
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

async function getKsIds(user_id) {
    try {
        const response = await $.ajax({
            url: "./controller/ketQuaKhaoSatController.php",
            type: "GET",
            dataType: "json",
            data: {
                func: "getIdKhaoSatByIdUser",
                user_id: user_id
            }
        });
        return response;
    } catch (error) {
        console.log(error);
    }
}

async function getCurrentLoginUser() {
    try {
        const response = await $.ajax({
            url: "./controller/AuthController.php",
            type: "POST",
            dataType: "json",
            data: { func: "getCurrentLoginUser" },
        });
        return response.userInfor;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function loadDsKhaoSat(page = 1, txt_search = null, ngay_bat_dau = null, ngay_ket_thuc = null) {
    const currentLoginUser = await getCurrentLoginUser();
    if (currentLoginUser && currentLoginUser?.dtId) {
        const ks_ids = await getKsIds(currentLoginUser.dtId);
        console.log(ks_ids);
        if (!ks_ids || ks_ids.length === 0) {
            $("#ks-list").html("<tr><td colspan='7' class='text-center text-gray-500 italic py-4 bg-gray-100 rounded'>Không có kết quả khảo sát nào.</td></tr>");
            $("#pagination").empty();
            return;
        }
        const ksList = await getAllKhaoSat(page, ks_ids, txt_search, ngay_bat_dau, ngay_ket_thuc);

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
                        <button class="action-item btn btn-circle btn-text btn-sm" data-act="xem-kqks" data-id="${item.ks_id}" aria-label="xem ket qua">
                            <span class="icon-[tabler--eye] size-5"></span>
                        </button>
                        <button class="btnExcel btn btn-circle btn-text btn-sm" data-id="${item.ks_id}" aria-label="xuất excel">
                            <span class="icon-[tabler--file-spreadsheet] size-5"></span>
                        </button>
                    </td>
                </tr>
      
            `);
            });

            renderPagination(ksList.data.totalPages, ksList.data.currentPage);
        }
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



$(function () {
    loadDsKhaoSat();

    $(".main-content").on("click", ".action-item", function (e) {
        e.preventDefault();
        let action = $(this).data("act");
        console.log(action)
    });

    // Hàm lấy dữ liệu bộ lọc từ các trường
    function getFilterData() {
        return {
            txt_search: $("#search-keyword").val().trim(),
            ngay_bat_dau: $("#from-date").val(),
            ngay_ket_thuc: $("#to-date").val(),
        };
    }

    // Nút Tìm kiếm
    $("#search-keyword").on("input", function () {
        const filters = getFilterData();
        console.log("Tìm kiếm với:", filters);
        loadDsKhaoSat(1, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc);
    });

    // Nút Lọc
    $("#btn-filter").on("click", function () {
        const filters = getFilterData();
        console.log("Lọc với:", filters);
        loadDsKhaoSat(1, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc);
    });

    // Nút Reset
    $("#btn-reset").on("click", function () {
        $("#from-date").val('');
        $("#to-date").val('');
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
        loadDsKhaoSat(selectedPage, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc);
    });

    $("#pagination").on("click", ".btn-prev", function () {
        const currentPage = Number($("#pagination .btn-page[aria-current='page']").data("page"));
        if (currentPage > 1) {
            const filters = getFilterData();
            loadDsKhaoSat(currentPage - 1, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc);
        }
    });
    
    $("#pagination").on("click", ".btn-next", function () {
        const currentPage = Number($("#pagination .btn-page[aria-current='page']").data("page"));
        const totalPages = $("#pagination .btn-page").length;
        if (currentPage < totalPages) {
            const filters = getFilterData();
            loadDsKhaoSat(currentPage + 1, filters.txt_search, filters.ngay_bat_dau, filters.ngay_ket_thuc);
        }
    });

});
