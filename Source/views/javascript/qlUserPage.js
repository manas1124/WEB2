
  window.HSStaticMethods.autoInit(); // Phải dùng câu lệnh này để dùng lại JS component

  async function getAllUser(search = "",nhomKsId = "") {
    try {
      const response = await $.ajax({
        url: "./controller/UserController.php",
        type: "POST",
        data: { func: "getAllUser", search: search ,nhomKsId: nhomKsId}, // Gửi từ khóa tìm kiếm
        dataType: "json",
      });
      return response;
    } catch (error) {
      console.log("Lỗi khi lấy dữ liệu từ getAllUser", error);
      return null;
    }
  }
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
        data: JSON.stringify({ func: "getUserById", data: { dt_id: 1 } }),
        dataType: "json",
      });
      return { data: response , error: null}; 
    } catch (error) {
      console.log("Lỗi khi lấy dữ liệu người dùng", error);
      return null;
    }
  }

  async function deleteUser(id) {
    console.log("Deleting user with ID:", id);
    try {
      const response = await $.ajax({
        url: "./controller/UserController.php",
        type: "POST",
        data: { func: "deleteUser", id: id }, 
        dataType: "json",
      });
    
      if (response.success) {
        alert("xóa thất bại"); 
        
      } else {
        alert("xóa thành công"); 
        loadUserList();
      }
    } catch (error) {
      console.log("Lỗi khi xóa người dùng");
      
    }
  }
  
  async function loadNhomKsToSelect() {
    const nhomKsList = await getNhomKs(); 
    const selectElement = $("#nhom-ks-select"); 
  
    selectElement.empty(); 
    selectElement.append('<option value="">Tất cả</option>'); 
    if (nhomKsList != null) {
      nhomKsList.map((item) => {
        selectElement.append(`
          <option value="${item.nks_id}">${item.ten_nks}</option>
        `);
      });
    } else {
      selectElement.append('<option value="">Không có nhóm khảo sát</option>');
    }
}
  
