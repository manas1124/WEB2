<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="shortcut icon" href="./assets/image/sgu.png">
    <link href="./assets/css/output.css" rel="stylesheet">
    
    <style>
        button[aria-current="page"] {
            background-color: var(--color-primary);
            /* Màu nền khi là trang hiện tại */
            color: white;
            /* Màu chữ */
        }

        button[aria-current="page"]:hover {
            background-color: #0056b3;
            /* Màu nền khi hover */
        }

        input:disabled,
        select:disabled {
            opacity: 1;
            /* Make the text fully visible */
            background-color: rgb(255, 255, 255);
            /* Match the background color */
            color: rgb(86, 86, 86);
            /* Keep original text color */
            border: 1px solid rgb(216, 216, 216);
            /* Keep original border color */
            cursor: not-allowed;
            /* Optional: change cursor */
        }
    </style>
</head>

<body>
    <nav
        class="navbar bg-base-100 max-sm:rounded-box max-sm:shadow-sm sm:border-b border-base-content/25 sm:z-1 relative">
        <button type="button" class="btn btn-text max-sm:btn-square sm:hidden me-2" aria-haspopup="dialog"
            aria-expanded="false" aria-controls="default-sidebar" data-overlay="#default-sidebar">
            <span class="icon-[tabler--menu-2] size-5"></span>
        </button>
        <div class="flex flex-1 items-center sm:flex hidden mr-4">
            <a class="h-2 link text-base-content text-xl font-bold flex items-center" href="./admin.php">
                <img class="h-10 sm:h-12 md:h-14 w-auto object-contain" src="./assets/image/sgu.png" alt="logo" />
            </a>
            <h3 class="ml-3 text-nowrap font-bold text-lg flex items-center justify-center">
                Trường đại học Sài Gòn
            </h3>
        </div>
        <div class="navbar-end flex items-center gap-4">

            <div class="dropdown relative inline-flex [--placement:bottom-end]">
                <button id="dropdown-bottom-infor" type="button"
                    class="dropdown-toggle btn btn-soft px-4 py-2 text-base-300" aria-haspopup="menu"
                    aria-expanded="false" aria-label="Dropdown">
                    Chưa đăng nhập
                    <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
                </button>
                <ul class="dropdown-menu dropdown-open:opacity-100 bg-[#e6e7e8] hidden min-w-60" role="menu"
                    aria-orientation="vertical" aria-labelledby="dropdown-bottom-infor">
                    <li><a href="#" class="dropdown-item nav-item" data-page="user-infor">Trang cá nhân</a></li>
                    <li><a class="btn-logout dropdown-item" href="#"> Đăng xuất </a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php require_once "views/include/navAdmin.php" ?>
    <!--  
    <aside id="default-sidebar"
        class="overlay sm:shadow-none overlay-open:translate-x-0 drawer drawer-start hidden max-w-64 sm:absolute sm:z-0 sm:flex sm:translate-x-0 pt-16"
        role="dialog" tabindex="-1">
        <div class="drawer-body px-2 pt-4">
            <ul class=" menu  p-0">
                <li>
                    <a href="" class="nav-link" data-page="qlKhaoSatPage">
                        <span class="icon-[tabler--home] size-5"></span>
                        Khảo sát
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link text-nowrap" data-page="ctdtPage">
                        <span class="icon-[tabler--user] size-5"></span>
                        Chương trình đào tạo
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link" data-page="taiKhoanPage">
                        <span class="icon-[tabler--message] size-5"></span>
                        Tài khoản
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon-[tabler--logout-2] size-5"></span>
                        Sign Out
                    </a>
                </li>
            </ul>
        </div>

    </aside>
    -->
    <div id="main-content"
        class="ml-[16rem] max-sm:ml-4 lg:border-base-content/10 xl:border-e xl:pe-8 relative px-0 py-4 sm:py-8 lg:border-s lg:ps-8 flex flex-wrap gap-px-4 sm:gap-4">

    </div>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/flyonui/flyonui.js"></script>

    <!-- <script src="./views/javascript/indexAdmin.js"></script> -->
    <script src="./views/javascript/indexAdmin.js"></script>
    <script src="./views/javascript/survey.js"></script>
    <script src="./views/javascript/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
    </script>
    <script>
        function capNhatTrangThai() {
            $.ajax({
                url: './controller/TuDongCapNhatTrangThaiKS.php', 
                method: 'GET',
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi khi cập nhật:', error);
                }
            });
        }

        // Gọi tự động mỗi 10 phút (600000ms)
        setInterval(capNhatTrangThai, 600000);
    </script>
</body>

</html>