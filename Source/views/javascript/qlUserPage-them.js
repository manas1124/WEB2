async function getNhomKs() {
  try {
    const response = await $.ajax({
      url: "./controller/nhomKsController.php",
      type: "GET",
      data: { func: "getAllNhomKs" },
      dataType: "json",
    });
    console.log("fect", response);
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
      data: { func: "getUserById", id: id },
      dataType: "json",
    });
    return response;
  } catch (error) {
    console.log("Lỗi khi lấy dữ liệu người dùng", error);
    return null;
  }
}
async function getAllCTDT() {
  try {
    const response = await $.ajax({
      url: "./controller/CTDTController.php",
      type: "GET",
      data: { func: "getAll" },
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
async function addUser(data) {
  try {
    const response = await $.ajax({
      url: "./controller/UserController.php",
      type: "POST",
      data: { func: "addUser", data: JSON.stringify(data) },
      dataType: "json",
    });
    if (response.error) {
      console.log("fect", response.error);
    }
    console.log("fect", response);
    return response;
  } catch (error) {
    console.log(error);
    console.log("loi  tao khao sat");
    return false;
  }
}
$(function () {
  window.HSStaticMethods.autoInit();
  (async () => {
    const urlParams = new URLSearchParams(window.location.search);

    const currentuserId = urlParams.get('id');
    const defaultData = await getUserById(currentuserId);
    const nhomKsList = await getNhomKs();
    const LoaidtList = await getAllLoaidt();
    const ctdtList = await getAllCTDT();

    if (LoaidtList != null) {
      LoaidtList.map((item) => {
        $("#loai-doituong").append(
          `<option value='${item.dt_id}'>${item.ten_dt}</option>`
        )
      });
    }
    if (nhomKsList != null) {
      nhomKsList.map((item) => {
        $("#nhom-ks").append(
          `<option value='${item.nks_id}'>${item.ten_nks}</option>`
        )
      })
    }

    if (ctdtList != null) {
      ctdtList.map((item) => {
        $("#ctdt").append(
          `<option value='${item.ctdt_id}'>${item.ten_nganh} - ${item.ten_ck}</option>`
        );
      });
    }
    function validateData() {
      let isValid = true;


      $(".error-msg").remove();


      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


      const phoneRegex = /^[0-9]{10,11}$/;



      const email = $("#email").val().trim();

      const dienThoai = $("#dien_thoai").val().trim();


      if (email !== "" && !emailRegex.test(email)) {
        $("#email").after(`<span class='error-msg' style='color:red'>Email không hợp lệ.</span>`);
        isValid = false;
      }

      if (dienThoai !== "" && !phoneRegex.test(dienThoai)) {
        $("#dien_thoai").after(`<span class='error-msg' style='color:red'>Số điện thoại không hợp lệ (10-11 số).</span>`);
        isValid = false;
      }

      return isValid;
    }
    function validate(data) {
      let message = '';

      // Kiểm tra họ tên
      if (!data.ho_ten || data.ho_ten.trim() === '') {
        message = "Họ tên không được để trống!";
      } else if (/[^a-zA-ZÀ-Ỹà-ỹ\s]/.test(data.ho_ten.trim())) {
        message = "Họ tên không được chứa số hoặc ký tự đặc biệt!";
      }

      // Kiểm tra email
      else if (!data.email || data.email.trim() === '') {
        message = "Email không được để trống!";
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email.trim())) {
        message = "Email không đúng định dạng!";
      }

      // Kiểm tra địa chỉ
      else if (!data.diachi || data.diachi.trim() === '') {
        message = "Địa chỉ không được để trống!";
      } else if (/[^\p{L}\p{N}\s,.-]/u.test(data.diachi.trim())) {
        message = "Địa chỉ không được chứa ký tự đặc biệt!";
      }

      // Kiểm tra điện thoại
      else if (!data.dien_thoai || data.dien_thoai.trim() === '') {
        message = "Số điện thoại không được để trống!";
      } else if (!/^0\d{9}$/.test(data.dien_thoai.trim())) {
        message = "Số điện thoại phải có 10 chữ số và bắt đầu bằng 0!";
      }

      // Nếu có lỗi, hiển thị cảnh báo
      if (message !== '') {
        Swal.fire({
          title: 'Thông báo',
          text: message,
          icon: 'warning',
          confirmButtonText: 'Thử lại'
        });
        return false;
      }

      return true;
    }
    $("#btn-save-doituong").click(async function () {
      if (!validateData()) {
        return;
      }
      const data = {
        ho_ten: $("#ho_ten").val(),
        email: $("#email").val(),
        diachi: $("#diachi").val(),
        dien_thoai: $("#dien_thoai").val(),
        nhom_ks: $("#nhom-ks").val(),
        loai_dt_id: $("#loai-doituong").val(),
        ctdt_id: $("#ctdt").val()
      };

      if (validate(data)) {
        const result = await addUser(data);


        if (result && result.success) {
          Swal.fire({
                    title: 'Thêm đối tượng thành công',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Tiếp tục',
                    confirmButtonColor: '#3085d6'
                }).then((res) => {
                      if (res.isConfirmed) {
                        window.location.href = "./admin.php?page=qlUserPage";
                      }

                    });
        } else {
          Swal.fire({
                    title: 'Thêm đối tượng thất bại!',
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Thử lại',
                });
        }
      }

    });



  })();
});