async function loadNhomKsToSelectModal() {
  const nhomKsList = await getNhomKs(); 
  const selectElement = $("#nhom-ks-select-modal"); 

  selectElement.empty(); 
  selectElement.append('<option value="">Tất cả</option>'); 
  if (nhomKsList != null) {
    nhomKsList.map((item) => {
      selectElement.append(`
        <option value="${item.nks_id}">${item.ten_nks}</option>
      `);
    });
  } else {
    selectElement.append('<option value="">Không có nhóm khảo sát</option>');
  }
}
  
  // function loadUserList() {
    
  
  //   const searchKeyword = $("#search").val();
  //   getAllUser(searchKeyword).then((ksList) => {
  //     $("#user-list").empty(); // Xóa dữ liệu cũ trong bảng
  //     if (ksList != null) {
  //       ksList.map((item) => {
  //         $("#user-list").append(`
  //           <tr>
  //             <td>${item.ho_ten}</td>
  //             <td>${item.email}</td>
  //             <td>${item.diachi}</td>
  //             <td>${item.dien_thoai}</td>
  //             <td>
  //               ${item.loai_dt_id == 1
  //                 ? '<span class="badge badge-soft badge-success">Sinh viên</span>'
  //                 : item.loai_dt_id == 2
  //                 ? '<span class="badge badge-soft badge-warning">Giảng viên</span>'
  //                 : item.loai_dt_id == 3
  //                 ? '<span class="badge badge-soft badge-danger">Doanh nghiệp</span>'
  //                 : '<span class="badge badge-soft badge-secondary">Không rõ</span>'
  //               }
  //             </td> 
  //               <td>${item.ten_nks ?? "Không rõ"}</td>
  //             <td>
  //               <button class="action-item btn btn-circle btn-text btn-sm "data-act="user-sua" aria-label="Action button " data-id="${item.dt_id}" >
  //               <span class="icon-[tabler--pencil] size-5"></span>
  //               </button>
  //               <button onclick="deleteUser(${item.dt_id})" class="btn btn-circle btn-text btn-sm" aria-label="Action button" >
  //               <span class="icon-[tabler--trash] size-5"></span>
  //               </button>
                
  //             </td>
  //           </tr>
  //         `);
  //       });
  //     }
  //   });
  // }
  async function loadUserList() {
    const searchKeyword = $("#search").val(); 
    const nhomKsId = $("#nhom-ks-select").val(); 
    
    console.log("Search:", searchKeyword);
    console.log("Nhóm khảo sát ID:", nhomKsId);
    
   
    getAllUser(searchKeyword, nhomKsId).then((ksList) => {
      console.log("User list:", ksList);
      $("#user-list").empty(); 
      if (ksList != null) {
        ksList.map((item) => {
          $("#user-list").append(`
            <tr>
              <td>${item.ho_ten}</td>
              <td>${item.email}</td>
              <td>${item.diachi}</td>
              <td>${item.dien_thoai}</td>
              <td>
                ${item.loai_dt_id == 1
                  ? '<span class="badge badge-soft badge-success">Sinh viên</span>'
                  : item.loai_dt_id == 2
                  ? '<span class="badge badge-soft badge-warning">Giảng viên</span>'
                  : item.loai_dt_id == 3
                  ? '<span class="badge badge-soft badge-danger">Doanh nghiệp</span>'
                  : '<span class="badge badge-soft badge-secondary">Không rõ</span>'
                }
              </td> 
              <td>${item.ten_nks?? "Không rõ"}</td>
              <td>
                <button class="action-item btn btn-circle btn-text btn-sm" data-act="user-sua" aria-label="Action button" data-id="${item.dt_id}">
                  <span class="icon-[tabler--pencil] size-5"></span>
                </button>
                <button onclick="deleteUser(${item.dt_id})" class="btn btn-circle btn-text btn-sm" aria-label="Action button">
                  <span class="icon-[tabler--trash] size-5"></span>
                </button>
              </td>
            </tr>
          `);
        });
      }
    });
}
  
  $(function () {
    loadUserList();
    loadNhomKsToSelect();
    loadNhomKsToSelectModal();


    $("#search").on("input", function () {
      loadUserList(); 
    });
  
    $("#nhom-ks-select").on("change", function () {
      loadUserList(); 
    });
    $("#download-excel-templat").on("click", function () {
      window.location.href = "./assets/sample_user.xlsx"; 
    });


    $("#input-file-excel").on("change", function () {
      const file = this.files[0];
      if (!file) return;

      const allowedExtensions = ["xlsx", "xls"];
      const fileExtension = file.name.split(".").pop().toLowerCase();
      if (!allowedExtensions.includes(fileExtension)) {
        alert("Chỉ chấp nhận file Excel (.xlsx hoặc .xls)");
        return;
      }
    
      // Gửi file lên server qua Ajax
      const formData = new FormData();
      formData.append("func", "importExcel");
      formData.append("file", file);
    
      $.ajax({
        url: "./controller/UserController.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
          // Có thể thêm hiệu ứng loading tại đây
          console.log("Đang gửi file lên server...");
        },
        success: function (res) {
          let response;
          try {
            response = JSON.parse(res);
          } catch (e) {
            alert("Phản hồi từ server không hợp lệ.");
            return;
          }
    
          if (response.success) {
            alert("Import thành công!");
            loadUserList(); // Reload danh sách user
            $("#input-file-excel").val(""); // Reset input file
          } else {
            alert("Import thất bại: " + (response.message || "Lỗi không xác định"));
          }
        },
        error: function (xhr, status, error) {
          console.error("Lỗi khi gửi file:", error);
          alert("Có lỗi xảy ra khi gửi file.");
        }
      });
    });


    $(".main-content").on("click", ".action-item", function (e) {
      e.preventDefault();
      let action = $(this).data("act");
      let id = $(this).data("id");
      console.log("Action:", action, "ID:", id);
    
    
    });
  });



