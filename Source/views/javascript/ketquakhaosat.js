// const { data } = require("jquery");

window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component

async function getAllKhaoSat(page = 1, ks_ids = null, ten_ks = null,
    ngay_bat_dau = null, ngay_ket_thuc = null,
    nks_id = null, ltl_id = null, ctdt_id = null) {
    try {
        const response = await $.ajax({
            url: "./controller/KhaoSatController.php",
            type: "POST",
            data: {
                func: "getAllKhaoSatFilter",
                page: page,
                ks_ids: ks_ids,
                ten_ks: ten_ks,
                ngay_bat_dau: ngay_bat_dau,
                ngay_ket_thuc: ngay_ket_thuc,
                nks_id: nks_id,
                ltl_id: ltl_id,
                ctdt_id: ctdt_id

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

async function loadDsKhaoSat() {
    const ks_ids = await getKsIds();
    const ksList = await getAllKhaoSat(1, ks_ids);

    console.log(ksList.data);
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
        success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `survey_export_${ks_id}.xlsx`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error("Đã xảy ra lỗi khi xuất Excel:", error);
        }
    });
}

$(document).ready(function () {
    loadDsKhaoSat();

    $(".main-content").on("click", ".action-item", function (e) {
        e.preventDefault();
        let action = $(this).data("act");
        console.log(action) 
    });

    $('.btnExcel').on('click', function () {
        let ks_id = $(this).data("id");
        xuatExel(ks_id);
    });

});

