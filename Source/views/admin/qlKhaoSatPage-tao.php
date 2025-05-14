<div class="flex w-full justify-center">
    <div class="flex flex-col ">
        <h3 class="modal-title">Tạo bài khảo sát</h3>
        <div class="overflow-y-auto">
            <!-- thong tin chung -->
            <div class="flex flex-row gap-4">
                <div class="pt-0 mb-4">
                    <div class="mb-2">
                        <label class="label-text" for="ten-ks"> Tên bài khảo sát </label>
                        <input type="text" placeholder="John Doe" class="input" id="ten-ks" />
                    </div>
                    <div class="relative max-w-sm mb-2">
                        <label class="label-text" for="select-nhomks-box"> Tên bài nhóm khảo sát </label>
                        <div id="select-nhomks-box"
                            class="border border-gray-300 rounded-md p-1.5 cursor-pointer bg-white">
                            <span id="selected-option">Chọn nhóm</span>
                        </div>
                        <div id="nhomKsDropdown"
                            class=" hidden absolute left-0 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10">
                            <input type="text" id="nhomKsInput" placeholder="Chọn nhóm "
                                class="p-2 w-full border-b border-gray-300 focus:outline-none" />
                            <div id="list-nhomks-option" class="max-h-60 overflow-y-auto">
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 flex gap-4 max-sm:flex-col">
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
                        <select class="select" id="select-su-dung">
                            <option selected value="2">Chưa bắt đầu</option>
                            <option value="1">Đang thực hiện</option>
                            <option value="0" disabled>Kết thúc</option>
                        </select>
                    </div>
                    <div class="max-w-sm mb-8">
                        <label class="label-text" for="input-file-survery-content"> Nhập file excel </label>
                        <input type="file" class="input" id="input-file-survery-content" disabled
                            accept=".xlsx, .xls" />
                    </div>
                </div>
                <div class=" pt-0 mb-4">
                    <div class="w-96 mb-2">
                        <label class="label-text" for="select-loai-tra-loi">Loại câu trả lời </label>
                        <select class="select" id="select-loai-tra-loi">
                            <option value="-1">Chọn loại</option>
                        </select>
                    </div>
                    <div class="w-96 mb-2">
                        <label class="label-text" for="select-nganh">Ngành </label>
                        <select class="select" id="select-nganh">
                            <option value="-1">Chọn ngành</option>
                        </select>
                    </div>
                    <div class="w-96 mb-2">
                        <label class="label-text" for="select-chu-ki">Chu kì</label>
                        <select class="select" id="select-chu-ki">
                            <option value="-1">Chọn chu kì</option>
                        </select>
                    </div>
                    <div class="w-96 mb-2">
                        <label class="label-text" for="select-ks-type">Loại khảo sát</label>
                        <select class="select" id="select-ks-type">
                            <option value="1">Chương trình đào tạo</option>
                            <option value="0">Chuẩn đầu ra</option>
                        </select>
                    </div>
                    <div class="w-96 mb-2 mt-6">
                        <a id="surveyContentFormat" class="btn btn-outline btn-primary">Tải file excel mẫu</a>
                    </div>
                </div>
            </div>
            <!-- cau hoi -->
            <div class="pt-0 mb-4">
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
<script src="views/javascript/qlKhaoSatPage-tao.js"></script>