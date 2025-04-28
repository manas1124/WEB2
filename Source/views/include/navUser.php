<?php
echo '<aside id="default-sidebar"
        class="overlay sm:shadow-none overlay-open:translate-x-0 drawer drawer-start hidden max-w-64 sm:absolute sm:z-0 sm:flex sm:translate-x-0 pt-16"
        role="dialog" tabindex="-1">
        <div class="drawer-body px-2 pt-4">
            <ul class=" menu  p-0">
                <li>
                    <a href="#" class="nav-item nav-link" data-page="surveyPage">
                        <span class="icon-[tabler--message] size-5"></span>
                        Khảo sát - client
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item nav-link text-nowrap" data-page="ketQuaKhaoSat">
                        <span class="icon-[tabler--message] size-5"></span>
                        Kết quả khảo sát
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

    </aside>';
