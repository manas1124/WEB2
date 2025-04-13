window.HSStaticMethods.autoInit(); // phải dùng câu lệnh này để dùng lại js component

async function getAllTaiKhoan() {
  try {
    const response = await $.ajax({
      url: "./controller/accountController.php",
      type: "POST",
      data: { func: "getAllTaiKhoan" },
      dataType: "json",
    });
    return response;
  } catch (error) {
    console.log("Lỗi khi fetch danh sách tài khoản", error);
    return null;
  }
}

$(function () {
  (async () => {
    let tkList = await getAllTaiKhoan();
    if (tkList != null) {
      tkList.forEach((item) => {
        $("#account-list").append(`
            <tr>
              <td>${item.tk_id}</td>
              <td>${item.username}</td>
              <td>${item.dt_id}</td>
              <td>${item.quyen_id}</td>
              <td class="text-center">
                ${
                  item.status == 1
                    ? '<span class="badge badge-soft badge-success " style="margin-left: -120px">Đang hoạt động</span>'
                    : '<span class="badge badge-soft badge-error" style="margin-left: -120px">Ngừng hoạt động</span>'
                }
              </td>
              <td>
                <button class="btn btn-circle btn-text btn-sm action-item" data-act="tk-sua" data-id="${
                  item.tk_id
                }" aria-label="Sửa tài khoản">
                  <span class="icon-[tabler--pencil] size-5"></span>
                </button>
                <button class="btn btn-circle btn-text btn-sm action-item" data-act="tk-xoa" data-id="${
                  item.tk_id
                }" aria-label="Xoá tài khoản">
                  <span class="icon-[tabler--trash] size-5"></span>
                </button>
              </td>
            </tr>
          `);
      });
    }
  })();

  $(".main-content").on("click", ".action-item", function (e) {
    e.preventDefault();
    const action = $(this).data("act");
    const id = $(this).data("id");
    console.log("Action:", action, "ID:", id);
    // TODO: Load trang sửa hoặc xác nhận xoá dựa trên action
  });
});
