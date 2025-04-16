<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div id="signInForm" class="w-full max-w-md bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Sign In</h1>
        <form>
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700">Mật khẩu</label>
                <input type="password" id="password" name="password" class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Đăng nhập</button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-600">
            Chưa có tài khoản?
            <button onclick="toggleSignUpForm()" class="text-blue-500 hover:underline">Đăng ký</button>
        </p>
    </div>
    <!-- Form đăng ký ẩn ban đầu -->
    <div id="signUpForm" class="hidden w-full max-w-4xl bg-white p-8 mt-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Create Account</h1>
        <form>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" placeholder="Tên đăng nhập" id="tenDangNhap" name="TenDangNhap" class="border p-2 rounded w-full" />
                <input type="password" placeholder="Mật khẩu" id="matKhau" name="MatKhau" class="border p-2 rounded w-full" />
                <input type="password" placeholder="Xác thực mật khẩu" id="xacNhanMatKhau" name="XacThucMatKhau" class="border p-2 rounded w-full" />
                <input type="text" placeholder="Họ và tên" id="hoTen" name="HoTen" class="border p-2 rounded w-full" />
                <input type="tel" placeholder="Số điện thoại" id="sdt" name="SoDienThoai" class="border p-2 rounded w-full" />
                <input type="email" placeholder="Email" id="email" name="Email" class="border p-2 rounded w-full" />
                <input type="text" placeholder="Địa chỉ" id="diaChi" name="DiaChi" class="border p-2 rounded w-full" />
                <input type="text" placeholder="Nhóm khảo sát" id="ks" name="KhaoSat" class="border p-2 rounded w-full" />
                <input type="text" placeholder="Loại đối tượng" id="dt" name="DoiTuong" class="border p-2 rounded w-full" />
                <input type="text" placeholder="Chương trình đào tạo" id="ctdt" name="CTDT" class="border p-2 rounded w-full" />
            </div>
            <button type="button" id="signUpButton" class="w-full mt-6 bg-green-500 text-white py-2 rounded hover:bg-green-600">Đăng kí</button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-600">
            Quay về
            <button onclick="toggleSignUpForm()" class="text-blue-500 hover:underline">Đăng nhập</button>
        </p>
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
</body>

</html>