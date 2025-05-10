<?php
echo '<nav class="navbar rounded-box shadow-base-300/20 shadow-sm">
        <div class="w-full md:flex md:items-center md:gap-2">
            <div class="flex items-center justify-around">
                <div class="flex flex-row">
                    <a class="link text-base-content text-xl font-bold" href="./home.php"><img class="w-30"
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
    </nav>';