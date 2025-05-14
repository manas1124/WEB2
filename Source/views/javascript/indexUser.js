
$('#loginForm').on('submit', function (e) {
    console.log("date gui:", $('#txtUsername').val(), $('#txtPassword').val())
    e.preventDefault();
    if ($('#txtUsername').val() == "" || $('#txtPassword').val() == "") {
        Swal.fire({
            title: 'Thông báo',
            text: "Tên đăng nhập hoặc mật khẩu không được để trống!",
            icon: 'warning',
            confirmButtonText: 'Thử lại'
        });
        return;
     }
    $.ajax({
        type: 'POST',
        url: './controller/AuthController.php',
        data: {
            action: 'login',
            username: $('#txtUsername').val(),
            password: $('#txtPassword').val()
        },
        success: function (response) {
            console.log(response);

            var data = JSON.parse(response);
            console.log(data);
            // alert(data['message']); // Show the message from the server
            if (data['status'] == "success") {
                Swal.fire({
                    title: 'Đăng nhập thành công',
                    text: " Đang chuyển hướng...",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Đăng xuất',
                }).then((result) => {
                    window.location.href = "./home.php";
                    
                });
            }
            else {
                Swal.fire({
                    title: 'Đăng nhập thất bại',
                    text: data['message'],
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Thử lại',
                });
            }



        },
        error: function () {
            console.log(response);
            alert('Có lỗi xảy ra khi gửi dữ liệu!');
        }
    });
});

$('#signUpForm').on('submit', function (e) {
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
        url: './controller/AuthController.php',
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
            // alert(data.message); // Show the message from the server
            console.log(data);
            if (data.status == "success") {
                Swal.fire({
                    title: 'Đăng kí thành công',
                    text: " Bây giờ bạn có thể đăng nhập",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Đăng nhập ngay',
                }).then((result) => {
                    document.getElementById('signUpForm').reset();
                    $("#signUpForm").addClass("hidden")
                    $("#signInForm").removeClass("hidden")
                });
            }
            else {
                Swal.fire({
                    title: 'Đăng kí thất bại',
                    text: data.message,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Thử lại',
                });
            }


        },
        error: function () {
            alert('Có lỗi xảy ra khi gửi dữ liệu!');
        }
    });
});

function vadlidate(data) {
    let message = '';
    if (data.username == "") {
        message = "Tên đăng nhập không được để trống!";
    }
    else if (/\s/.test(data.username) == true ) {

        message = "Tên đăng nhập không được có khoảng trắng!";
    }
    else if (data.password == "") {
        message = "Mật khẩu không được để trống!";
    }
    else if (data.passwordConfirm == "") {
        message = "Mật khẩu xác nhận không được để trống!";
    }
    else if (data.password != data.passwordConfirm) {
        message = "Mật khẩu không trùng khớp!";
    }
    else if (data.fullName == "") {
        message = "Họ tên không được để trống!";
    }
    else if (data.phone == "") {
        message = "Số điện thoại không được để trống!";
    }
    else if (data.email == "") {
        message = "Email không được để trống!";
    }
    else if (data.address == "") {
        message = "Địa chỉ không được để trống!";
    }
    else if (data.address.match(/[^\p{L}\p{N}\s]/u)) {
        message = "Địa chỉ không được có kí tự đặc biệt!";
    }
    else if (data.ctdt == "") {
        message = "Vui lòng chọn chương trình đào tạo !";
    }
    else if (data.doiTuong == "") {
        message = "Vui lòng chọn đối tượng !";
    }
    // username không được có kí tự đặc biệt 
    else if (data.username.match(/[^a-zA-Z0-9]/)) {
        message = "Tên đăng nhập không được có kí tự đặc biệt!";
    }
    else if (data.phone.match(/[^0-9]/)) {
        message = "Số điện thoại không được có kí tự đặc biệt!";
    }
    else if (data.phone.length < 10 || data.phone[0] != 0) {
        message = "Số điện thoại phải gồm 10 số và bắt đầu bằng 0!";
    }
    if (message != '') {
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
            data: { func: "getCurrentLoginUser" },
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
            let username = "Xin chào " + userInfor.ho_ten + " !"
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
                Swal.fire({
                    title: error.responseText,
                    text: 'Bạn không được phép thực hiện thao tác này',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    location.href = "./home.php";
                });
                

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
        window.location.href = "./home.php";
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
        let newParams = { ...currentParams, act: act };

        // xử lí này sẽ truyền param lên url vd: ..act="them"&id=3
        let id = $(this).data("id");
        if (id != null) {
            newParams = { ...currentParams, act: act, id: id };
        }

        updateContent(newParams);
    });

    $("#btn-logout").click(function() {
            $.ajax({
                type: 'POST',
                url: './controller/AuthController.php',
                data: {
                    action: 'logout'
                },
                success: function(response) {
                    console.log(response);

                    var data = JSON.parse(response);
                    alert(data['message']); // Show the message from the server
                    window.location.href = "./login.php";

                },
                error: function() {
                    alert('Có lỗi xảy ra khi gửi dữ liệu!');
                }
            });
        })

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
