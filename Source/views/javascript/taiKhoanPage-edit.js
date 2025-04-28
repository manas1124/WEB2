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
async function getAllDoiTuong() {
  try {
    const response = await $.ajax({
      url: "./controller/doiTuongController.php",
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
function validateAccountData(data) {
  const requiredFields = ["tk_id", "username", "password", "dt_id", "quyen_id"];
  for (const field of requiredFields) {
    if (!data[field]) {
      console.error(`Thiếu trường ${field}`);
      return false;
    }
  }
  return true;
}
async function updateTaiKhoan(accountData) {
  if (!validateAccountData(accountData)) {
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
    for (const key in accountData) {
      formData.append(key, accountData[key]);
    }

    const response = await $.ajax({
      url: "./controller/accountController.php",
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
async function checkExistAccount(username) {
  console.log("Kiểm tra tồn tại của input username:", username);
  try {
    const response = await $.ajax({
      url: "./controller/accountController.php",
      type: "POST",
      data: {
        func: "checkExistAccount",
        data: JSON.stringify({
          username: username,
        }),
      },
    });
    return response; // return true nếu tồn tại, false nếu chưa
  } catch (e) {
    console.log("Lỗi khi kiểm tra tài khoản:", e);
    return false;
  }
}
async function getChiTietAccountById(id) {
  try {
    const response = await $.ajax({
      url: "./controller/accountController.php",
      type: "POST",
      data: { func: "getChiTietAccountById", id: id },
      dataType: "json",
    });
    console.log("fect", response);
    return response;
  } catch (e) {
    console.log(e);
    console.log("loi fetchdata getChiTietAccountById");
    return null;
  }
}
$(function () {
  window.HSStaticMethods.autoInit();
  (async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const currentAccountId = urlParams.get("id");
    const defaultData = await getChiTietAccountById(currentAccountId);
    const idList = await getAllTaiKhoan();
    const usernameList = await getAllTaiKhoan();
    const passwordList = await getAllTaiKhoan();
    const doiTuongList = await getAllDoiTuong();
    const quyenList = await getAllQuyen();
    // Kiểm tra username/password có trong danh sách không
    const id = idList.map((item) => item.tk_id);
    const usernames = usernameList.map((item) => item.username);
    const passwords = passwordList.map((item) => item.password);
    if (id.includes(defaultData.tk_id)) {
      $("#tk_id").val(defaultData.tk_id);
    }
    if (usernames.includes(defaultData.username)) {
      $("#username").val(defaultData.username);
    }

    if (passwords.includes(defaultData.password)) {
      $("#password").val(defaultData.password);
    }

    $("#select-status").val(defaultData.status);
    if (doiTuongList != null) {
      doiTuongList.forEach((item) => {
        const isSelected = item.dt_id == defaultData.dt_id ? "selected" : "";
        $("#select-doituong").append(
          `<option value='${item.dt_id}' ${isSelected}>${item.dt_id}</option>`
        );
      });
    }
    if (quyenList != null) {
      quyenList.forEach((item) => {
        const isSelected =
          item.ten_quyen == defaultData.ten_quyen ? "selected" : "";
        $("#select-quyen").append(
          `<option value='${item.quyen_id}' ${isSelected}>${item.quyen_id}</option>`
        );
      });
    }

    $("#username").val(defaultData.username);
    $("#password").val(defaultData.password); // Consider hashing or hiding in production
    $("#select-status").val(defaultData.status);
  })();

  // Sự kiện nút lưu tài khoản
  const submitChangeAccount = document.getElementById("btn-save-tk");
  submitChangeAccount.addEventListener("click", async () => {
    const username = $("#username").val().trim();
    const password = $("#password").val().trim();
    const dt_id = $("#select-doituong").val();
    const quyen_id = $("#select-quyen").val();
    const status = $("#select-status").val();

    const urlParams = new URLSearchParams(window.location.search);
    let currentAccountId = urlParams.get("tk_id");
    if (!currentAccountId) {
      currentAccountId = $("#tk_id").val(); // fallback
    }
    console.log("Current Account ID:", currentAccountId);
    const isValidData = () => {
      if (!username) {
        alert("Vui lòng nhập username");
        return false;
      } else if (!password) {
        alert("Vui lòng nhập password");
        return false;
      } else if (dt_id == "-1") {
        alert("Vui lòng chọn đối tượng");
        return false;
      } else if (quyen_id == "-1") {
        alert("Vui lòng chọn quyền");
        return false;
      }
      return true;
    };

    const updateData = {
      tk_id: currentAccountId,
      username: username.trim(),
      password: password.trim(),
      dt_id,
      quyen_id,
      status
    };
    console.log(updateData); // log để debug dữ liệu gửi đi
    if (isValidData()) {
      const response = await updateTaiKhoan(updateData);
      if (response) {
        alert("Cập nhật tài khoản thành công!");
      } else {
        alert("Cập nhật tài khoản thất bại.");
      }
    }
  });
});
