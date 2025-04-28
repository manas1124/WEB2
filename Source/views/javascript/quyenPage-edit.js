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
async function updateQuyen(quyenData) {
  if (!validateAccountData(quyenData)) {
    Swal.fire(
      "Thiếu dữ liệu",
      "Vui lòng kiểm tra lại các trường bắt buộc",
      "warning"
    );
    return false;
  }

  try {
    const formData = new FormData();
    formData.append("func", "updateAccount");

    // Gửi từng field riêng biệt thay vì stringify JSON
    for (const key in quyenData) {
      formData.append(key, quyenData[key]);
    }

    const response = await $.ajax({
      url: "./controller/quyenController.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
    });

    if (response.status) {
      Swal.fire("Thành công", response.message, "success");
    } else {
      Swal.fire("Thất bại", response.message, "error");
    }

    return response;
  } catch (error) {
    console.error("AJAX Error:", error);
    Swal.fire("Lỗi hệ thống", "Không thể cập nhật tài khoản", "error");
    return false;
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
async function getChiTietQuyenById(id) {
  try {
    const response = await $.ajax({
      url: "./controller/quyenController.php",
      type: "POST",
      data: { func: "getChiTietQuyenById", tk_id: tk_id },
      dataType: "json",
    });
    console.log("fect", response);
    return response;
  } catch (e) {
    console.log(e);
    console.log("loi fetchdata");
    return null;
  }
}
async function checkExistQuyen(ten_quyen) {
  console.log("Kiểm tra tồn tại của input username:", ten_quyen);
  try {
    const response = await $.ajax({
      url: "./controller/quyenController.php",
      type: "POST",
      data: {
        func: "checkExistQuyen",
        data: JSON.stringify({
          ten_quyen: ten_quyen,
        }),
      },
    });
    return response; // return true nếu tồn tại, false nếu chưa
  } catch (e) {
    console.log("Lỗi khi kiểm tra tài khoản:", e);
    return false;
  }
}
function validateAccountData(data) {
  const requiredFields = ["quyen_id", "name-quyen"];
  for (const field of requiredFields) {
    if (!data[field]) {
      console.error(`Thiếu trường ${field}`);
      return false;
    }
  }
  return true;
}
$(function () {
  (async () => {
    try {
      const urlParams = new URLSearchParams(window.location.search);
      const currentQuyenId = urlParams.get("id");
      if (!currentQuyenId) {
        console.error("No permission ID found in URL.");
        return;
      }
      const defaultData = await getChiTietQuyenById(currentQuyenId);
      if (!defaultData) {
        console.error("No permission data found for ID:", currentQuyenId);
        return;
      }

      const quyenList = await getAllQuyen();
      if (!quyenList || quyenList.length === 0) {
        console.error("Failed to fetch permission list.");
        return;
      }

      $("#select-quyen").empty(); // Always clear first
      quyenList.forEach((item) => {
        const isSelected =
          item.quyen_id == defaultData.quyen_id ? "selected" : "";
        $("#select-quyen").append(
          `<option value='${item.quyen_id}' ${isSelected}>${item.ten_quyen}</option>`
        );
      });

      $("#quyen_id").val(defaultData.quyen_id);
      $("#ten_quyen").val(defaultData.ten_quyen);
    } catch (error) {
      console.error("An error occurred while loading permission data:", error);
    }
  })();

  const submitChangeQuyen = document.getElementById("btn-save-quyen");
  submitChangeQuyen.addEventListener("click", async () => {
    const tenQuyen = $("#ten_quyen").val().trim();

    const urlParams = new URLSearchParams(window.location.search);
    let currentQuyenId = urlParams.get("id");
    if (!currentQuyenId) {
      currentQuyenId = $("#quyen_id").val(); // fallback
    }
    console.log("Current Permission ID:", currentQuyenId);

    const isValidData = () => {
      if (!tenQuyen) {
        alert("Vui lòng nhập tên quyền");
        return false;
      }
      return true;
    };

    const updateData = {
      quyen_id: currentQuyenId,
      ten_quyen: tenQuyen,
    };

    console.log(updateData); // Debug dữ liệu gửi đi

    if (isValidData()) {
      const response = await updateQuyen(updateData);
      if (response) {
        alert("Cập nhật quyền thành công!");
      } else {
        alert("Cập nhật quyền thất bại.");
      }
    }
  });
});
