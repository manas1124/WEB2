<?php
echo '  <aside id="default-sidebar"
        class="overlay sm:shadow-none overlay-open:translate-x-0 drawer drawer-start hidden max-w-64 sm:absolute sm:z-0 sm:flex sm:translate-x-0 pt-8"
        role="dialog" tabindex="-1">
            <div class="flex justify-center items-center sm:hidden pt-3">
                <a class="h-2 link text-base-content text-xl font-bold flex flex-col items-center" href="./admin.php">
                    <img class="h-10 sm:h-12 md:h-14 w-auto object-contain" src="./assets/image/sgu.png" alt="logo" />
                    <h3 class="text-nowrap font-bold text-lg">
                        Trường đại học Sài Gòn
                    </h3>
                </a>
            </div>
            <div class="drawer-body px-2 pt-16">

                <ul class=" menu  p-0">
                    <li class="hidden nav-menu menu-survey">
                        <a href="" class="nav-item nav-link text-nowrap" id="khao-sat-page" data-page="qlKhaoSatPage">
                            <span class="icon-[tabler--home] size-5"></span>
                            Khảo sát
                        </a>
                    </li>
                    <li class="hidden nav-menu menu-program">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="ctdtPage">
                            <span class="icon-[tabler--school] size-5"></span>
                            Chương trình đào tạo
                        </a>
                    </li>
                    <li class="hidden nav-menu menu-program">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="nganh">
                            <span class="icon-[tabler--book] size-5"></span>
                            Ngành
                        </a>
                    </li>
                    <li class="hidden nav-menu menu-program">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="chuky">
                            <span class="icon-[tabler--calendar-time] size-5"></span>
                            Chu kỳ
                        </a>
                    </li>
                    <li class="hidden nav-menu menu-target">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="qlUserPage">
                            <span class="icon-[tabler--user] size-5"></span>
                            Đối tượng
                        </a>
                    </li>
                    <li class="hidden nav-menu menu-target">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="nhomks">
                            <span class="icon-[tabler--users-group] size-5"></span>
                            Nhóm Khảo sát
                        </a>
                    </li>
                    <li class="hidden nav-menu menu-account">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="taiKhoanPage">
                            <span class="icon-[tabler--user] size-5"></span>
                            Tài khoản
                        </a>
                    </li>
                    <li class="hidden nav-menu menu-permission">
                        <a href="" class="nav-item nav-link text-nowrap" id="quyen-page" data-page="quyenPage">
                            <span class="icon-[tabler--key] size-5"></span>
                            Quyền
                        </a>
                    </li>
                    <li class="hidden nav-menu menu-survey">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="surveyPage">
                            <span class="icon-[tabler--message] size-5"></span>
                            Khảo sát - client
                        </a>
                    </li>
                    <li class="hidden nav-menu menu-survey">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="ketQuaKhaoSat">
                            <span class="icon-[tabler--notes] size-5"></span>
                            Kết quả khảo sát
                        </a>
                    </li>
                    <li>
                        <a class="btn-logout text-nowrap">
                            <span class=" icon-[tabler--logout-2] size-5"></span>
                            Đăng xuất
                        </a>
                    </li>
                </ul>
            </div>

        </aside>';
    ?>