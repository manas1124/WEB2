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
      console.log("📦 Dữ liệu user:", defaultData);
      const nhomKsList = await getNhomKs();
      const LoaidtList = await getAllLoaidt();
      
  
      
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
     
    $("#ho_ten").val(defaultData.ho_ten);
    $("#email").val(defaultData.email);
    $("#diachi").val(defaultData.diachi);
    $("#dien_thoai").val(defaultData.dien_thoai);
    $("#ctdt_id").val(defaultData.ctdt_id);

    $("#btn-save-doituong").on("click", async function (e) {
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
        alert("Vui lòng nhập đầy đủ thông tin.");
        return;
      }
    
      const data = {
        id: userId,
        ho_ten: ho_ten,
        email: email,
        diachi: diachi,
        dien_thoai: dien_thoai,
        nks_id: nhom_ks,
        dt_id: loai_dt_id,
        ctdt_id: ctdt_id,
      };
      console.log("Dữ liệu gửi đi:", data);
      const result = await updateUser(data);
      if (result && result.success) {
        alert("Cập nhật thành công!");
       
      } else {
        alert("Cập nhật thất bại. Vui lòng thử lại.");
      }
    });
  })();
});
  