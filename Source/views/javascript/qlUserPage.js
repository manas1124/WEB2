window.HSStaticMethods.autoInit(); // Phải dùng câu lệnh này để dùng lại JS component

async function getAllUser(search = "", nhomKsId = "", page = 1) {
  try {
    const response = await $.ajax({
      url: "./controller/UserController.php",
      type: "POST",
      data: {
        func: "getAllUser",
        search: search,
        nhomKsId: nhomKsId,
        pageNumber: page,
      }, // Gửi từ khóa tìm kiếm
      dataType: "json",
    });

    return response;
  } catch (error) {
    console.log("Lỗi khi lấy dữ liệu từ getAllUser", error);
    return null;
  }
}
async function getUserByPageNumber(
  search = null,
  nhomKsId = null,
  chuKyId = null,
  nganhId = null,
  page = 1
) {
  try {
    console.log("data send: ", search, nhomKsId, chuKyId, nganhId, page);
    const response = await $.ajax({
      url: "./controller/UserController.php",
      type: "POST",
      data: {
        func: "getUserByPageNumber",
        search: search,
        nhomKsId: nhomKsId,
        chuKyId: chuKyId,
        nganhId: nganhId,
        pageNumber: page,
      },
      dataType: "json",
    });
    console.log("fect users: ", response);
    return {
      userList: response.userList,
      totalPages: response.totalPages,
      currentPage: response.currentPage,
    };
  } catch (error) {
    console.log("Lỗi khi lấy dữ liệu từ getAllUser", error);
    return null;
  }
}
async function renderUser({
  search = null,
  nhomKsId = null,
  chuKyId = null,
  nganhId = null,
  page = 1,
}) {
  const res = await getUserByPageNumber(
    search,
    nhomKsId,
    chuKyId,
    nganhId,
    page
  );

  if (res) {
    const { userList, totalPages, currentPage } = res;

    $("#user-list").empty();
    $("#pagination").empty();
    ///test

    if (userList != null) {
      userList.map((item) => {
        $("#user-list").append(`
            <tr>
              <td>${item.ho_ten}</td>
              <td>${item.email}</td>
              <td>${item.diachi}</td>
              <td>${item.dien_thoai}</td>
              <td>
                ${
                  item.loai_dt_id == 1
                    ? '<span class="badge badge-soft badge-success">Sinh viên</span>'
                    : item.loai_dt_id == 2
                    ? '<span class="badge badge-soft badge-warning">Giảng viên</span>'
                    : item.loai_dt_id == 3
                    ? '<span class="badge badge-soft badge-danger">Doanh nghiệp</span>'
                    : '<span class="badge badge-soft badge-secondary">Không rõ</span>'
                }
              </td> 
              <td>${item.ten_nks ?? "Không rõ"}</td>
              <td>
                <button class="action-item btn btn-circle btn-text btn-sm edit-target hidden" data-act="user-sua" aria-label="Action button" data-id="${
                  item.dt_id
                }">
                  <span class="icon-[tabler--pencil] size-5"></span>
                </button>
                <button onclick="deleteUser(${
                  item.dt_id
                })" class="btn btn-circle btn-text btn-sm delete-target hidden" aria-label="Action button">
                  <span class="icon-[tabler--trash] size-5"></span>
                </button>
              </td>
            </tr>
          `);
      });
      window.AppState.applyPermissionControl();
    } else {
      $("#user-list").append("<tr>Không có dữ liệu</tr>");
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
async function getNhomKs() {
  try {
    const response = await $.ajax({
      url: "./controller/nhomKsController.php",
      type: "GET",
      data: { func: "getAllNhomKs" },
      dataType: "json",
    });
    // console.log("fect", response);
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function getAllLoaidt() {
  try {
    const response = await $.ajax({
      url: "./controller/LoaidtController.php",
      type: "GET",
      data: { func: "getAllLoaidt" },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function getUserById(id) {
  try {
    const response = await $.ajax({
      url: "./controller/UserController.php",
      type: "POST",
      data: JSON.stringify({ func: "getUserById", data: { dt_id: 1 } }),
      dataType: "json",
    });
    return { data: response, error: null };
  } catch (error) {
    console.log("Lỗi khi lấy dữ liệu người dùng", error);
    return null;
  }
}

async function deleteUser(id) {
  Swal.fire({
    title: 'Bạn có chắc chắn muốn xóa đối tượng?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Có, xóa ngay',
    cancelButtonText: 'Không',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33'
  }).then( async (result) => {
    if (result.isConfirmed) {
      console.log("Deleting user with ID:", id);
      try {
        const response = await $.ajax({
          url: "./controller/UserController.php",
          type: "POST",
          data: { func: "deleteUser", id: id },
          dataType: "json",
        });

        if (response.success) {
          Swal.fire({
                    title: 'Thông báo',
                    text: 'Xóa thất bại',
                    icon: 'error',
                    confirmButtonText: 'Thử lại'
                  });
        } else {
          Swal.fire({
                    title: 'Thông báo',
                    text: 'Xóa thành công!',
                    icon: 'success',
                    confirmButtonText: 'Tiếp tục'
                  });
          loadUserList();
        }
      } catch (error) {
        console.log("Lỗi khi xóa người dùng");
      }
    }
  });


}

async function loadNhomKsToSelect() {
  const nhomKsList = await getNhomKs();
  const selectElement = $("#nhom-ks-select");

  selectElement.empty();
  selectElement.append('<option value="">Tất cả</option>');
  if (nhomKsList != null) {
    nhomKsList.map((item) => {
      selectElement.append(`
          <option value="${item.nks_id}">${item.ten_nks}</option>
        `);
    });
  } else {
    selectElement.append('<option value="">Không có nhóm khảo sát</option>');
  }
}

async function loadNhomKsToSelectModal() {
  const nhomKsList = await getNhomKs();
  const selectElement = $("#nhom-ks-select-modal");

  selectElement.empty();
  selectElement.append('<option value="">Tất cả</option>');
  if (nhomKsList != null) {
    nhomKsList.map((item) => {
      selectElement.append(`
        <option value="${item.nks_id}">${item.ten_nks}</option>
      `);
    });
  } else {
    selectElement.append('<option value="">Không có nhóm khảo sát</option>');
  }
  const nganhList = await getAllNganh();
  const chuKiList = await getAllChuKi();
  if (nganhList != null) {
    nganhList.map((item) => {
      $("#select-nganh").append(
        `<option value='${item.nganh_id}'>${item.ten_nganh}</option>`
      );
    });
  }
  if (chuKiList != null) {
    chuKiList.map((item) => {
      $("#select-chu-ki").append(
        `<option value='${item.ck_id}'>${item.ten_ck}</option>`
      );
    });
  }
}

// function loadUserList() {

//   const searchKeyword = $("#search").val();
//   getAllUser(searchKeyword).then((ksList) => {
//     $("#user-list").empty(); // Xóa dữ liệu cũ trong bảng
//     if (ksList != null) {
//       ksList.map((item) => {
//         $("#user-list").append(`
//           <tr>
//             <td>${item.ho_ten}</td>
//             <td>${item.email}</td>
//             <td>${item.diachi}</td>
//             <td>${item.dien_thoai}</td>
//             <td>
//               ${item.loai_dt_id == 1
//                 ? '<span class="badge badge-soft badge-success">Sinh viên</span>'
//                 : item.loai_dt_id == 2
//                 ? '<span class="badge badge-soft badge-warning">Giảng viên</span>'
//                 : item.loai_dt_id == 3
//                 ? '<span class="badge badge-soft badge-danger">Doanh nghiệp</span>'
//                 : '<span class="badge badge-soft badge-secondary">Không rõ</span>'
//               }
//             </td>
//               <td>${item.ten_nks ?? "Không rõ"}</td>
//             <td>
//               <button class="action-item btn btn-circle btn-text btn-sm "data-act="user-sua" aria-label="Action button " data-id="${item.dt_id}" >
//               <span class="icon-[tabler--pencil] size-5"></span>
//               </button>
//               <button onclick="deleteUser(${item.dt_id})" class="btn btn-circle btn-text btn-sm" aria-label="Action button" >
//               <span class="icon-[tabler--trash] size-5"></span>
//               </button>

//             </td>
//           </tr>
//         `);
//       });
//     }
//   });
// }
async function loadUserList() {
  const searchKeyword = $("#search").val();
  const nhomKsId = $("#nhom-ks-select").val();

  console.log("Search:", searchKeyword);
  console.log("Nhóm khảo sát ID:", nhomKsId);

}

$(function () {
  renderUser({});
  // loadUserList();
  loadNhomKsToSelect();
  loadNhomKsToSelectModal();

  $("#form-send-mail").on("submit", function (e) {
    e.preventDefault(); 
    const objectSelect = $("#nhom-ks-select-modal").val();
    const subject = $("input[name='subject-text']").val();
    const body = $("textarea[name='body-text']").val();
    const file = $("#file-attachment")[0].files[0]; 
    console.log(objectSelect, subject, body, file);
    const formData = new FormData();
    formData.append("objectSelect", objectSelect);
    formData.append("subject", subject);
    formData.append("body", body);
    formData.append("attachment", file);
    formData.append("func", "sendMail");

    console.log(formData);

    $.ajax({
      url: "./controller/UserController.php",
      method: "POST",
      dataType: "json",
      data: formData,
      processData: false,
      contentType: false, 

      success: function (response) {
        const data = JSON.parse(response);
        if (data.status === "success") {
          Swal.fire({
            title: 'Thành công',
            text: "Bạn đã gửi khảo sát thành công.",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
          });
          $("#slide-down-animated-modal").addClass("hidden");
        }
        else {
          Swal.fire({
            title: 'Thất bại',
            text: "Bạn đã gửi khảo sát không thành công.",
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Thử lại',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
          });
        }
      },
      error: function (err) {
        Swal.fire({
                        title: 'Thất bại',
                        text: "Bạn đã gửi khảo sát không thành công.",
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonText: 'Thử lại',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                        
                    });
      },
    });
  });



  $("#btn-search").on("click", function () {
    console.log("execute search user: ");
    let search = $("#search").val();
    let nhomKsId = $("#nhom-ks-select").val();
    let chuKyId =
      $("#select-chu-ki").val() != -1 ? $("#select-chu-ki").val() : null;
    let nganhId =
      $("#select-nganh").val() != -1 ? $("#select-nganh").val() : null;
    renderUser({
      search: search,
      nhomKsId: nhomKsId,
      chuKyId: chuKyId,
      nganhId: nganhId,
    });
  });
  $("#btn-reset").on("click", function () {
    $("#search").val("");
    $("#nhom-ks-select").val(-1); // Sets it to the first option
    $("#select-chu-ki").val(-1);
    $("#select-nganh").val(-1);
    resetSearchForm();
  });
  $("#download-excel-templat").on("click", function () {
    window.location.href = "./assets/sample_user.xlsx";
  });
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
    renderUser({ page: selectedPage });
  });

  $("#pagination").on("click", ".btn-prev", function () {
    let currentPage = Number(
      $("#pagination button[aria-current='page']").data("page")
    );
    if (currentPage == 1) {
      return;
    }
    currentPage -= 1;
    renderUser({ page: currentPage });
  });

  $("#pagination").on("click", ".btn-next", function () {
    let currentPage = Number(
      $("#pagination button[aria-current='page']").data("page")
    );
    console.log("pre", currentPage, "max",$("#pagination .btn-page").length);
    if (currentPage == $("#pagination .btn-page").length) {
      return;
    }
    currentPage += 1;
    renderUser({ page: currentPage });
  });

  $("#input-file-excel").on("change", function () {
    const file = this.files[0];
    if (!file) return;

    const allowedExtensions = ["xlsx", "xls"];
    const fileExtension = file.name.split(".").pop().toLowerCase();
    if (!allowedExtensions.includes(fileExtension)) {
      alert("Chỉ chấp nhận file Excel (.xlsx hoặc .xls)");
      return;
    }

    // Gửi file lên server qua Ajax
    const formData = new FormData();
    formData.append("func", "importExcel");
    formData.append("file", file);

    $.ajax({
      url: "./controller/UserController.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        // Có thể thêm hiệu ứng loading tại đây
        console.log("Đang gửi file lên server...");
      },
      success: function (res) {
        let response;
        try {
          response = JSON.parse(res);
        } catch (e) {
          alert("Phản hồi từ server không hợp lệ.");
          return;
        }

        if (response.success) {
          alert("Import thành công!");
          loadUserList(); // Reload danh sách user
          $("#input-file-excel").val(""); // Reset input file
        } else {
          alert(
            "Import thất bại: " + (response.message || "Lỗi không xác định")
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Lỗi khi gửi file:", error);
        alert("Có lỗi xảy ra khi gửi file.");
      },
    });
  });

  $(".main-content").on("click", ".action-item", function (e) {
    e.preventDefault();
    let action = $(this).data("act");
    let id = $(this).data("id");
    console.log("Action:", action, "ID:", id);
  });
});

async function getAllNganh() {
  try {
    const response = await $.ajax({
      url: "./controller/nganhController.php",
      type: "GET",
      data: { func: "getAll" },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    console.log("fect nganh", response);
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
async function getAllChuKi() {
  try {
    const response = await $.ajax({
      url: "./controller/chuKiController.php",
      type: "GET",
      data: { func: "getAllChuKi" },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi fetchdata getAllKhaoSat 1");
    return null;
  }
}
