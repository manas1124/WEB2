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
async function getUserById(id) {
  try {
    const response = await $.ajax({
      url: "./controller/UserController.php",
      type: "POST",
      data: { func: "getUserById", id: id },
      dataType: "json",
    });
    return response;
  } catch (error) {
    console.log("Lỗi khi lấy dữ liệu người dùng", error);
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
  async function addUser(data) {
    try {
      const response = await $.ajax({
        url: "./controller/UserController.php",
        type: "POST",
        data: { func: "addUser", data: JSON.stringify(data) },
        dataType: "json",
      });
      if (response.error) {
        console.log("fect", response.error);
      }
      console.log("fect", response);
      return response;
    } catch (error) {
      console.log(error);
      console.log("loi  tao khao sat");
      return false;
    }
  }
  $(function (){
    window.HSStaticMethods.autoInit();
    (async () =>{
      const urlParams =new URLSearchParams(window.location.search);
  
      const currentuserId = urlParams.get('id');
      const defaultData = await getUserById(currentuserId);
      const nhomKsList = await getNhomKs();
      const LoaidtList = await getAllLoaidt();
      const ctdtList = await getAllCTDT();
  
      if (LoaidtList !=null) {
        LoaidtList.map((item) =>{
          $("#loai-doituong").append(
            `<option value='${item.dt_id}'>${item.ten_dt}</option>`
          ) 
        });
      }
      if (nhomKsList !=null) {
        nhomKsList.map((item) =>{
          $("#nhom-ks").append(
            `<option value='${item.nks_id}'>${item.ten_nks}</option>`
          )
        })
      }
      
    if (ctdtList != null) {
      ctdtList.map((item) => {
        $("#ctdt").append(
          `<option value='${item.ctdt_id}'>${item.ten_nganh} - ${item.ten_ck}</option>`
        );
      });
    }
    function validateData() {
      let isValid = true;
    
     
      $(".error-msg").remove();
    

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
   
      const phoneRegex = /^[0-9]{10,11}$/;
    

     
      const email = $("#email").val().trim();
     
      const dienThoai = $("#dien_thoai").val().trim();
     
      
      if (email !== "" && !emailRegex.test(email)) {
        $("#email").after(`<span class='error-msg' style='color:red'>Email không hợp lệ.</span>`);
        isValid = false;
      }
    
      if (dienThoai !== "" && !phoneRegex.test(dienThoai)) {
        $("#dien_thoai").after(`<span class='error-msg' style='color:red'>Số điện thoại không hợp lệ (10-11 số).</span>`);
        isValid = false;
      }
    
      return isValid;
    }
  
      $("#btn-save-doituong").click(async function() {
        if (!validateData()) {
          return;
        }
        const data = {
            ho_ten: $("#ho_ten").val(),
            email: $("#email").val(),
            diachi: $("#diachi").val(),
            dien_thoai: $("#dien_thoai").val(),
            nhom_ks: $("#nhom-ks").val(),
            loai_dt_id: $("#loai-doituong").val(),
            ctdt_id: $("#ctdt").val()
        };

       
        const result = await addUser(data);

        
        if (result && result.success) {
            alert("Đối tượng đã được thêm thành công.");
        } else {
            alert("Có lỗi khi thêm đối tượng.");
        }
    });
  
      
      
  })();
  });
  