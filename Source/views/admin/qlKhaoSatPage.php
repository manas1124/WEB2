<div id="ctdt-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý khảo sát</h1>
        <div class="flex items-center gap-4">
            <button class="action-item btn btn-primary" data-act="ks-tao">Tạo khảo sát</button>
        </div>
    </div>

    <div class="w-full overflow-x-auto ">
        <table class="table">
            <thead>
                <tr>
                    <th>Tên bài khảo sát</th>
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

</div>
<script src="views/javascript/qlKhaoSatPage.js"></script>