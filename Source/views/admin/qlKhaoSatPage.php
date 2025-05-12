<div id="ctdt-content" class="container h-full">
    <h1>Tìm kiếm bài khảo sát</h1>
    <div class="flex items-center justify-between mb-4">
        <div class="inline-flex gap-3">
        <div class="relative">
            <input id="input-search-ks" class="input ps-8" type="text" placeholder="Tìm kiếm..." 
                aria-expanded="false" value=""  />
            <span class="icon-[tabler--search] text-base-content absolute start-3 top-1/2 size-4 shrink-0 -translate-y-1/2"></span>
        </div>
        <button id="btn-search-ks" class="btn btn-outline">Tìm</button>
        </div>
        <div class="flex items-center gap-4">
            <button class="action-item btn btn-primary create-survey hidden" data-act="ks-tao">Tạo khảo sát</button>
        </div>
    </div>

    <div class="w-full overflow-x-auto h-[400px] ">
        <table class="table ">
            <thead>
                <tr>
                    <th class="w-2/5">Tên bài khảo sát</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="ks-list">
                <!-- <tr>
                    <td class="text-nowrap">Jane Smith</td>
                    <td>janesmith@example.com</td>
                    <td><span class="badge badge-soft badge-error ">Rejected</span></td>
                    <td class="text-nowrap">March 2, 2024</td>
                    <td>
                        <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span
                                class="icon-[tabler--pencil] size-5"></span></button>
                        <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span
                                class="icon-[tabler--trash] size-5"></span></button>
                        <button class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span
                                class="icon-[tabler--dots-vertical] size-5"></span></button>
                    </td>
                </tr> -->

            </tbody>
        </table>

    </div>
    <div id="pagination" class="flex justify-center space-x-3 mt-3"></div>

</div>
<script src="views/javascript/qlKhaoSatPage.js"></script>