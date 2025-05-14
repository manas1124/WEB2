<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="./assets/css/output.css" rel="stylesheet">
    <title>Login Admin</title>
    <link rel="shortcut icon" href="./assets/image/sgu.png">

</head>

<body class="flex w-full h-screen justify-between">
    <img src="./assets/img/image.png" alt="Background Image" class="w-2/3" />
    <div class="flex w-1/3 flex-col bg-[#dddddd] items-center">
        <img id="logo-login" src="./assets/img/logo.png" alt="" class="w-[150px] h-[150px] mt-4" />
        <h1 class="text-2xl font-bold text-[#304CA2]">TRƯỜNG ĐẠI HỌC SÀI GÒN</h1>
        <h1 class="text-1xl font-bold mb-6 text-[#304CA2]">Cổng thông tin đào tạo</h1>
        <div id="signInForm" class="bg-white p-8 rounded-md mx-8 ">
            <h1 class="text-3xl font-bold mb-6 text-[#304CA2]">ĐĂNG NHẬP ADMIN</h1>
            <form id="loginForm" class="flex gap-8 flex-wrap">
                <div class="input-floating">
                    <input name="username" type="text" placeholder="Tên đăng nhập" class="input input-lg"
                        id="txtUsername" />
                    <label class="input-floating-label" for="floatingLabelLarge">Tên đăng nhập</label>
                </div>
                <div class="input-floating">
                    <input name="password" type="password" placeholder="Mật khẩu" class="input input-lg" id="txtPassword" />
                    <label class="input-floating-label" for="floatingLabelLarge">Mật khẩu</label>
                </div>
                <button type="submit"
                    class="w-full bg-[#304CA2] text-white py-2 rounded hover:bg-[#4B66C2] cursor-pointer">Đăng
                    nhập</button>
            </form>
        </div>

    </div>


    <!-- Toggle script -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/flyonui/flyonui.js"></script>
    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: './controller/AuthController.php',
                data: {
                    action: 'login',
                    username: $('#txtUsername').val(),
                    password: $('#txtPassword').val()
                },
                success: function(response) {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data['status'] == "success") {
                        Swal.fire({
                            title: 'Đăng nhập thành công',
                            text: " Đang chuyển hướng...",
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Tiếp tục',
                        }).then((result) => {
                            if (data["role"] == 'Admin') {
                                window.location.href = "./admin.php";
                            } else {
                                window.location.href = "./home.php";
                            }
                        });
                    } else {
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
                error: function() {
                    Swal.fire({
                        title: 'Đăng nhập thất bại',
                        text: 'Có lỗi khi gửi dữ liệu!',
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Thử lại',
                    });
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>