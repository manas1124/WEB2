<div id="nganh-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý nhóm khảo sát</h1>
        <div class="flex items-center gap-4">
            <button onclick="showModal('create')" type="button" class="btn btn-primary" aria-haspopup="dialog" aria-expanded="false" aria-controls="basic-modal" > Open modal </button>
            <button type="button" class="action-item btn btn-primary create-target hidden" data-act="nhomks-them">Thêm nhóm khảo sát</button>
        </div>
    </div>
    <div id="basic-modal" class="overlay modal overlay-open:opacity-100 hidden overlay-open:duration-300 bg-black/25" role="dialog" tabindex="-1">
        <div class="modal-dialog overlay-open:opacity-100 overlay-open:duration-300">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Dialog Title</h3>
                    <button onclick="closeModal()" type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close">
                        <span class="icon-[tabler--x] size-4"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-full">
                        <label class="label-text w-full" for="ten-nhomks">Tên nhóm khảo sát </label>
                        <input type="text" placeholder="" class="input" id="ten-nhomks" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModal()" type="button" class="btn btn-soft btn-secondary">Close</button>
                    <button type="button" id="btn-save" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Tên Nhóm Khảo sát</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="nhomks-list">
            </tbody>
        </table>
        <div id="pagination" class="flex justify-center space-x-2"></div>
    </div>
</div>
<script src="./views/javascript/nhomks.js"></script>
