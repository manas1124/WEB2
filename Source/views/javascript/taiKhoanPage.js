window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component

async function getAllTaiKhoan() {
  try {
    const response = await $.ajax({
      url: "./controller/accountController.php",
      type: "POST",
      data: { func: "getAllTaiKhoan" },
      dataType: "json",
    });
    console.log("fetch",response)
    return response;
  } catch (error) {
    console.log("Lỗi khi fetch danh sách tài khoản", error.responseText);
    return null;
  }
}
async function getAllDoiTuong() {
  try {
    const response = await $.ajax({
      url: "./controller/loaiDoiTuongController.php",
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
async function loadAllTaiKhoan() {
  const tkList = await getAllTaiKhoan();
  if (tkList) {
    console.log(tkList);
    $("#account-list").empty();
    tkList.forEach((item) => {
      const isActive = Number(item.status) == 1;
      const statusBadge =
        Number(item.status) == 1
          ? '<span class="badge badge-soft badge-success" style="margin-left: -120px">Đang hoạt động</span>'
          : '<span class="badge badge-soft badge-error" style="margin-left: -120px">Đã khóa</span>';
      console.log(`Account ${item.tk_id} status:`, item.status);
      $("#account-list").append(`
        <tr>
          <td>${item.tk_id}</td>
          <td>${item.username}</td>
          <td>${item.ten_quyen}</td>
          <td class="text-center">
            ${statusBadge}
          </td>
          <td>
            <button class="btn btn-circle btn-text btn-sm action-item edit-account hidden" data-act="tk-edit" data-id="${item.tk_id}" aria-label="Sửa tài khoản">
              <span class="icon-[tabler--pencil] size-5"></span>
            </button>
            <button class="btn btn-circle btn-text btn-sm action-item delete-account hidden" id="tk-xoa" data-id="${item.tk_id}" aria-label="Xoá tài khoản">
              <span class="icon-[tabler--trash] size-5"></span>
            </button>
          </td>
        </tr>
      `);
    });
    window.AppState.applyPermissionControl();
  }
}
async function loadAllDoiTuong() {
  const response = await getAllDoiTuong();
  $("#select-doituong").empty();
  $("#select-doituong").append(
    `<option value="-1">--Chọn đối tượng--</option>`
  );
  if (response) {
    response.forEach((item) => {
      $("#select-doituong").append(
        `<option value="${item.dt_id}">${item.ten_dt}</option>`
      );
    });
  }
}
async function loadAllQuyen() {
  const response = await getAllQuyen();
  console.log(response);
  $("#select-quyen").empty();
  $("#select-quyen").append(` <option value="-1">--Chọn quyền--</option>`);
  if (response) {
    response.forEach((item) => {
      $("#select-quyen").append(
        `<option value="${item.quyen_id}">${item.ten_quyen}</option>`
      );
    });
  }
}
function create() {
  const username = $("#username").val();
  const password = $("#password").val();
  const dt_id = $("#ma-doi-tuong").val();
  const quyen_id = $("#select-quyen").val();
  const status = $("#select-status").val();
  console.log(username, password, dt_id, quyen_id, status)
  $.ajax({
    url: "./controller/accountController.php",
    type: "POST",
    dataType: "json",
    data: {
        func: "create",
        username: username,
        password: password,
        dt_id: dt_id,
        quyen_id: quyen_id,
        status: status,
    },
    success: function (response) {
      console.log(response)
        if (response && response.status === true) {
            Swal.fire({
                icon: "success",
                title: "Tạo thành công!",
                showConfirmButton: true,
                timer: 2000,
            });
            navigateTaiKhoanPage()
        } else if (response && response.status === false && response.message) {
            Swal.fire({
                icon: "error",
                title: "Lỗi",
                text: response.message, // Display the server-sent error message
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Lỗi",
                text: "Đã có lỗi xảy ra!", // Generic error message if no specific message from server
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
function update() {
  $.ajax({
    url: "./controller/accountController.php",
    type: "GET",
    dataType: "json",
    data: {
      func: "update",
      tk_id: tk_id,
      username: username,
      passowrd: passowrd,
      dt_id: dt_id,
      quyen_id: quyen_id,
      status: status,
    },
    success: function (response) {},
    error: function (error) {
      console.error("Error loading form sua:", error);
    },
  });
}
$(document).ready(function () {
  loadAllTaiKhoan();
  loadAllDoiTuong();
  loadAllQuyen();

  $("#account-list").on("click", ".action-sua", function (event) {
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
    if ($("#username").val() === "") {
      Swal.fire({
        icon: "error",
        title: "Lỗi",
        text: "Username không được để trống!",
      });noSpaceValidation
    } else if ( /\s/.test($("#username").val()) == true) {
      Swal.fire({
        icon: "error",
        title: "Lỗi",
        text: "Tên tài khoản không được có khoản cách",
      });
    }else if ($("#password").val() === "") {
      Swal.fire({
        icon: "error",
        title: "Lỗi",
        text: "Password không được để trống!",
      });
    } else if ($("#ma-doi-tuong").val() == -1) {
      Swal.fire({
        icon: "error",
        title: "Lỗi",
        text: "Bạn quên chọn đối tượng rồi kìa!",
      });
    } else if ($("#select-quyen").val() == -1) {
      Swal.fire({
        icon: "error",
        title: "Lỗi",
        text: "Bạn quên chọn quyền rồi kìa!",
      });
    } else {
      create();
    }
  });
});
$(document).on("click", '[id="tk-xoa"]', function () {
  const tk_id = $(this).data("id");

  Swal.fire({
    title: "Bạn có chắc chắn muốn xóa tài khoản?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Xóa",
    cancelButtonText: "Hủy",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "./controller/accountController.php",
        type: "POST",
        dataType: "json",
        data: {
          func: "softDeleteAccount",
          tk_id: tk_id,
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
function navigateTaiKhoanPage() {
  window.location.href = "./admin.php?page=taiKhoanPage";
}
function navigateDoiTuongPage() {
  window.location.href = "./admin.php?page=doiTuongPage";
}
