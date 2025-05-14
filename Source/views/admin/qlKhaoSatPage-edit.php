<div class="flex w-full justify-center">
    <div class="flex flex-col ">
        <h3 class="modal-title mb-8">Sửa bài khảo sát</h3>

        <div class="">
            <!-- thong tin chung -->
            <div class="flex flex-row">
                <div class="pt-0 mb-4">
                    <div class="mb-2">
                        <label class="label-text" for="ten-ks"> Tên bài khảo sát </label>
                        <input type="text" placeholder="Jack Sparrow" class="input" id="ten-ks" />
                    </div>
                    <div class="relative max-w-sm">
                        <label class="label-text" for="select-nhomks-box"> Tên nhóm khảo sát </label>
                        <div id="select-nhomks-box"
                            class="border border-gray-300 rounded-md p-2 cursor-pointer bg-white">
                            <span id="selected-nhom-ks">Chọn nhóm</span>
                        </div>
                        <div id="nhomKsDropdown"
                            class=" hidden absolute left-0 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10">
                            <input type="text" id="nhomKsInput" placeholder="Chọn nhóm "
                                class="p-2 w-full border-b border-gray-300 focus:outline-none" />
                            <div id="list-nhomks-option" class="max-h-60 overflow-y-auto">
                            </div>
                        </div>
                    </div>
                    <div class="mb-0.5 flex gap-4 max-sm:flex-col mb-2">
                        <div class="w-full">
                            <label class="label-text" for="begin"> Bắt đầu </label>
                            <input type="date" class="input" id="begin" />
                        </div>
                        <div class="w-full">
                            <label class="label-text" for="end"> Kết thúc</label>
                            <input type="date" class="input" id="end" />
                        </div>
                    </div>
                    <div class="w-96">
                        <label class="label-text" for="select-su-dung">Trạng thái bài khảo sát </label>
                        <select class="select" id="select-su-dung" disabled>
                            <option value="1">Đang thực hiện</option>
                            <option value="0">Kết thúc</option>
                            <option value="2">Chưa bắt đầu</option>
                        </select>
                    </div>
                </div>
                <div class="modal-body pt-0 mb-4">
                    <div class="w-96 mb-2">
                        <label class="label-text" for="select-loai-tra-loi">Loại câu trả lời </label>
                        <select class="select" id="select-loai-tra-loi">
                            <option>Chọn loại</option>
                        </select>
                    </div>
                    <div class="w-96 mb-2">
                        <label class="label-text" for="select-nganh">Ngành </label>
                        <select class="select" id="select-nganh">
                            <option value="-1">Chọn ngành</option>
                        </select>
                    </div>
                    <div class="w-96 mb-[1.5px]">
                        <label class="label-text" for="select-chu-ki">Chu kì</label>
                        <select class="select" id="select-chu-ki">
                            <option value="-1">Chọn chu kì</option>
                        </select>
                    </div>
                    <div class="w-96 ">
                        <label class="label-text" for="select-ks-type">Loại khảo sát</label>
                        <select class="select" id="select-ks-type">
                            <option value="1">Chương trình đào tạo</option>
                            <option value="0">Chuẩn đầu ra</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- cau hoi -->
            <div class="modal-body pt-0 mb-4">
                <p class="mb-4">
                    Nội dung khảo sát
                </p>
                <div id="survey-container"></div>
                <button id="btn-add-question" class="btn btn-primary mb-4">Tạo mục câu hỏi</button>

            </div>
            <div class="modal-footer border-t border-base-content/10">
                <button id="btn-save-ks" type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>
<script src="views/javascript/qlKhaoSatPage-edit.js"></script>