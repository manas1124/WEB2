<div class="w-full h-full mx-auto container p-5">
    <div class="flex items-center justify-between mb-4">
<a href="" class="back-link btn btn-soft ">Quay lại</a>
    </div>
    <div class="flex items-center justify-center mb-4">
<h3 class="modal-title">Thêm đối tượng</h3>
    </div>
    <div class="flex items-center justify-center mb-4">
<div class="overflow-y-auto">
    <!-- Thông tin người dùng -->
    <div class="flex flex-row">
        <div class="modal-body pt-0 mb-4">
            <div class="w-96">
                <label class="label-text" for="ho_ten">Họ tên</label>
                <input type="text" placeholder="Nhập họ tên" class="input" id="ho_ten" />
            </div>
            <div class="w-96">
                <label class="label-text" for="email">Email</label>
                <input type="email" placeholder="Nhập email" class="input" id="email" />
            </div>
            <div class="w-96">
                <label class="label-text" for="diachi">Địa chỉ</label>
                <input type="text" placeholder="Nhập địa chỉ" class="input" id="diachi" />
            </div>
            <div class="w-96">
                <label class="label-text" for="dien_thoai">Điện thoại</label>
                <input type="text" placeholder="Nhập số điện thoại" class="input" id="dien_thoai" />
            </div>
            <div  class="w-96">
                <label class="label-text" for="nhom-ks">Nhóm khảo sát</label>
                <select class="select" id="nhom-ks">
                    <option value="-1">Chọn nhóm khảo sát</option>
                    <!-- <option value="1">Nhóm 1</option>
                    <option value="2">Nhóm 2</option> -->
                    
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="loai-doituong">Loại đối tượng</label>
                <select class="select" id="loai-doituong">
                    <option value="-1">Chọn loại</option>
                    <!-- <option value="1">Sinh viên</option>
                    <option value="2">Giảng viên</option>
                    <option value="3">Doanh nghiệp</option> -->
                    <!-- Có thể thêm các loại khác -->
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="ctdt">CTĐT</label>
                <select class="select" id="ctdt">
                    <option value="-1">Chọn CTĐT</option>
                    <!-- <option value="1">1</option>
                    <option value="2">2</option>
                 -->
                </select>
            </div>
        </div>
    </div>

    <div class="border-t border-base-content/10 pt-4 flex justify-end">
        <button id="btn-save-doituong" type="submit" class="btn btn-primary">Lưu</button>
    </div>
    </div>
</div>

<script src="views/javascript/qlUserPage-them.js"></script>