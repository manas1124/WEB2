async function getNhomKs() {
    try {
      const response = await $.ajax({
        url: "./controller/nhomKsController.php",
        type: "GET",
        data: { func: "getAllNhomKs" },
        dataType: "json",
      });
      console.log("fect", response);
      return response;
    } catch (error) {
      console.log(error);
      console.log("loi fetchdata getAllKhaoSat 1");
      return null;
    }
  }
  async function getAllLoaidt() {
    try {
      const response = await $.ajax({
        url: "./controller/LoaidtController.php",
        type: "GET",
        data: { func: "getAllLoaidt" },
        dataType: "json",
      });
      if (response.error) {
        console.log("fect", response.error);
      }
      return response;
    } catch (error) {
      console.log(error);
      console.log("loi fetchdata getAllKhaoSat 1");
      return null;
    }
  }
  async function getAllCTDT() {
    try {
      const response = await $.ajax({
        url: "./controller/CTDTController.php",
        type: "GET",
        data: { func: "getAll" },
        dataType: "json",
      });
      if (response.error) {
        console.log("fect", response.error);
      }
      return response;
    } catch (error) {
      console.log(error);
      console.log("loi fetchdata getAllKhaoSat 1");
      return null;
    }
  }
  async function updateUser(data) {
    try {
      console.log("Sending data:", data); // kiểm tra dữ liệu gửi đi
  
      const response = await $.ajax({
        url: "./controller/UserController.php",
        type: "POST",
        data: {
          func: "updateUser",
          data: JSON.stringify(data),
        },
        dataType: "json",
      });
  
      if (response.error) {
        console.log("Lỗi phía server (response.error):", response.error);
      }
  
      console.log("Kết quả response:", response);
      return response;
    } catch (error) {
      console.log("Lỗi xảy ra khi gọi Ajax:", error);
      if (error.responseText) {
        console.log("Nội dung lỗi trả về:", error.responseText); // quan trọng nhất!
      }
      return false;
    }
  }
  async function getUserById(id) {
    
    try {
      console.log("Gửi ID vào getUserById:", id);
      const response = await $.ajax({
        
        url: "./controller/UserController.php",
        type: "POST",
        data: { func: "getUserById", id: id },
        dataType: "json",
      });
      console.log(" Phản hồi getUserById:", response);
      
      return response;
    } catch (error) {
      console.log("Lỗi khi lấy dữ liệu người dùng", error);
      return null;
    }
  }

