<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/css/output.css" rel="stylesheet">
</head>

<body>
    <nav
        class="navbar bg-base-100 max-sm:rounded-box max-sm:shadow-sm sm:border-b border-base-content/25 sm:z-1 relative">
        <button type="button" class="btn btn-text max-sm:btn-square sm:hidden me-2" aria-haspopup="dialog"
            aria-expanded="false" aria-controls="default-sidebar" data-overlay="#default-sidebar">
            <span class="icon-[tabler--menu-2] size-5"></span>
        </button>
        <div class="flex flex-1 items-center">
            <a class="link text-base-content link-neutral text-xl font-semibold no-underline" href="#">
                FlyonUI
            </a>
        </div>
        <div class="navbar-end flex items-center gap-4">

            <div class="dropdown relative inline-flex [--placement:bottom-end]">
                <button id="dropdown-bottom-start" type="button" class="dropdown-toggle btn btn-primary"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    Bottom end
                    <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
                </button>
                <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu"
                    aria-orientation="vertical" aria-labelledby="dropdown-bottom-start">
                    <li><a class="dropdown-item" href="#"> My Profile </a></li>
                    <li><a class="dropdown-item" href="#"> Settings </a></li>
                    <li><a class="dropdown-item" href="#"> Billing </a></li>
                    <li><a class="dropdown-item" href="#"> FAQs </a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php include( "views/include/navAdmin.php") ?>
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
        class="ml-[16rem] max-sm:ml-4 lg:border-base-content/10 xl:border-e xl:pe-8 relative px-0 py-4 sm:py-8 lg:border-s lg:ps-8">

    </div>
    <script>
    // active nav link
    // $.noConflict();
    // jQuery( document ).ready(function() {
    //     $(".nav-link").click(function () {
    //         $(".nav-link").removeClass("bg-primary");
    //         $(this).addClass("bg-primary");   
    //     });
    // });
    </script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/flyonui/flyonui.js"></script>

    <!-- <script src="./views/javascript/indexAdmin.js"></script> -->
    <script src="./views/javascript/indexAdmin.js"></script>
</body>

</html>