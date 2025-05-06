async function getCurrentLoginAcount() {
  try {
    const response = await $.ajax({
      url: "./controller/AuthController.php",
      type: "POST",
      dataType: "json",
      data: { func: "getCurrentLoginUser" },
    });
    if (response.status == "error") {
      alert(response.message);
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
  const user = await getUserById(account.dtId)
  console.log(account,user)

  $('#hoten').val(user.ho_ten);
  $('#email').val(user.email);
  $('#address').val(user.diachi);
  $('#target').val(user.ten_dt);
  $('#phone').val(user.dien_thoai);

  $("#submit-edit-account").on("click", ()=> submitEditAccount(account.userId));


}
$(function () {
  renderPage();
});
function submitEditPersional() {
  
}
function submitEditAccount(tk_id) {
  var username = $("#username").val();
    var password = $("#password").val();
    var confirmPassword = $("#confirm-pass").val();

    if (username === "") {
      alert("Vui lòng nhập tên đăng nhập.");
      return false;
    }
    if (password === "") {
      alert("Vui lòng nhập mật khẩu.");
      return false;
    }
    if (confirmPassword === "") {
      alert("Vui lòng xác nhận mật khẩu.");
      return false;
    }   
    if (password !== confirmPassword) {
      alert("Mật khẩu không khớp.");
      return false;
    }
    $.ajax({
      type: 'POST',
      url: '/Source/controller/AuthController.php', 
      data: {
          action: 'updateAccount',
          tk_id: tk_id,
          username: username, 
          password: password
      }, 
      success: function (response) {
          console.log(response);
          var data = JSON.parse(response);
          alert(data['message']); // Show the message from the server
      },
      error: function() {
          alert('Có lỗi xảy ra khi gửi dữ liệu!');
      }
  });
}


function toggleEditInfor() {
  $('#submit-edit-infor').removeClass('hidden');
  $('.edit-infor').removeAttr('disabled');
  $('#btn-exit-edit').removeClass('hidden');
  $('#btn-edit-account').addClass('hidden');
  $('#btn-edit-infor').addClass('hidden');
}

function toggleEditAcc() {
  $(".edit-infor").addClass("hidden")
  $('.edit-account').removeClass('hidden');
  $('#btn-exit-edit').removeClass('hidden');
  $('#btn-edit-account').addClass('hidden');
  $('#btn-edit-infor').addClass('hidden');
}

function backNormal() {
  $(".edit-infor").removeClass("hidden")
  $('.edit-infor input').attr('disabled', 'disabled');
  $('#submit-edit-infor').addClass('hidden');
  
  $('.edit-account').addClass('hidden');
  $('#btn-exit-edit').addClass('hidden');
  $('#btn-edit-account').removeClass('hidden');
  $('#btn-edit-infor').removeClass('hidden');
}
