async function getAllKqKhaoSat(page = 1, ks_id = null) {
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

async function loadAllKqKhaoSat(page = 1, status = null) {
    const res = await getAllKqKhaoSat(page, status);
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
                        <button class="action-item btn btn-circle btn-text btn-sm" aria-label="Action button" data-act="nganh-sua" data-id="${item.nganh_id}"><span class="icon-[tabler--pencil] size-5"></span></button>
                        <button class="btn btn-circle btn-text btn-sm" aria-label="Action button" onclick=toggleStatus(${item.nganh_id})><span class="icon-[tabler--trash] size-5"></span></button>
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

$(document).ready(function () {
    loadAllKqKhaoSat(1);

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
        update();
    });

    $("#btn-loc").on("click", function () {
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        loadAllKqKhaoSat(1, status);
    });

    $("#pagination").on("click", ".btn-page", function () {
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedPage = Number($(this).data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == selectedPage) {
            return;
        }
        loadAllKqKhaoSat(selectedPage, status);
    });

    $("#pagination").on("click", ".btn-prev", function () {
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == 1) {
            return;
        }
        currentPage -= 1;
        loadAllKqKhaoSat(currentPage, status);
    });

    $("#pagination").on("click", ".btn-next", function () {
        const currentPage = Number($("#pagination button[aria-current='page']").data("page"));
        const selectedValue = $("#select-status").val();
        const status = selectedValue == -1 ? null : selectedValue;
        if (currentPage == $("#pagination .btn-page]").length) {
            return;
        }
        currentPage += 1;
        loadAllKqKhaoSat(currentPage, status);
    });
});