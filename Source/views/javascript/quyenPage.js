window.HSStaticMethods.autoInit();

async function getAllQuyen() {
  try {
    const response = await $.ajax({
      url: "./controller/quyenController.php",
      type: "POST",
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
async function loadAllQuyen() {
  const quyenList = await getAllQuyen();
  if (quyenList) {
    console.log(quyenList);
    $("#quyen-list").empty();
    quyenList.forEach((item) => {
      $("#quyen-list").append(`
          <tr>
            <td>${item.quyen_id}</td>
            <td>${item.ten_quyen}</td>
            <td>
              <button class="btn btn-circle btn-text btn-sm action-item edit-permission hidden" data-act="quyen-edit" data-id="${item.quyen_id}" aria-label="Sửa tài khoản">
                <span class="icon-[tabler--pencil] size-5"></span>
              </button>
              <button class="btn btn-circle btn-text btn-sm action-item delete-permission hidden" id="quyen-xoa" data-id="${item.quyen_id}" aria-label="Xoá tài khoản">
                <span class="icon-[tabler--trash] size-5"></span>
              </button>
            </td>
          </tr>
        `);
    });
    window.AppState.applyPermissionControl();
  }
}
function updatepage(params) {
  $.ajax({
    type: "GET",
    url: "./handle/adminHandler.php",
    // url: "./handle/test.php",
    data: params, // Send all parameters
    dataType: "json",
    success: function (response) {
      $("#main-content").html(response.html);
      // Update the URL
      let queryString = $.param(params);
      queryString = cleanQueryString(queryString);
      history.pushState(params, "", "admin.php?" + queryString);
    },
    error: function (error) {
      console.error("Error navigate page:", error);
    },
  });
}
function create() {
  const ten_quyen = $("#ten_quyen").val();
  const status = $("#select-status").val();
  var selectedChucNang = [];

  // Iterate through each row in the tbody
  $("#checkbox-data tr").each(function () {
    var rowId = $(this).attr("id");

    $(this)
      .find('input[type="checkbox"]:checked')
      .each(function () {
        selectedChucNang.push($(this).val());
      });

  });
  console.log(ten_quyen,selectedChucNang)
  
  $.ajax({
    url: "./controller/quyenController.php",
    type: "POST",
    dataType: "json",
    data: {
      func: "create",
      ten_quyen : ten_quyen,
      selectedChucNang: selectedChucNang,
      status : status,

    },
    success: function (response) {
      if (response) {
        Swal.fire({
          icon: "success",
          title: "Tạo thành công!",
          showConfirmButton: false,
          timer: 2000,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Lỗi",
          text: "Tạo không thành công!",
        });
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", {
        status: status,
        error: error,
        responseText: xhr.responseText,
      });
      Swal.fire({
        icon: "error",
        title: "Lỗi server",
        html: `<b>${xhr.status} ${xhr.statusText}</b><br><pre>${xhr.responseText}</pre>`,
      });
    },
  });
  
}
$(document).ready(function () {
  loadAllQuyen();

  $("#quyen-list").on("click", ".action-sua", function (event) {
    event.preventDefault();
    let act = $(this).data("act");
    let currentParams = getUrlParams();
    let newParams = { ...currentParams, act: act };

    let id = $(this).data("id");
    if (id) {
      newParams.id = id;
    }

    updateContent(newParams);
  });

  $("#btn-create").on("click", function () {
    if ($("#ten_quyen").val() === "") {
      Swal.fire({
        icon: "error",
        title: "Lỗi",
        text: "Tên quyền không được để trống!",
      });
    } else {
      create();
    }
  });
});
$("#return-page").on("click", function () {
  $("#quyen-page").trigger("click");
});

$(document).on("click", '[id="quyen-xoa"]', function () {
  const quyen_id = $(this).data("id");

  Swal.fire({
    title: "Bạn có chắc chắn muốn xóa quyền này chứ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Xóa",
    cancelButtonText: "Hủy",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "./controller/quyenController.php",
        type: "POST",
        dataType: "json",
        data: {
          func: "delete",
          quyen_id: quyen_id,
        },
        success: function (response) {
          if (response.status) {
            Swal.fire({
              title: "Đã xóa!",
              text: response.message || "Xóa thành công!",
              icon: "success",
              timer: 1500,
              showConfirmButton: false,
            }).then(() => {
              // ✅ Tải lại trang sau khi xóa
              location.reload();
            });
          } else {
            Swal.fire(
              "Thất bại!",
              response.message || "Không thể xóa tài khoản",
              "error"
            );
          }
        },
        error: function (xhr) {
          console.error("AJAX Error:", xhr);
          console.error("Response Text:", xhr.responseText);
          Swal.fire("Lỗi hệ thống", "Không thể kết nối đến server", "error");
        },
      });
    }
  });
});
