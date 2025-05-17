async function getCurrentLoginAcount() {
  try {
    const response = await $.ajax({
      url: "./controller/AuthController.php",
      type: "POST",
      dataType: "json",
      data: { func: "getCurrentLoginUser" },
    });
    if (response.status == "error") {
       Swal.fire({
        title: 'Thất bại',
        text: response.message,
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });
      
      return null;
    }
    console.log("return user data", response);
    return response.userInfor;
  } catch (error) {
    console.error(error);
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
    console.log(" Phản hồi getUserById:", response.data);
    return response.data;
  } catch (error) {
    console.log("Lỗi khi lấy dữ liệu người dùng", error);
    return null;
  }
}
async function renderPage() {
  const account = await getCurrentLoginAcount();
  if (account == null) {
    window.location.href = "/Source/login.php";
    return;
  }
  const user = await getUserById(account.dtId);
  console.log(account, user);

  $("#hoten").val(user.ho_ten);
  $("#email").val(user.email);
  $("#address").val(user.diachi);
  $("#target").val(user.ten_dt);
  $("#phone").val(user.dien_thoai);

  $("#submit-edit-account").on("click", () =>
    submitEditAccount(account.userId,account.sub)
  );
}
$(function () {
  console.log("resr")
  backNormal();
  renderPage();
  $("#submit-edit-infor").on("click", submitEditPersonal);
})();
function submitEditAccount(tk_id,username) {
  var previousPassword = $("#previousPassword").val();
  var password = $("#password").val();
  var confirmPassword = $("#confirm-pass").val();

  if (previousPassword === "") {
    Swal.fire({
        title: 'Thất bại',
        text: 'Vui lòng nhập mật khẩu cũ.',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });
    // alert("Vui lòng nhập mật khẩu cũ.");
    return false;
  }
  if (password === "") {
    Swal.fire({
        title: 'Thất bại',
        text: 'Vui lòng nhập mật khẩu.',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });
    // alert("Vui lòng nhập mật khẩu.");
    return false;
  }
  if (confirmPassword === "") {
    Swal.fire({
        title: 'Thất bại',
        text: 'Vui lòng xác nhận mật khẩu.',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });
    // alert("Vui lòng xác nhận mật khẩu.");
    return false;
  }
  if (password !== confirmPassword) {
    Swal.fire({
        title: 'Thất bại',
        text: response.message,
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });
    alert("Mật khẩu không khớp.");
    return false;
  }
  console.log(username,previousPassword)
  $.ajax({
    type: "POST",
    url: "./controller/AuthController.php",
    data: {
      action: "updateAccount",
      username: username,
      tk_id: tk_id,
      previousPassword: previousPassword,
      password: password,
    },
    success: function (response) {
      console.log(response);
      var data = JSON.parse(response);
      Swal.fire({
        title: 'Thất bại',
        text: data["message"],
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });
      // alert(data["message"]); // Show the message from the server
    },
    error: function () {

      alert("Có lỗi xảy ra khi gửi dữ liệu!");
    },
  });
}
function submitEditPersonal() {
  const hoTen = $("#hoten").val().trim();
  const email = $("#email").val().trim();
  const diaChi = $("#address").val().trim();
  const dienThoai = $("#phone").val().trim();

  if (!hoTen || !email || !diaChi || !dienThoai) {
    Swal.fire({
        title: 'Thất bại',
        text: "Vui lòng nhập đầy đủ thông tin.",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });
    return;
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    Swal.fire({
        title: 'Thất bại',
        text: "Email không hợp lệ.",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });

    return;
  }

  const phoneRegex = /^[0-9\-\+]{9,15}$/;
  if (!phoneRegex.test(dienThoai)) {
     Swal.fire({
        title: 'Thất bại',
        text: "Số điện thoại không hợp lệ.",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });

    return;
  }

  $("#submit-edit-infor").prop("disabled", true); // Ngăn gửi lại

  $.ajax({
    url: "./controller/AuthController.php",
    type: "POST",
    dataType: "json",
    data: {
      func: "updatePersonalInfor",
      ho_ten: hoTen,
      email: email,
      dien_thoai: dienThoai,
      diachi: diaChi,
    },
    success: function (response) {
       Swal.fire({
        title: 'Thất bại',
        text:response.message,
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });

      if (response.status === "success") {
        if (typeof backNormal === "function") {
          backNormal();
        }
      }
    },
    error: function (xhr) {
       Swal.fire({
        title: 'Thất bại',
        text: "Đã xảy ra lỗi khi gửi yêu cầu.",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Thử lại',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });
   
      console.error("Lỗi server:", xhr.responseText);
    },
    complete: function () {
      $("#submit-edit-infor").prop("disabled", false);
    },
  });
}

function toggleEditInfor() {
  $("#submit-edit-infor").removeClass("hidden");
  $(".edit-infor").removeAttr("disabled");
  $("#btn-exit-edit").removeClass("hidden");
  $("#btn-edit-account").addClass("hidden");
  $("#btn-edit-infor").addClass("hidden");
}

function toggleEditAcc() {
  $(".edit-infor").addClass("hidden");
  $(".edit-account").removeClass("hidden");
  $("#btn-exit-edit").removeClass("hidden");
  $("#btn-edit-account").addClass("hidden");
  $("#btn-edit-infor").addClass("hidden");
}

function backNormal() {
  $(".edit-infor").removeClass("hidden");
  $(".edit-infor input").attr("disabled", "disabled");
  $("#submit-edit-infor").addClass("hidden");

  $(".edit-account").addClass("hidden");
  $("#btn-exit-edit").addClass("hidden");
  $("#btn-edit-account").removeClass("hidden");
  $("#btn-edit-infor").removeClass("hidden");
}
