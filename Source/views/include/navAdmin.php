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
                    <li class="nav-menu view-survey hidden">
                        <a href="" class="nav-item nav-link text-nowrap" id="khao-sat-page" data-page="qlKhaoSatPage">
                            Khảo sát
                        </a>
                    </li>
                    <li class="nav-menu view-program hidden">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="ctdtPage">
                            Chương trình đào tạo
                        </a>
                    </li>
                    <li class="nav-menu view-program hidden">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="nganh">
                            Ngành
                        </a>
                    </li>
                    <li class="nav-menu view-program hidden">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="chuky">
                            Chu kỳ
                        </a>
                    </li>
                    <li class="nav-menu view-target hidden">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="qlUserPage">
                            Đối tượng
                        </a>
                    </li>
                    <li class="nav-menu view-target hidden">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="nhomks">
                            Nhóm Khảo sát
                        </a>
                    </li>
                    <li class="nav-menu view-account hidden">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="taiKhoanPage">
                            Tài khoản
                        </a>
                    </li>
                    <li class="nav-menu view-permission hidden">
                        <a href="" class="nav-item nav-link text-nowrap" id="quyen-page" data-page="quyenPage">
                            Quyền
                        </a>
                    </li>
                    <li class="nav-menu view-survey hidden">
                        <a href="" class="nav-item nav-link text-nowrap" data-page="ketQuaKhaoSat">
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