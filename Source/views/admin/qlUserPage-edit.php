  <a href="" class=" back-link btn btn-soft ">Quay lại</a>
  <div class="flex w-full justify-center">
      <div class="flex flex-col ">
          <h3 class="modal-title">Tạo bài khảo sát</h3>
          <div class="overflow-y-auto">
              <div class=" pt-0 mb-4">
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

                      </select>
                  </div>
                  <div class="w-96">
                      <label class="label-text" for="loai-doituong">Loại đối tượng</label>
                      <select class="select" id="loai-doituong">
                          <option value="-1">Chọn loại</option>

                      </select>
                  </div>
                  <div class="w-96">
                      <label class="label-text" for="ctdt_id">CTĐT</label>
                      <select class="select" id="ctdt_id">
                          <option value="-1">Chọn CTĐT</option>

                      </select>
                  </div>
              </div>

              <div class="border-t border-base-content/10 pt-4 flex justify-end">
                  <button id="btn-save-doituong" type="submit" class="btn btn-primary">Lưu</button>
              </div>
          </div>
      </div>
  </div>
  <script src="views/javascript/qlUserPage-edit.js"></script>