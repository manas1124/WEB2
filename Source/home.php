<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/css/output.css" />
    <link rel="stylesheet" href="assets/css/user.css" />
</head>

<body>
    <nav class="navbar rounded-box shadow-base-300/20 shadow-sm">
        <div class="w-full md:flex md:items-center md:gap-2">
            <div class="flex items-center justify-around">
                <div class="flex flex-row">
                    <a class="link text-base-content text-xl font-bold" href="#"><img class="w-30"
                            src="./assets/image/sgu.png" alt="logo" /></a>
                    <h3 class="ml-3 text-nowrap font-bold text-lg flex items-center justify-center">
                        Trường đại học Sài Gòn
                    </h3>
                </div>
            </div>
            <div id="default-navbar-collapse"
                class="md:navbar-end collapse hidden grow basis-full overflow-hidden transition-[height] duration-300 max-md:w-full">
                <ul class="menu md:menu-horizontal gap-2 p-0 text-base max-md:mt-2">
                    <li><a href="./home.php">Trang chủ</a></li>
                    <li><a href="#" class="nav-item" data-page="survey">Thực hiện khảo sát</a></li>
                    <li><a href="#" class="nav-item" data-page="result-survey">Xem kết quả khảo sát</a></li>

                    <div class="dropdown relative inline-flex [--placement:bottom-end]">
                        <button id="dropdown-bottom-infor" type="button"
                            class=" hidden dropdown-toggle btn btn-soft px-4 py-2 text-base-300" aria-haspopup="menu"
                            aria-expanded="false" aria-label="Dropdown">
                            Xin chào ...
                            <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-open:opacity-100 bg-[#e6e7e8] hidden min-w-60" role="menu"
                            aria-orientation="vertical" aria-labelledby="dropdown-bottom-infor">
                            <li><a href="#" class="nav-item" data-page="user-infor">Trang cá nhân</a></li>
                            <li><a id="btn-logout" class="dropdown-item" href="#"> Đăng xuất </a></li>
                        </ul>
                    </div>
                    <li id="btn-login" class="btn btn-prime hidden"><a href="./login.php">Đăng nhập</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="main-content" class="h-full w-full">
        <main class="hero">
            <div>
                <h1 class="font-bold text-[3rem] uppercase">Khảo sát sinh viên</h1>
                <hr />
                <h1 class="text-[1.5rem] uppercase">Trường đại học Sài Gòn</h1>
            </div>
        </main>
        <footer class=" h-[100px] h-fit px-[4rem] py-[1rem] "
            style="background-image: linear-gradient(90deg,rgba(184, 234, 255, 1) 0%, rgba(255, 255, 255, 1) 50%, rgba(184, 234, 255, 1) 100%);">
            <div class="flex flex-col item">
                <div class="left">
                    <div class="inline-flex ">
                        <img class="w-[6rem]" src="./assets/image/sgu.png" alt="logo" />
                        <h3 class="ml-3 text-nowrap  font-bold text-lg flex items-center justify-center">
                            Trường đại học Sài Gòn
                        </h3>
                    </div>
                    <ul class="flex flex-col gap-2">
                        <li class="inline-flex gap-2">
                            <span class="icon-[ic--baseline-place]" style="width: 24px; height: 24px;"></span>
                            <h1>Phòng D301, Số 273 An Dương Vương, Phường 3, Quận 5, TP. HCM</h1>
                        </li>
                        <li class="inline-flex gap-2">
                            <span class="icon-[ic--baseline-phone]" style="width: 24px; height: 24px;"></span>
                            <h1>Hotline: (028) 38382 664</h1>
                        </li>
                        <li class="inline-flex gap-2">
                            <span class="icon-[material-symbols-light--mail]" style="width: 24px; height: 24px;"></span>
                            <h1>Email: vpkcntt@sgu.edu.vn</h1>
                        </li>
                        <li class="inline-flex gap-2">
                            <span class="icon-[ic--baseline-phone]" style="width: 24px; height: 24px;"></span>
                            <h1>Phone: (028) 38382 664 - 0366 686 557</h1>
                        </li>
                    </ul>
                </div>
                <div class="right"></div>
            </div>
        </footer>

    </div>


    <script src="../node_modules/flyonui/flyonui.js"></script>
    <script src="./views/javascript/indexUser.js"></script>
    <script src="./views/javascript/survey.js"></script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
    </script>
</body>

</html>