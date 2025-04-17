<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/css/output.css" rel="stylesheet">
    <style>
        button[aria-current="page"] {
            background-color: var(--color-primary);
            color: white;
        }

        button[aria-current="page"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-base-100 max-sm:rounded-box max-sm:shadow-sm sm:border-b border-base-content/25 sm:z-1 relative">
        <div class="flex flex-1 items-center">
            <a class="link text-base-content link-neutral text-xl font-semibold no-underline" href="#">
                FlyonUI
            </a>
        </div>
        <div class="navbar-end flex items-center gap-4">
            <div class="dropdown relative inline-flex [--placement:bottom-end]">
                <button id="dropdown-bottom-start" type="button" class="dropdown-toggle btn btn-primary"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    Tài khoản
                    <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
                </button>
                <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu"
                    aria-orientation="vertical" aria-labelledby="dropdown-bottom-start">
                    <li><a class="dropdown-item" href="#">Trang cá nhân</a></li>
                    <li><a class="dropdown-item" href="#">Hỗ trợ</a></li>
                    <li><a class="dropdown-item" href="#">Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php include("views/include/navUser.php") ?>

    <div id="main-content"
        class="ml-[16rem] max-sm:ml-4 lg:border-base-content/10 xl:border-e xl:pe-8 relative px-0 py-4 sm:py-8 lg:border-s lg:ps-8 flex flex-wrap gap-px-4 sm:gap-4">

    </div>
    <script src="../node_modules/flyonui/flyonui.js"></script>
    <script src="./views/javascript/indexUser.js"></script>
    <script src="./views/javascript/survey.js"></script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/flyonui/flyonui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>