$(".main-content").on("click", ".action-item", function (e) {
    e.preventDefault();
    let action = $(this).data("act");
    let id = $(this).data("id");
    console.log("Action:", action, "ID:", id);
   
   
  });
  $(function (){
    window.HSStaticMethods.autoInit();
    (async () =>{
      const urlParams =new URLSearchParams(window.location.search);
  
      const currentuserId = urlParams.get('id');
      console.log(" ID lấy từ URL:", currentuserId);
      const res = await getUserById(currentuserId);
      const defaultData = res?.data;

      const nhomKsList = await getNhomKs();
      const LoaidtList = await getAllLoaidt();
      const ctdtList = await getAllCTDT();
  
  
      
      if (LoaidtList != null) {
        $("#loai-doituong").empty();
        LoaidtList.forEach((item) => {
          console.log("Loại đối tượng item:", item);
          $("#loai-doituong").append(`
            <option value='${item.dt_id}' ${item.dt_id == defaultData.dt_id ? "selected" : ""}>
              ${item.ten_dt}
            </option>
          `);
        });
      }
  
      if (nhomKsList != null) {
        $("#nhom-ks").empty();
        nhomKsList.forEach((item) => {
          $("#nhom-ks").append(`
            <option value='${item.nks_id}' ${item.nks_id == defaultData.nks_id ? "selected" : ""}>
              ${item.ten_nks}
            </option>
          `);
        });
      }
     
      if (ctdtList != null) {
        ctdtList.map((item) => {
          $("#ctdt_id").append(
            `<option value='${item.ctdt_id}'>${item.ten_nganh} - ${item.ten_ck}</option>`
          );
        });
      }
     
    $("#ho_ten").val(defaultData.ho_ten);
    $("#email").val(defaultData.email);
    $("#diachi").val(defaultData.diachi);
    $("#dien_thoai").val(defaultData.dien_thoai);
    $("#ctdt_id").val(defaultData.ctdt_id);
    $("#nhom-ks").val(defaultData.nhom_ks);
    $("#loai-doituong").val(defaultData.loai_dt_id);
    function validate(data) {
      let message = '';

      // Kiểm tra họ tên
      if (!data.ho_ten || data.ho_ten.trim() === '') {
        message = "Họ tên không được để trống!";
      } else if (/[^a-zA-ZÀ-Ỹà-ỹ\s]/.test(data.ho_ten.trim())) {
        message = "Họ tên không được chứa số hoặc ký tự đặc biệt!";
      }

      // Kiểm tra email
      else if (!data.email || data.email.trim() === '') {
        message = "Email không được để trống!";
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email.trim())) {
        message = "Email không đúng định dạng!";
      }

      // Kiểm tra địa chỉ
      else if (!data.diachi || data.diachi.trim() === '') {
        message = "Địa chỉ không được để trống!";
      } else if (/[^\p{L}\p{N}\s,.-]/u.test(data.diachi.trim())) {
        message = "Địa chỉ không được chứa ký tự đặc biệt!";
      }

      // Kiểm tra điện thoại
      else if (!data.dien_thoai || data.dien_thoai.trim() === '') {
        message = "Số điện thoại không được để trống!";
      } else if (!/^0\d{9}$/.test(data.dien_thoai.trim())) {
        message = "Số điện thoại phải có 10 chữ số và bắt đầu bằng 0!";
      }

      // Nếu có lỗi, hiển thị cảnh báo
      if (message !== '') {
        Swal.fire({
          title: 'Thông báo',
          text: message,
          icon: 'warning',
          confirmButtonText: 'Thử lại'
        });
        return false;
      }

      return true;
    }
    $("#btn-save-doituong").on("click", async function (e) {
      Swal.fire({
                title: 'Bạn có chắc chắn muốn sửa đối tượng?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có, sửa ngay',
                cancelButtonText: 'Không',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then( async (result) => {
                if (result.isConfirmed) {

                e.preventDefault();

                const ho_ten = $("#ho_ten").val().trim();
                const email = $("#email").val().trim();
                const diachi = $("#diachi").val().trim();
                const dien_thoai = $("#dien_thoai").val().trim();
                const nhom_ks = $("#nhom-ks").val();
                const loai_dt_id = $("#loai-doituong").val();
                const ctdt_id = $("#ctdt_id").val();

                const urlParams = new URLSearchParams(window.location.search);
                const userId = urlParams.get("id"); // Lấy id từ URL

                // Kiểm tra dữ liệu
                if (!ho_ten || !email || !diachi || !dien_thoai || nhom_ks == "-1" || loai_dt_id == "-1" || ctdt_id == "-1") {
                  Swal.fire({
                    title: 'Thông báo',
                    text: 'Vui lòng nhập đầy đủ thông tin',
                    icon: 'warning',
                    confirmButtonText: 'Thử lại'
                  });
                  return;
                }

                const data = {
                  id: userId,
                  ho_ten: ho_ten,
                  email: email,
                  diachi: diachi,
                  dien_thoai: dien_thoai,
                  nhom_ks: nhom_ks, //nhom-ks-id
                  loai_dt_id: loai_dt_id,
                  ctdt_id: ctdt_id,
                };

                if (validate(data)) {
                  console.log("Dữ liệu gửi đi:", data);
                  const result = await updateUser(data);
                  if (result && result.success) {
                    Swal.fire({
                      title: 'Cập nhật thành công!',
                      icon: 'success',
                      showCancelButton: true,
                      confirmButtonText: 'Tiếp tục',
                      cancelButtonText: 'Hủy',
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33'
                    }).then((res) => {
                      if (res.isConfirmed) {
                        window.location.href = "./admin.php?page=qlUserPage";
                      }

                    });

                  } else {
                    Swal.fire({
                      title: 'Cập nhật đối tượng thất bại!',
                      icon: 'error',
                      showCancelButton: false,
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'Thử lại',
                    });
                  }
                }

              }
            });
    });
  })();
});
  