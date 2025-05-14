window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component
function test() {
  console.log("test2");
}

async function getKhaoSatByPageNumber(page = 1, keyword = null) {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: { func: "getKhaoSatByPageNumber", number: page, keyword: keyword },
      dataType: "json",
    });
    console.log("fect", response);
    return response;
  } catch (e) {
    console.log(e);
    console.log("loi fetchdata getAllKhaoSat");
    return null;
  }
}
async function deleteKs(id) {
  const result = await Swal.fire({
    title: "Thông báo",
    html: "Chắc chắn xóa ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Xác nhận",
    cancelButtonText: "Hủy",
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    try {
      const response = await $.ajax({
        url: "./controller/KhaoSatController.php",
        type: "POST",
        data: { func: "deleteKs", id: id },
        dataType: "json",
      });
      if (response) {
        Swal.fire("Thông báo", "Xóa khảo sát thành công", "success").then(() => {
          $("#khao-sat-page").trigger("click");
        });
      } else {
        Swal.fire("Thông báo", "Xóa khảo sát thất bại", "error");
      }
      return response;
    } catch (error) {
      console.log("loi xoa khao sat ", error);
      Swal.fire("Thông báo", "Có lỗi xảy ra trong quá trình xóa", "error");
      return null;
    }
  } else {
    return false;
  }
}

async function getKhaoSatById() {
  try {
    const response = await $.ajax({
      url: "./controller/KhaoSatController.php",
      type: "POST",
      data: JSON.stringify({ func: "getKhaoSatById", data: { ks_id: 1 } }),
    });
    // response is json type
    return { data: response, error: null }; // Directly return the JSON response
  } catch (error) {
    console.log("loi fetchdata getKhaoSatById");
    return null;
  }
}
async function renderAllKhaoSat(page = 1, keyword = null) {
  const res = await getKhaoSatByPageNumber(page, keyword);

  if (res) {
    const ksList = res.data;
    const totalPages = res.totalPages;
    const currentPage = res.currentPage;
    const surveyUsedStatus = {
      0: '<span class="badge badge-soft badge-error ">Kết thúc</span>',
      1: '<span class="badge badge-soft badge-success ">Đang thực hiện</span>',
      2: '<span class="badge badge-soft badge-warning ">Chưa bắt đầu</span>',
    };
    $("#ks-list").empty();
    $("#pagination").empty();
    if (ksList != null) {
      ksList.map((item) => {
        $("#ks-list").append(`
            <tr>
                <td>${item.ten_ks}</td>
                <td class="text-center">${item.ngay_bat_dau}</td>
                <td class="text-center">${item.ngay_ket_thuc}</td>
                <td class="text-center">
                  ${surveyUsedStatus[item.su_dung]}
                </td>
                <td>
                <button class="action-item btn btn-circle btn-text btn-sm view-survey hidden" data-act="ks-chi-tiet" data-id="${
                  item.ks_id
                }" aria-label="xem chi tiết"> <span class="icon-[solar--eye-linear] size-5"></span></button>
               
                  <button class="action-item btn btn-circle btn-text btn-sm edit-survey hidden" data-act="ks-sua" data-id="${
                    item.ks_id
                  }" aria-label="sua khao sat"><span class="icon-[tabler--pencil] size-5"></span></button>
                  <button onclick="deleteKs(${
                    item.ks_id
                  })" class="btn btn-circle btn-text btn-sm delete-survey hidden" aria-label="xoa khao sat"><span class="icon-[tabler--trash] size-5"></span></button>
                </td>
            </tr>
    
          `);
      });
      window.AppState.applyPermissionControl();
    }
    $("#pagination").append(
      `<button type="button" class="btn btn-text btn-prev"><</button><div class="flex items-center gap-x-1">`
    );
    for (let i = 1; i <= totalPages; i++) {
      let activeClass = i == currentPage ? 'aria-current="page"' : "";
      $("#pagination").append(`
              <button type="button" class="btn btn-text btn-square aria-[current='page']:text-bg-primary btn-page" data-page="${i}" ${activeClass}>${i}</button>
          `);
    }
    $("#pagination").append(
      `</div><button type="button" class="btn btn-text btn-next">></button>`
    );
  }
}
$("#btn-search-ks").on("click", function () {
  let keyword = $("#input-search-ks").val();
  renderAllKhaoSat(1, keyword);
  $("#input-search-ks").val("");
});
$(function () {
  renderAllKhaoSat();

  $("#pagination").on("click", ".btn-page", function () {
    const currentPage = Number(
      $("#pagination button[aria-current='page']").data("page")
    );
    const selectedPage = Number($(this).data("page"));
    const selectedValue = $("#select-status").val();
    const status = selectedValue == -1 ? null : selectedValue;
    console.log(currentPage);
    console.log(selectedPage);
    if (currentPage == selectedPage) {
      return;
    }
    renderAllKhaoSat(selectedPage, status);
  });

  $("#pagination").on("click", ".btn-prev", function () {
    let currentPage = Number(
      $("#pagination button[aria-current='page']").data("page")
    );
    if (currentPage == 1) {
      return;
    }
    currentPage -= 1;
    renderAllKhaoSat(currentPage);
  });

  $("#pagination").on("click", ".btn-next", function () {
    let currentPage = Number(
      $("#pagination button[aria-current='page']").data("page")
    );
    console.log("pre", currentPage);
    if (currentPage == $("#pagination .btn-page").length) {
      return;
    }
    currentPage += 1;
    renderAllKhaoSat(currentPage);
  });
});
