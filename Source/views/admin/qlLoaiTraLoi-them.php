<div class="flex items-center justify-between mb-4">
    <a href="" class="back-link btn btn-soft ">Quay lại</a>
</div>
<div class="flex w-full justify-center">
    <div class="flex flex-col ">
        <h3 class="modal-title">Thêm loại trả lời mới</h3>
        <div class="overflow-y-auto">
            <!-- thong tin chung -->
            <div class="flex flex-col gap-4 min-w-[400px]">
                <div class="w-full pt-0 mb-4">
                    <div class="mb-2">
                        <label class="label-text" for="mo-ta"> Mô trả loại trả lời </label>
                        <input type="text" placeholder="Mô tả" class="input" id="mo-ta" />
                    </div>
                </div>
                <div class="w-full pt-0 mb-4">
                    <div class="flex flex-col">
                        <strong class="mb-4">
                        Nội dung loại trả lời
                        </strong>
                        <p class="mb-4">
                        Yêu cầu: <br>
                        - Có ít nhất 2 lựa chọn và không vượt quá 10 lựa chọn. <br>
                        - Không được để trồng phần mô tả lựa chọn.
                        </p>
                    </div>
                    
                    <div id="ltl-container">
                        
                    </div>
                    <div class="flex justify-center">
                        <button id="btn-add-section" class="btn btn-primary mb-4"><span class="icon-[ic--baseline-plus]"></span></button>
                    </div>
                </div>
                <div class="w-full pt-0 mb-4 flex justify-end">
                    <button id="btn-create" type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="views/javascript/qlLoaiTraLoi-them.js"></script>