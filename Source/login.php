<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="./assets/css/output.css" rel="stylesheet">
    <title>Login</title>
</head>

<body class="flex w-full h-screen justify-between">
    <img src="./assets/img/image.png" alt="Background Image" class="w-2/3" />
    <div class="flex w-1/3 flex-col bg-[#dddddd] items-center">
        <img src="./assets/img/logo.png" alt="" class="w-[150px] h-[150px] mt-4" />
        <h1 class="text-2xl font-bold text-[#304CA2]">TRƯỜNG ĐẠI HỌC SÀI GÒN</h1>
        <h1 class="text-1xl font-bold mb-6 text-[#304CA2]">Cổng thông tin đào tạo</h1>
        <div id="signInForm" class="bg-white p-8 rounded-md mx-8 ">
            <h1 class="text-3xl font-bold mb-6 text-[#304CA2]">ĐĂNG NHẬP</h1>
            <form id="loginForm" class="flex gap-8 flex-wrap">
                <div class="input-floating">
                    <input name="username" type="text" placeholder="Tên đăng nhập" class="input input-lg" id="txtUsername" />
                    <label class="input-floating-label" for="floatingLabelLarge">Tên đăng nhập</label>
                </div>
                <div class="input-floating">
                    <input name="password" type="text" placeholder="Mật khẩu" class="input input-lg" id="txtPassword" />
                    <label class="input-floating-label" for="floatingLabelLarge">Mật khẩu</label>
                </div>
                <button type="submit" class="w-full bg-[#304CA2] text-white py-2 rounded hover:bg-[#4B66C2] cursor-pointer">Đăng nhập</button>
            </form>
            <p class="mt-4 text-center text-sm text-gray-600">
                Chưa có tài khoản?
                <button onclick="toggleSignUpForm()" class="text-blue-500 hover:underline">Đăng ký</button>
            </p>
        </div>
        <!-- Form đăng ký ẩn ban đầu -->
        <div id="signUpForm" class="hidden max-w-4xl mx-8 bg-white p-8 rounded-md">
            <h1 class="text-3xl font-bold mb-6 text-[#304CA2]">ĐĂNG KÝ</h1>
            <form>
                <div class="flex flex-col gap-4">
                    <div class="input-floating">
                        <input name="username" type="text" placeholder="Tên đăng nhập" class="input input-lg" id="txtUsername" />
                        <label class="input-floating-label" for="floatingLabelLarge">Tên đăng nhập</label>
                    </div>
                    <div class="flex gap-4">
                        <div class="input-floating w-1/2">
                            <input name="password" type="password" placeholder="Mật khẩu" class="input input-lg" id="txtPassword" />
                            <label class="input-floating-label" for="floatingLabelLarge">Mật khẩu</label>
                        </div>
                        <div class="input-floating w-1/2">
                            <input name="confirmPassword" type="password" placeholder="Xác nhận mật khẩu" class="input input-lg" id="txtConfirmPassword" />
                            <label class="input-floating-label" for="floatingLabelLarge">Xác nhận mật khẩu</label>
                        </div>
                    </div>
                    <div class="input-floating">
                        <input name="fullName" type="text" placeholder="Họ và tên" class="input input-lg" id="txtFullName" />
                        <label class="input-floating-label" for="floatingLabelLarge">Họ và tên</label>
                    </div>
                    <div class="flex gap-4">
                        <div class="input-floating w-1/2">
                            <input name="phone" type="password" placeholder="Số điện thoại" class="input input-lg" id="txtPhone" />
                            <label class="input-floating-label" for="floatingLabelLarge">Số điện thoại</label>
                        </div>
                        <div class="input-floating w-1/2">
                            <input name="email" type="password" placeholder="Email" class="input input-lg" id="txtEmail" />
                            <label class="input-floating-label" for="floatingLabelLarge">Email</label>
                        </div>
                    </div>
                    <select class="border p-2 rounded h-12">
                        <option value="" disabled selected hidden>-- Chương trình đào tạo --</option>
                        <option value="male">Công nghệ thông tin 2022-2025</option>
                        <option value="female">Nữ</option>
                        <option value="other">Khác</option>
                    </select>
                    <div class="flex gap-4">
                        <select class="border p-2 rounded w-1/2">
                            <option value="" disabled selected hidden>-- Nhóm khảo sát --</option>
                            <option value="male">Công nghệ thông tin 2022-2025</option>
                            <option value="female">Nữ</option>
                            <option value="other">Khác</option>
                        </select>
                        <select class="border p-2 rounded w-1/2">
                            <option value="" disabled selected hidden>-- Đối tượng --</option>
                            <option value="male">Công nghệ thông tin 2022-2025</option>
                            <option value="female">Nữ</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                </div>
                <button type="button" id="signUpButton" class="w-full mt-6 bg-[#304CA2] text-white py-2 rounded hover:bg-[#4B66C2] cursor-pointer">Đăng kí</button>
            </form>
            <p class="mt-4 text-center text-sm text-gray-600">
                Quay về
                <button onclick="toggleSignUpForm()" class="text-blue-500 hover:underline">Đăng nhập</button>
            </p>
        </div>
    </div>


    <!-- Toggle script -->
    <script>
        function toggleSignUpForm() {
            const signIn = document.getElementById("signInForm");
            const signUp = document.getElementById("signUpForm");

            signIn.classList.toggle("hidden");
            signUp.classList.toggle("hidden");
        }
    </script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/flyonui/flyonui.js"></script>

    <!-- <script src="./views/javascript/indexAdmin.js"></script> -->
    <script src="./views/javascript/indexUser.js"></script>
    <script src="./views/javascript/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>