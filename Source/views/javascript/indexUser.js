
$('#loginForm').on('submit', function(e){
    e.preventDefault(); 
    $.ajax({
        type: 'POST',
        url: '/Source/controller/AuthController.php', 
        data: {
            action: 'login',
            username: $('#txtUsername').val(), 
            password: $('#txtPassword').val()
        }, 
        success: function (response) {
            console.log(response);

            var data = JSON.parse(response);
            alert(data['message']); // Show the message from the server
            window.location.replace("http://localhost:3000/Source/home.php");

        },
        error: function() {
            alert('Có lỗi xảy ra khi gửi dữ liệu!');
        }
    });
});

$('#signUpForm').on('submit', function(e){
    e.preventDefault(); 
    data = {
        username: $('#signUpForm #txtUsername').val(), 
        password: $('#signUpForm #txtPassword').val(),
        passwordConfirm: $('#signUpForm #txtConfirmPassword').val(),
        fullName: $('#signUpForm #txtFullName').val(),
        address: $('#signUpForm #txtAddress').val(),
        phone: $('#signUpForm #txtPhone').val(),
        email: $('#signUpForm #txtEmail').val(),
        ctdt: $('#signUpForm #cbxChuongTrinhDaoTao').val(),
        doiTuong: $('#signUpForm #cbxDoiTuong').val()
    };
    if (!vadlidate(data)) {
        return;
    }


    $.ajax({
        type: 'POST',
        url: '/Source/controller/AuthController.php', 
        data: {
            action: 'register',
            username: data.username, 
            password: data.password,
            fullName: data.fullName,
            address: data.address,
            phone: data.phone,
            address: data.address,
            email: data.email,
            ctdtId: parseInt(data.ctdt),
            loaiDoiTuongId: parseInt(data.doiTuong)
        },
        success: function (response) {
            // console.log(response);

            var data = JSON.parse(response);
            alert(data.message); // Show the message from the server


        },
        error: function() {
            alert('Có lỗi xảy ra khi gửi dữ liệu!');
        }
    });
});

function vadlidate(data) {
    if (data.username == "") {
        alert("Tên đăng nhập không được để trống!");
        return false;
    }
    if (data.password == "") {
        alert("Mật khẩu không được để trống!");
        return false;
    }
    if (data.passwordConfirm == "") {
        alert("Mật khẩu không được để trống!");
        return false;
    }
    if (data.password != data.passwordConfirm) {
        alert("Mật khẩu không khớp!");
        return false;
    }
    if (data.fullName == "") {
        alert("Họ tên không được để trống!");
        return false;
    }
    if (data.phone == "") {
        alert("Số điện thoại không được để trống!");
        return false;
    }
    if (data.email == "") {
        alert("Email không được để trống!");
        return false;
    }
    if (data.address == "") {
        alert("Địa chỉ không được để trống!");
        return false;
    }
    if (data.address.match(/[^\p{L}\p{N}\s]/u)) {
        alert("Địa chỉ không được có kí tự đặc biệt!");
        return false;
    }
    if (data.ctdt == "") {
        alert("Vui lòng chọn chương trình đào tạo !");
        return false;
    }
    if (data.doiTuong == "") {
        alert("Vui lòng chọn đối tượng!");
        return false;
    }
    // username không được có kí tự đặc biệt 
    if (data.username.match(/[^a-zA-Z0-9]/)) {
        alert("Tên đăng nhập không được có kí tự đặc biệt!");
        return false;
    }
    if (data.phone.match(/[^0-9]/)) {
        alert("Số điện thoại không được có kí tự đặc biệt!");
        return false;
    }
    if (data.phone.length < 10 || data.phone[0] != 0) {
        alert("Số điện thoại phải gồm 10 số và bắt đầu bằng 0!");
        return false;
    }
    return true;
}

// $(function () {
//   function loadPage(page, isUser = false, addToHistory = true) {
//     $.ajax({
//       url: "../handle/userHandler.php",
//       type: "POST",
//       data: { page: page, user: isUser },
//       success: function (response) {
//         $("#content").html(response);

//         // Update URL without reloading the page
//         let newUrl = window.location.pathname + "?page=" + page;
//         if (isUser) newUrl += "&user=true";

//         if (addToHistory) {
//           history.pushState({ page: page, user: isUser }, "", newUrl);
//         }
//       },
//     });
//   }

