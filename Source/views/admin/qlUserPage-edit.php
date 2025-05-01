
<a href="" class="back-link btn btn-soft ">Quay lại</a>

<h3 class="modal-title">Sửa đối tượng</h3>
<div class="overflow-y-auto">
  
    <div class="flex flex-row">
        <div class="modal-body pt-0 mb-4">
            <div class="w-96">
                <label class="label-text" for="hoten">Họ tên</label>
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
                <label class="label-text" for="dienthoai">Điện thoại</label>
                <input type="text" placeholder="Nhập số điện thoại" class="input" id="dien_thoai" />
            </div>
            <div class="w-96">
                <label class="label-text" for="nhom-ks">Nhóm khảo sát</label>
                <select class="select" id="nhom-ks">
                    <option value="-1">Chọn nhóm khảo sát</option>
                    <option value="1">Khảo sát đầu ra</option>
                     <option value="2">Khảo sát chất lượng giảng dạy</option>
                     <option value="3">Khảo sát thực tập</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="loai-doituong">Loại đối tượng</label>
                <select class="select" id="loai-doituong">
                    <option value="-1">Chọn loại</option>
                     <option value="1">Sinh viên</option>
                     <option value="2">Giảng viên</option>
                     <option value="3">Doanh nghiệp</option>
                </select>
            </div>
            <div class="w-96">
                <label class="label-text" for="ctdt_id">CTĐT</label>
                <select class="select" id="ctdt_id">
                    <option value="-1">Chọn CTĐT</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
        </div>
    </div>

    <div class="border-t border-base-content/10 pt-4 flex justify-end">
        <button id="btn-save-doituong" type="submit" class="btn btn-primary">Lưu</button>
    </div>


<script src="views/javascript/qlUserPage-edit.js"></script>