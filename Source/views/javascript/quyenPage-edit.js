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
async function updateQuyen(formData) {
  try {
    formData.append("func", "updateQuyen");
    const response = await $.ajax({
      url: "./controller/quyenController.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
    });

    return response;
  } catch (error) {
    console.error("AJAX Error:", error);
    Swal.fire("Lỗi hệ thống", "Không thể cập nhật quyền", "error");
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

async function getChucNangAndQuyenByQuyenId(quyen_id) {
  try {
    const response = await $.ajax({
      url: "./controller/quyenController.php",
      type: "POST",
      data: { func: "getChucNangAndQuyenByQuyenId", quyen_id: quyen_id },
      dataType: "json",
    });

    console.log("Fetch Response:", response);

    const { status, message, dataQuyen, dataChucNang } = response || {};

    if (status === true) {
      return { status, message, dataQuyen, dataChucNang };
    } else {
      console.error(
        "Failed to fetch quyền information:",
        message || "Unknown error"
      );
      return {
        status: false,
        message: message || "Failed to fetch quyền information",
        dataQuyen: null,
        dataChucNang: null,
      };
    }
  } catch (error) {
    console.error("AJAX Error:", error);
    return {
      status: false,
      message: "Lỗi kết nối hoặc lỗi server",
      dataQuyen: null,
      dataChucNang: null,
    };
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
      const { dataChucNang, dataQuyen } = await getChucNangAndQuyenByQuyenId(
        currentQuyenId
      );
      if (!dataChucNang || !dataQuyen) {
        console.error("lỗi lấy data quyền hiện tại");
        return;
      }
      console.log(dataQuyen);
      $("#ten-quyen").val(dataQuyen.ten_quyen);

      dataChucNang.forEach((item) => {
        const ten_cn_value = item.ten_cn;
        const status = item.status;
        $(
          '#checkbox-data input[type="checkbox"][value="' + ten_cn_value + '"]'
        ).prop("checked", status === 1);
      });
    } catch (error) {
      console.error("An error occurred while loading permission data:", error);
    }
  })();

  const submitChangeQuyen = $("#btn-save");

  submitChangeQuyen.on("click", async () => {
    const tenQuyen = $("#ten-quyen").val();
    const status = $("#select-status").val();
    const selectedChucNang = $("#checkbox-data tr")
      .find('input[type="checkbox"]:checked')
      .map(function () {
        return $(this).val();
      })
      .get();

    const urlParams = new URLSearchParams(window.location.search);
    const currentQuyenId = urlParams.get("id") || $("#quyen_id").val();
    console.log("Current Permission ID:", currentQuyenId);

    const isValidData = () => {
      if (!tenQuyen) {
        Swal.fire("Lỗi", "Vui lòng nhập tên quyền", "warning");
        return false;
      }
      return true;
    };

    if (isValidData()) {
      // const selectedChucNang = ["as", "ab"];
      const formData = new FormData();
      formData.append("quyen_id", currentQuyenId);
      formData.append("ten_quyen", tenQuyen);
      console.log("chuc nang da chon:", selectedChucNang);
      selectedChucNang.forEach(function (chucNang) {
        formData.append("selectedChucNang[]", chucNang);
      });

      console.log(
        "FormData - selectedChucNang[] values:",
        formData.getAll("selectedChucNang[]")
      );

      const response = await updateQuyen(formData);
      if (response && response.status) {
        Swal.fire("Thành công", "Cập nhật quyền thành công!", "success");
      } else {
        Swal.fire("Thất bại", "Cập nhật quyền thất bại.", "error");
        console.log(response.message);
      }
    }
  });
});
$("#return-page").on("click", function () {
  $("#quyen-page").trigger("click");
});