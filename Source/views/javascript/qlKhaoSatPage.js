const { error } = require("jquery");

window.HSStaticMethods.autoInit() // phải dùng câu lệnh này để dùng lại js component
function test() {
  console.log("test2");
}
async function getAllKhaoSat() {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "getAllKhaoSat"},
      dataType: "json",
    });
    return { data: response }; // Directly return the JSON response
  } catch (error) {
    return { error: `error fetch bai khao sat: ${error.status} - ${error.statusText}` };
  }
}

async function getKhaoSatById() {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "getKhaoSatById", data: { ks_id: 1 } },
      dataType: "json",
    });
    // response is json type
    return { data: response , error: null};  // Directly return the JSON response
  } catch (error) {
    return { error: `AJAX error: ${error.status} - ${error.statusText}` };
  }
}

$(function () {
  (async () => {
    const ksListData = await getAllKhaoSat();
    console.log("loa trnag")
    if (ksListData.error) {
      console.log(ksListData.error);
    } else {
      console.log("dang tai")
      const ksList = ksListData.data;
      ksList.map((item) => {
        $("#ks-list").append(`
          <tr>
              <td>${item.ten_ks}</td>
              <td>${item.ngay_bat_dau}</td>
              <td>${item.ngay_ket_thuc}</td>
              <td class="text-center">
              ${
                item.su_dung == 1
                  ? '<span class="badge badge-soft badge-success ">Đang thực hiện</span>'
                  : '<span class="badge badge-soft badge-error ">Kết thúc</span>'
              }
              </td>
              <td>
                <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--pencil] size-5"></span></button>
                <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--trash] size-5"></span></button>
                <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span class="icon-[tabler--dots-vertical] size-5"></span></button>
              </td>
          </tr>
  
        `);
      });
    }
  })();
});