//   $(".nav-link").on("click", function (e) {
//     e.preventDefault();
//     let page = $(this).data("page");
//     let isUser = window.location.pathname.includes("user.php");
//     loadPage(page, isUser);
//   });

//   // Handle back/forward navigation
//   window.onpopstate = function (event) {
//     if (event.state) {
//       loadPage(event.state.page, event.state.admin, false);
//     }
//   };

//   // Load the page from the URL on page load
//   const urlParams = new URLSearchParams(window.location.search);
//   let page =
//     urlParams.get("page") ||
//     (window.location.pathname.includes("admin.php") ? "dashboard" : "home");
//   let isUser = urlParams.get("admin") === "true";
//   loadPage(page, isUser, false);
// });
async function getCurrentLoginAccount() {
    try {
      const response = await $.ajax({
        url: "./controller/AuthController.php",
        type: "POST",
        dataType: "json",
        data: { func :"getCurrentLoginUser"},
      });
      if (response.status == 'error') {
        console.log(response.message)
        return null;
      }
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
      console.log(" Phản hồi getUserById:", response);
      return response.data;
    } catch (error) {
      console.log("Lỗi khi lấy dữ liệu người dùng", error);
      return null;
    }
}
$(function () {
    //xu ly lay du lieu nguoi dang dung trong session
    //getuserinfor
    (async () => {
        const account = await getCurrentLoginAccount();
        if (account) {
            console.log(account)
           const userInfor = await getUserById(account.dtId)
           let username = "Xin chào "+ userInfor.ho_ten + " !"
           $("#dropdown-bottom-infor").text(username)
           $("#dropdown-bottom-infor").removeClass("hidden")
        } else {
            $("#btn-login").removeClass("hidden")
        }
    })();

    // Function to update content and URL
    function updateContent(params) {
        $.ajax({
            type: "GET",
            url: "./handle/userHandler.php",
            // url: "./handle/test.php",
            data: params, // Send all parameters
            dataType: "json",
            success: function (response) {
                $("#main-content").html(response.html);
                let queryString = $.param(params);
                queryString = cleanQueryString(queryString);
                // Update the URL
                history.pushState(params, "", "home.php?" + queryString);
                
            },
            error: function (error) {
                console.error("Error navigate page:", error);
             
            }
        });
    }

    // Menu Item Click Handler
    $(".nav-item").on("click", function (event) {
        event.preventDefault();
        let page = $(this).data("page");
        let currentParams = getUrlParams();
        console.log(currentParams)
        // console.log(page)
        // Clean 'act' when changing 'page'
        let newParams = { page: page };
        updateContent(newParams);
    });

    $("#logo-login").on("click", function (event) {
        window.location.href = "/Source/home.php";
        console.log("haha");
    });
        


    $("#main-content").on("click", ".back-link", function (event) {
        event.preventDefault();
        history.back(); // Go back one step in history
    });

    // Xu li truyen tham số khi click ".action-item"(link bên trong main-content) sửa( tự truyền thêm id)
    $("#main-content").on("click", ".action-item", function (event) {
        event.preventDefault();
        let act = $(this).data("act");
        let currentParams = getUrlParams();
        let newParams = { ...currentParams, act: act};

        // xử lí này sẽ truyền param lên url vd: ..act="them"&id=3
        let id = $(this).data("id");
        if (id !=null) {
            newParams = { ...currentParams, act: act, id:id};
        }
        
        updateContent(newParams);
    });

    // Helper function to get URL parameters
    function getUrlParams() {
        let params = {};
        let queryString = window.location.search.substring(1);
        if (queryString) {
            let paramPairs = queryString.split("&");
            for (let i = 0; i < paramPairs.length; i++) {
                let pair = paramPairs[i].split("=");
                params[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1] || "");
            }
        }
        return params;
    }

    // Handle popstate event (back/forward buttons)
    window.addEventListener("popstate", function (event) {
        if (event.state) {
            updateContent(event.state);
        } else {
            // Handle cases where state is null (e.g., initial page load)
            let initialParams = getUrlParams();
            updateContent(initialParams);
        }
    });


    function cleanQueryString(queryString) {
        let params = {};
        if (queryString) {
            let paramPairs = queryString.split("&");
            for (let i = 0; i < paramPairs.length; i++) {
                let pair = paramPairs[i].split("=");
                let key = decodeURIComponent(pair[0]);
                let value = decodeURIComponent(pair[1] || "");
                if (value !== "") {
                    params[key] = value;
                }
            }
        }
        return $.param(params);
    }
});
