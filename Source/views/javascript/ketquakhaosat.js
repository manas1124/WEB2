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

    console.log(ksList);
    console.log(ks_ids);

    // ksList = JSON.parse(ksList)
    if (ksList.status) {
        // console.log(ksList)
        $("#ks-list").empty();
        console.log("ok");
        ksList.data.data.map((item) => {
            $("#ks-list").append(`
          <tr>
              <td>${item.ten_ks}</td>
              <td>${item.ngay_bat_dau}</td>
              <td>${item.ngay_ket_thuc}</td>
              <td class="text-center">
              ${item.su_dung == 1
                    ? '<span class="badge badge-soft badge-success ">Đang thực hiện</span>'
                    : '<span class="badge badge-soft badge-error ">Kết thúc</span>'
                }
              </td>
              <td>
                <button class="action-item btn btn-circle btn-text btn-sm" data-act="ks-sua" data-id="${item.ks_id}" aria-label="sua khao sat"><span class="icon-[tabler--pencil] size-5"></span></button>
                <button onclick="deleteKs(${item.ks_id})" class="btn btn-circle btn-text btn-sm" aria-label="xoa khao sat"><span class="icon-[tabler--trash] size-5"></span></button>
              </td>
          </tr>
  
        `);
        });

    }
}

$(document).ready(function () {
    loadDsKhaoSat();

    $(".main-content").on("click", ".action-item", function (e) {
        e.preventDefault();
        let action = $(this).data("act");
        console.log(action)
        // $(".main-content").load(`day la trang ${action}`)
    });

});

